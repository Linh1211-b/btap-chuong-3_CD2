<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->get();

        return view('lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        return view('lessons.create', compact('course'));
    }

    public function store(LessonRequest $request, Course $course)
    {
        $course->lessons()->create($request->validated());

        return redirect()->route('courses.lessons.index', $course)->with('success', 'Bài học đã được tạo.');
    }

    public function edit(Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson'));
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return redirect()->route('courses.lessons.index', $lesson->course)->with('success', 'Bài học đã được cập nhật.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('courses.lessons.index', $lesson->course)->with('success', 'Bài học đã được xóa.');
    }
}
