@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="form-heading">Đăng ký học viên</h2>
            <p class="form-subtitle">Chọn khóa học và điền thông tin học viên để đăng ký.</p>
        </div>

        <div class="form-card">
            <form action="{{ route('enrollments.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="form-label">Khóa học</label>
                    <select name="course_id" class="form-control">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="form-label">Tên học viên</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập tên học viên" />
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Nhập email" />
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="button button-primary">Đăng ký</button>
                    <a href="{{ route('enrollments.index') }}" class="button button-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
