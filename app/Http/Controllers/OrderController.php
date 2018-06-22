<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Payment;
use DB;

class OrderController extends Controller
{
    public function index()
    {
        $student = Student::orderBy('created_at', 'DESC');
        if (request()->q == 'inactive') {
            $student = $student->where('active', 0)->paginate(10);
        } elseif (request()->q == '>2') {
            $student = $student->withCount('detail')
                ->has('detail', '>', 2)    
                ->paginate(10);
        } elseif (request()->q == 'unpaid') {
            $student = $student->with(['payment' => function($q) {
                $q->where('status', 0);
            }])->paginate(10);
        } else {
            $student = $student->paginate(10);
        }
        return view('order.index', compact('student'));
    }

    public function acceptOrder()
    {
        $payment = Payment::with('student', 'detail');
        if (request()->q == 'paid') {
            $payment = $payment->where('status', 1)->paginate(10);
        } elseif (request()->q == 'high') {
            $payment = $payment->where('status', 1)->orderBy('amount', 'DESC')->paginate(10);
        } else {
            $payment = $payment->where('status', 0)->paginate(10);
        }
        return view('order.accept', compact('payment'));
    }

    public function changeStatus($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => true
        ]);
        return redirect()->back();
    }
}
