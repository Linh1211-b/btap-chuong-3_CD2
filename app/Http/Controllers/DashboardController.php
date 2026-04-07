<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $totalStudents = Student::count();
        $totalRevenue = Enrollment::join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->sum('courses.price');

        $topCourse = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->first();

        $recentCourses = Course::withCount(['enrollments', 'lessons'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $courses = Course::withCount(['enrollments', 'lessons'])->orderByDesc('enrollments_count')->get();

        return view('dashboard', compact(
            'totalCourses',
            'totalStudents',
            'totalRevenue',
            'topCourse',
            'recentCourses',
            'courses'
        ));
    }
}
