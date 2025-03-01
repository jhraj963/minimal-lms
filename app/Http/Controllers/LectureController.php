<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LectureController extends Controller
{
    public function index($moduleId)
    {
        return Lecture::where('module_id', $moduleId)->get();
    }

    public function store(Request $request, $courseId, $moduleId)
    {
        $request->validate([
            'title' => 'required|string',
            'video_url' => 'required|url',
            'pdf_notes' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $lecture = new Lecture();
        $lecture->title = $request->title;
        $lecture->video_url = $request->video_url;
        $lecture->module_id = $moduleId;

        if ($request->hasFile('pdf_notes')) {
            $pdfPath = $request->file('pdf_notes')->store('pdfs', 'public');
            $lecture->pdf_notes = $pdfPath;
        }

        $lecture->save();

        return response()->json([
            'message' => 'Lecture added successfully!',
            'lecture' => $lecture
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $lecture = Lecture::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string',
            'video_url' => 'sometimes|required|url',
            'pdf_notes' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $lecture->title = $request->title ?? $lecture->title;
        $lecture->video_url = $request->video_url ?? $lecture->video_url;

        if ($request->hasFile('pdf_notes')) {
            if ($lecture->pdf_notes) {
                Storage::disk('public')->delete($lecture->pdf_notes);
            }

            $pdfPath = $request->file('pdf_notes')->store('pdfs', 'public');
            $lecture->pdf_notes = $pdfPath;
        }

        $lecture->save();

        return response()->json([
            'message' => 'Lecture updated successfully!',
            'lecture' => [
                'id' => $lecture->id,
                'title' => $lecture->title,
                'video_url' => $lecture->video_url,
                'pdf_notes' => $lecture->pdf_notes ? asset('storage/' . $lecture->pdf_notes) : null,
                'module_id' => $lecture->module_id,
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);

        if ($lecture->pdf_notes) {
            Storage::disk('public')->delete($lecture->pdf_notes);
        }

        $lecture->delete();

        return response()->json(['message' => 'Lecture deleted successfully']);
    }
}
