<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instructor;

class InstructorController extends Controller
{
    public function index()
    {
        $instructor = Instructor::orderBy('created_at', 'DESC');
        if (!empty(request()->q)) {
            $instructor = $instructor->where('gender', request()->q)->paginate(10);
        } else {
            $instructor = $instructor->paginate(10);
        }
        return view('instructor.index', compact('instructor'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'gender' => 'required'
        ]);

        $instructor = Instructor::firstOrCreate([
            'name' => $request->name
        ], [
            'gender' => $request->gender
        ]);
        return redirect()->back()->with(['success' => '<strong>' . $instructor->name . '</strong> Has been Added']);
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('instructor.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'gender' => 'required'
        ]);

        $instructor = Instructor::findOrFail($id);
        $instructor->update([
            'name' => $request->name,
            'gender' => $request->gender
        ]);
        return redirect(route('instructor.index'))->with(['success' => '<strong>' . $instructor->name . '</strong> Has been updated']);
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();
        return redirect()->back()->with(['success' => '<strong>' . $instructor->name . '</strong> Has been deleted']);
    }
}
