<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModuleController extends Controller
{
    // Get all modules of a specific course
    public function index($courseId)
    {
        return Module::where('course_id', $courseId)->get();
    }

    // Get a single module (for editing)
    public function show($courseId, $moduleId)
    {
        $module = Module::where('id', $moduleId)
            ->where('course_id', $courseId)
            ->first();

        if (!$module) {
            return response()->json(['message' => 'Module not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($module, Response::HTTP_OK);
    }

    // Create a new module for a specific course
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required',
            'module_number' => 'required|integer',
        ]);

        $module = new Module($request->all());
        $module->course_id = $courseId;
        $module->save();

        return response()->json($module, Response::HTTP_CREATED);
    }

    // Update a module
    public function update(Request $request, $courseId, $moduleId)
    {
        $module = Module::where('id', $moduleId)
            ->where('course_id', $courseId)
            ->first();

        if (!$module) {
            return response()->json(['message' => 'Module not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'title' => 'required',
            'module_number' => 'required|integer',
        ]);

        $module->update($request->all());

        return response()->json($module, Response::HTTP_OK);
    }

    // Delete a module
    public function destroy($courseId, $moduleId)
    {
        $module = Module::where('id', $moduleId)
            ->where('course_id', $courseId)
            ->first();

        if (!$module) {
            return response()->json(['message' => 'Module not found'], Response::HTTP_NOT_FOUND);
        }

        $module->delete();

        return response()->json(['message' => 'Module deleted successfully'], Response::HTTP_OK);
    }
}
