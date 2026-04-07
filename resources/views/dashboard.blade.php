@extends('layouts.master')

@section('content')
    <div class="main-panel">
        <div class="page-title">
            <div>
                <h1>Dashboard</h1>
                <p class="form-subtitle">Tổng quan hoạt động quản lý khóa học và học viên.</p>
            </div>
        </div>

        <div class="metric-grid">
            <div class="metric-card metric-primary">
                <div>
                    <h3>Tổng khóa học</h3>
                    <p>{{ $totalCourses }}</p>
                </div>
            </div>
            <div class="metric-card metric-success">
                <div>
                    <h3>Tổng học viên</h3>
                    <p>{{ $totalStudents }}</p>
                </div>
            </div>
            <div class="metric-card metric-warning">
                <div>
                    <h3>Tổng doanh thu (ước tính)</h3>
                    <p>{{ number_format($totalRevenue, 0, ',', '.') }} ₫</p>
                </div>
            </div>
            <div class="metric-card metric-info">
                <div>
                    <h3>Khóa học hot nhất</h3>
                    <p class="text-xl font-semibold">{{ $topCourse?->name ?? 'Chưa có' }}</p>
                    @if($topCourse)
                        <span class="badge-pill">{{ $topCourse->enrollments_count }} học viên</span>
                    @endif
                </div>
            </div>
        </div>

        <section class="section-card">
            <div class="section-header">
                <div>
                    <h2>5 khóa học mới nhất</h2>
                    <p class="form-subtitle">Danh sách các khóa học mới tạo gần đây.</p>
                </div>
                <a href="{{ route('courses.index') }}" class="button button-secondary">Xem tất cả khóa học</a>
            </div>

            <div class="course-grid mt-6">
                @foreach($recentCourses as $course)
                    <article class="course-card-new">
                        <img src="{{ $course->image ? asset($course->image) : 'https://via.placeholder.com/640x360?text=Course+Image' }}" alt="{{ $course->name }}">
                        <div class="content">
                            <h3>{{ $course->name }}</h3>
                            <p>{{ number_format($course->price, 0, ',', '.') }} VND</p>
                            <span class="badge-pill">{{ ucfirst($course->status) }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="section-card">
            <div class="section-header">
                <h2>Doanh thu theo khóa học</h2>
            </div>
            <div class="mt-4 overflow-x-auto">
                <x-table>
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500">
                                <th class="py-3 px-4">Khóa học</th>
                                <th class="py-3 px-4">Học viên</th>
                                <th class="py-3 px-4">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4">{{ $course->name }}</td>
                                    <td class="py-4 px-4">{{ $course->enrollments_count }}</td>
                                    <td class="py-4 px-4">{{ number_format($course->price * $course->enrollments_count, 0, ',', '.') }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-table>
            </div>
        </section>
    </div>
@endsection
