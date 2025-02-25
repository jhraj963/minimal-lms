<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // Get all modules of a specific course
    public function index($courseId)
    {
        return Module::where('course_id', $courseId)->get();
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

        return $module;
    }

    // Update a module
    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->update($request->all());
        return $module;
    }

    // Delete a module
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();
        return response()->json(['message' => 'Module deleted successfully']);
    }
}
