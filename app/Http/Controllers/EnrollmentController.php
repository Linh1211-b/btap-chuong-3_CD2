<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['course', 'student']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('q')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        $enrollments = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        $courses = Course::published()->orderBy('name')->get();

        return view('enrollments.index', compact('enrollments', 'courses'));
    }

    public function create()
    {
        $courses = Course::published()->orderBy('name')->get();

        return view('enrollments.create', compact('courses'));
    }

    public function store(EnrollmentRequest $request)
    {
        $data = $request->validated();

        $student = Student::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name']]
        );

        Enrollment::firstOrCreate([
            'course_id' => $data['course_id'],
            'student_id' => $student->id,
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Học viên đã đăng ký thành công.');
    }
}
