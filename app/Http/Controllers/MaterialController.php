<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\CourseClass;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $materialId)
    {
        $user = Auth::user();

        $enrollment = ClassEnrollment::where('student_id', $user->id)
            ->where('class_id', $id)
            ->firstOrFail();

        $class = CourseClass::with('course')->findOrFail($id);
        $material = Material::findOrFail($materialId);

        $isMaterialInClass = $class->materials()->where('materials.id', $materialId)->exists();
        if (!$isMaterialInClass) {
            abort(403, 'Materi ini tidak termasuk dalam kelas yang Anda ikuti.');
        }

        $classMaterial = $class->classMaterials()->where('material_id', $materialId)->first();
        $isLocked = $classMaterial && $classMaterial->schedule_date && now() < $classMaterial->schedule_date;

        if ($isLocked) {
            return view('student.material.locked', compact('class', 'material', 'classMaterial'));
        }

        return view('student.material.materi', compact('class', 'material', 'enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
