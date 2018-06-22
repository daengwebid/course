<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Instructor;

class CourseController extends Controller
{
    public function index()
    {
        $course = Course::orderBy('created_at', 'DESC')->paginate(10);
        return view('course.index', compact('course'));
    }

    public function create()
    {
        $instructor = Instructor::orderBy('name', 'ASC')->get();
        return view('course.create', compact('instructor'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'price' => 'required|integer'
        ]);

        $course = Course::firstOrCreate([
            'name' => $request->name
        ],[
            'user_id' => auth()->user()->id,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return redirect(route('course.index'))->with(['success' => 'Course: <strong>' . $course->name . '</strong> Added']);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $instructor = Instructor::orderBy('name', 'ASC')->get();
        return view('course.edit', compact('course', 'instructor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'price' => 'required|integer'
        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return redirect(route('course.index'))->with(['success' => 'Course: <strong>' . $course->name . '</strong> Updated']);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect(route('course.index'))->with(['success' => 'Course: <strong>' . $course->name . '</strong> Added']);
    }
}
