<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Get all courses
    public function index()
    {
        return Course::all();
    }

    // Get a single course
    public function show($id)
    {
        return Course::findOrFail($id);
    }

    // Create a new course
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        return Course::create($request->all());
    }

    // Update an existing course
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return $course;
    }

    // Delete a course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
