@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">Bài học của khóa: {{ $course->name }}</h2>
                <p class="text-sm text-slate-500">Danh sách bài học theo thứ tự và khóa học hiện tại.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('courses.lessons.create', $course) }}" class="button button-primary">Thêm bài học</a>
                <a href="{{ route('courses.index') }}" class="button button-secondary">Quay lại khóa học</a>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Thứ tự</th>
                            <th class="px-4 py-3">Tiêu đề</th>
                            <th class="px-4 py-3">Video URL</th>
                            <th class="px-4 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($lessons as $lesson)
                            <tr>
                                <td class="px-4 py-4">{{ $lesson->order }}</td>
                                <td class="px-4 py-4">{{ $lesson->title }}</td>
                                <td class="px-4 py-4">{{ $lesson->video_url ?: '-' }}</td>
                                <td class="px-4 py-4 space-x-2">
                                    <a href="{{ route('lessons.edit', $lesson) }}" class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700">Sửa</a>
                                    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-sm text-rose-700" onclick="return confirm('Bạn có chắc muốn xóa bài học?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">Chưa có bài học nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
