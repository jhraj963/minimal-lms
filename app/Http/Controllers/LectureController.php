<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    // Get all lectures of a specific module
    public function index($moduleId)
    {
        return Lecture::where('module_id', $moduleId)->get();
    }

    // Create a new lecture for a specific module
    public function store(Request $request, $moduleId)
    {
        $request->validate([
            'title' => 'required',
            'video_url' => 'required|url',
            'pdf_notes' => 'nullable',
            // 'pdf_notes' => 'nullable|array',
        ]);

        $lecture = new Lecture($request->all());
        $lecture->module_id = $moduleId;
        $lecture->save();

        return $lecture;
    }

    // Update a lecture
    public function update(Request $request, $id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->update($request->all());
        return $lecture;
    }

    // Delete a lecture
    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();
        return response()->json(['message' => 'Lecture deleted successfully']);
    }
}
