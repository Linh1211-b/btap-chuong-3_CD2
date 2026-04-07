<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount(['lessons', 'enrollments'])->with(['lessons', 'enrollments']);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['draft', 'published'], true)) {
            $query->where('status', $request->status);
        }

        $minPrice = $request->input('price_min');
        $maxPrice = $request->input('price_max');
        if ($minPrice !== null || $maxPrice !== null) {
            $query->priceBetween($minPrice ? floatval($minPrice) : null, $maxPrice ? floatval($maxPrice) : null);
        }

        $sort = $request->input('sort_by');
        if ($sort === 'price_asc') {
            $query->orderBy('price');
        } elseif ($sort === 'price_desc') {
            $query->orderByDesc('price');
        } elseif ($sort === 'students_asc') {
            $query->orderBy('enrollments_count');
        } elseif ($sort === 'students_desc') {
            $query->orderByDesc('enrollments_count');
        } elseif ($sort === 'created_asc') {
            $query->orderBy('created_at');
        } else {
            $query->orderByDesc('created_at');
        }

        $courses = $query->paginate(8)->withQueryString();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
        }

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Khóa học đã được tạo thành công.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name'], $course->id);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
            if ($course->image && file_exists(public_path($course->image))) {
                @unlink(public_path($course->image));
            }
        }

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Khóa học đã được cập nhật.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Khóa học đã được xóa (soft delete).');
    }

    public function trashed()
    {
        $courses = Course::onlyTrashed()->withCount(['lessons', 'enrollments'])->paginate(8);

        return view('courses.index', compact('courses'));
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->route('courses.index')->with('success', 'Khóa học đã được khôi phục.');
    }

    protected function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $count = 1;

        while (Course::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }

    protected function storeImage($file): string
    {
        $folder = public_path('uploads/courses');
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
        $file->move($folder, $filename);

        return 'uploads/courses/' . $filename;
    }
}
