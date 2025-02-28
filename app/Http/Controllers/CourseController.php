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

    // Create a new course with thumbnail upload
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        // Handle file upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailName = time() . rand(1111, 9999) . '.' . $request->thumbnail->extension();
            $thumbnailPath = public_path('/course-thumbnails'); // Folder for thumbnails
            $request->thumbnail->move($thumbnailPath, $thumbnailName);
            $thumbnailPath = '/course-thumbnails/' . $thumbnailName; // Save relative path
        }

        // Create course with thumbnail path
        $courseData = $request->all();
        $courseData['thumbnail'] = $thumbnailPath; // Store thumbnail path

        $course = Course::create($courseData);
        return response()->json($course, 201); // Return the created course
    }

    // Update an existing course with thumbnail update
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional for update
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        // Handle new file upload if present
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
                unlink(public_path($course->thumbnail)); // Remove the old file
            }

            $thumbnailName = time() . rand(1111, 9999) . '.' . $request->thumbnail->extension();
            $thumbnailPath = public_path('/course-thumbnails'); // Folder for thumbnails
            $request->thumbnail->move($thumbnailPath, $thumbnailName);
            $thumbnailPath = '/course-thumbnails/' . $thumbnailName; // Save relative path

            $course->thumbnail = $thumbnailPath; // Update the thumbnail path
        }

        // Update other fields
        $course->update($request->except(['thumbnail'])); // Exclude thumbnail from normal update

        return response()->json($course, 200); // Return updated course
    }

    // Delete a course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete the thumbnail if exists
        if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
            unlink(public_path($course->thumbnail)); // Remove the file from storage
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
