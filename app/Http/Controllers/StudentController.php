<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.index', [
            'students' => Student::latest()->get(),
            'page' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')
                ->store('student-photos', 'public');
        }

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('students.index', [
            'students' => Student::latest()->get(),
            'student' => $student,
            'page' => 'show',
        ]);
    }

    public function edit(Student $student)
    {
        return view('students.index', [
            'students' => Student::latest()->get(),
            'student' => $student,
            'page' => 'edit',
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }

            $validated['profile_image'] = $request->file('profile_image')
                ->store('student-photos', 'public');
        }

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->status = 'deleted';
        $student->save();

        return redirect()->route('students.index')
            ->with('success', 'Student moved to deleted students.');
    }

    public function deleted()
    {
        $students = Student::where('status', 'deleted')
            ->latest()
            ->get();

        return view('students.index', [
            'students' => $students,
            'page' => 'deleted',
        ]);
    }

    public function restore($id)
    {
        $student = Student::findOrFail($id);

        if ($student->status !== 'deleted') {
            return redirect()->route('students.index')
                ->with('success', 'Student is already active.');
        }

        $student->status = 'active';
        $student->save();

        return redirect()->route('students.deleted')
            ->with('success', 'Student restored successfully.');
    }
}
