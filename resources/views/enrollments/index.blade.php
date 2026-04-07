@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">Danh sách học viên</h2>
                <p class="text-sm text-slate-500">Hiển thị học viên đăng ký theo khóa học.</p>
            </div>
            <a href="{{ route('enrollments.create') }}" class="button button-primary">Thêm đăng ký</a>
        </div>

        <div class="form-card mb-6">
            <form action="{{ route('enrollments.index') }}" method="GET" class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="form-label">Tìm kiếm học viên</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tên hoặc email" />
                </div>
                <div>
                    <label class="form-label">Khóa học</label>
                    <select name="course_id" class="form-control">
                        <option value="">Tất cả</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="button button-primary">Lọc</button>
                    <a href="{{ route('enrollments.index') }}" class="button button-secondary">Đặt lại</a>
                </div>
            </form>
        </div>

        @if($enrollments->count() > 0)
            @php
                $grouped = $enrollments->groupBy('course_id');
            @endphp
            
            @foreach($grouped as $courseId => $courseEnrollments)
                @php
                    $course = $courseEnrollments->first()->course;
                @endphp
                
                <div class="section-card">
                    <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h3 style="font-size: 18px; font-weight: 600; color: white; margin: 0;">{{ $course->name }}</h3>
                                <p style="font-size: 13px; color: rgba(255,255,255,0.8); margin: 4px 0 0 0;">Khóa học</p>
                            </div>
                            <span style="background: rgba(255,255,255,0.3); color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 14px;">{{ $courseEnrollments->count() }} học viên</span>
                        </div>
                    </div>
                    
                    <div style="padding: 0;">
                        @foreach($courseEnrollments as $index => $enrollment)
                            <div style="padding: 16px 20px; border-bottom: 1px solid #f0f4f8; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='white'">
                                <div style="flex: 1;">
                                    <h4 style="font-size: 15px; font-weight: 600; color: #1e293b; margin: 0;">{{ $enrollment->student->name }}</h4>
                                    <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">{{ $enrollment->student->email }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <p style="font-size: 13px; color: #64748b; margin: 0;">{{ $enrollment->created_at->format('d/m/Y') }}</p>
                                    <p style="font-size: 12px; color: #94a3b8; margin: 4px 0 0 0;">{{ $enrollment->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px; text-align: center;">
                <p style="font-size: 16px; color: #64748b; margin: 0;">📭 Chưa có học viên đăng ký</p>
            </div>
        @endif

        <div class="mt-6">{{ $enrollments->links() }}</div>
    </div>
@endsection
