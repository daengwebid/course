<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Course;
use Auth;
use App\Payment;
use App\Payment_detail;

class StudentController extends Controller
{
    public function logout()
    {
        auth()->guard('student')->logout();
        return redirect(route('student.register'));
    }

    public function showFormLogin()
    {
        return view('student.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:students,email',
            'password' => 'required'
        ]);

        if (auth()->guard('student')->attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            return redirect(route('student.dashboard'));
        }
        return redirect()->back()->with(['error' => 'Password Invalid']);
    }
    
    public function register()
    {
        return view('student.register');   
    }

    public function registered(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6',
            'gender' => 'required'
        ]);

        $student = Student::firstOrCreate([
            'email' => $request->email
        ], [
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'active' => true
        ]);
        Auth::guard('student')->login($student);
        return redirect(route('student.dashboard'));
    }

    public function dashboard()
    {
        $course = Course::orderBy('name', 'ASC')->get();
        return view('student.home', compact('course'));
    }

    public function enrollCourse(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required'
        ]);

        $payment = Payment::create([
            'code' => $this->generateCode(),
            'student_id' => auth()->guard('student')->user()->id,
            'amount' => 0,
            'date' => \Carbon\Carbon::now()->format('Y-m-d'),
            'status' => false
        ]);
        
        $amount = 0;
        foreach ($request->course_id as $course_id) {
            $course = Course::findOrFail($course_id);
            $amount += $course->price;
            Payment_detail::create([
                'payment_id' => $payment->id,
                'course_id' => $course_id
            ]);
        }

        $payment->update([
            'amount' => $amount
        ]);

        return redirect()->back()->with(['success' => 'Payment Code: #' . $payment->code]);
    }

    public function generateCode()
    {
        $payment = Payment::orderBy('created_at', 'DESC');
        if ($payment->get()->count() > 0) {
            $payment = $payment->first();
            $explode = explode('-', $payment->code);
            $code = str_random(10) . '-' . $explode[1] + 1;
            return $code;
        }
        return str_random(10) . '-1';
    }

    public function myCourse()
    {
        $payment = Payment::where('student_id', auth()->guard('student')->user()->id)
            ->withCount('detail')
            ->paginate(10);
        return view('student.my_course', compact('payment'));
    }
}
