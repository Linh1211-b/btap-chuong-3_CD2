@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="form-heading">Sửa bài học</h2>
            <p class="form-subtitle">Cập nhật nội dung và thứ tự bài học.</p>
        </div>

        <div class="form-card">
            <form action="{{ route('lessons.update', $lesson) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="form-control" placeholder="Nhập tiêu đề bài học" />
                </div>

                <div>
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" rows="6" class="form-control" placeholder="Nhập nội dung bài học">{{ old('content', $lesson->content) }}</textarea>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="form-label">Video URL</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" class="form-control" placeholder="https://" />
                    </div>
                    <div>
                        <label class="form-label">Thứ tự</label>
                        <input type="number" name="order" value="{{ old('order', $lesson->order) }}" min="1" class="form-control" />
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="button button-primary">Cập nhật</button>
                    <a href="{{ route('courses.lessons.index', $lesson->course) }}" class="button button-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
