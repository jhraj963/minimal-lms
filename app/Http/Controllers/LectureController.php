<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{

    public function index($moduleId)
    {
        return Lecture::where('module_id', $moduleId)->get();
    }

    public function store(Request $request,
        $courseId,
        $moduleId
    ) {
        $request->validate([
            'title' => 'required|string',
            'video_url' => 'required|url',
            'pdf_notes' => 'nullable|string',
        ]);

        $lecture = new Lecture();
        $lecture->title = $request->title;
        $lecture->video_url = $request->video_url;
        $lecture->pdf_notes = $request->pdf_notes;
        $lecture->module_id = $moduleId;
        $lecture->save();

        return response()->json(['message' => 'Lecture added successfully!', 'lecture' => $lecture], 201);
    }

    // Update lecture
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
