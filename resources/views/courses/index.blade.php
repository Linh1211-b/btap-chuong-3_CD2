@extends('layouts.master')

@section('content')
    @php $isTrashed = request()->routeIs('courses.trashed'); @endphp
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">{{ $isTrashed ? 'Khóa học đã xóa' : 'Danh sách khóa học' }}</h2>
            <p class="text-sm text-slate-500">Quản lý khóa học, phân trang và lọc theo yêu cầu.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            @unless($isTrashed)
                <a href="{{ route('courses.create') }}" class="button button-primary">Thêm khóa học</a>
                <a href="{{ route('courses.trashed') }}" class="button button-secondary">Xem khoá học đã xóa</a>
            @else
                <a href="{{ route('courses.index') }}" class="button button-secondary">Quay lại danh sách</a>
            @endunless
        </div>
    </div>

    <div class="form-card mb-6">
        <form action="{{ route('courses.index') }}" method="GET" class="grid gap-4 md:grid-cols-[1fr_260px] xl:grid-cols-[1fr_260px_260px]">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Tìm theo tên</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tên khóa học" />
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="form-label">Giá từ</label>
                        <input type="number" name="price_min" value="{{ request('price_min') }}" step="0.01" class="form-control" />
                    </div>
                    <div>
                        <label class="form-label">Đến</label>
                        <input type="number" name="price_max" value="{{ request('price_max') }}" step="0.01" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="grid gap-4">
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Sắp xếp</label>
                    <select name="sort_by" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3">
                        <option value="created_desc">Mới nhất</option>
                        <option value="created_asc" {{ request('sort_by') === 'created_asc' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="price_asc" {{ request('sort_by') === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort_by') === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="students_desc" {{ request('sort_by') === 'students_desc' ? 'selected' : '' }}>Học viên nhiều nhất</option>
                        <option value="students_asc" {{ request('sort_by') === 'students_asc' ? 'selected' : '' }}>Học viên ít nhất</option>
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="button button-primary">Lọc</button>
                    <a href="{{ route('courses.index') }}" class="button button-secondary">Đặt lại</a>
                </div>
            </div>
        </form>
    </div>

    @if($courses->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
            @foreach($courses as $course)
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; transition: all 0.3s; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" onmouseover="this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <!-- Hình ảnh khóa học -->
                    <div style="width: 100%; height: 180px; background: linear-gradient(135deg, {{ $course->status === 'published' ? '#667eea' : '#cbd5e0' }} 0%, {{ $course->status === 'published' ? '#764ba2' : '#a0aec0' }} 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        @if($course->image)
                            <img src="{{ asset('uploads/courses/' . $course->image) }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="text-align: center; color: white;">
                                <div style="font-size: 40px; margin-bottom: 8px;">📚</div>
                                <div style="font-size: 12px; opacity: 0.8;">Không có ảnh</div>
                            </div>
                        @endif
                        <div style="position: absolute; top: 12px; right: 12px;">
                            <span style="background: {{ $course->status === 'published' ? '#10b981' : '#6b7280' }}; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ ucfirst($course->status) }}</span>
                        </div>
                    </div>

                    <!-- Nội dung -->
                    <div style="padding: 16px;">
                        <h3 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0 0 8px 0; line-height: 1.4;">{{ $course->name }}</h3>
                        
                        <!-- Giá và bài học -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                            <div style="background: #f1f5f9; padding: 10px; border-radius: 8px;">
                                <p style="font-size: 11px; color: #64748b; margin: 0 0 4px 0;">Giá</p>
                                <p style="font-size: 14px; font-weight: 700; color: #3b82f6; margin: 0;">{{ number_format($course->price, 0, ',', '.') }} ₫</p>
                            </div>
                            <div style="background: #f1f5f9; padding: 10px; border-radius: 8px;">
                                <p style="font-size: 11px; color: #64748b; margin: 0 0 4px 0;">Bài học</p>
                                <p style="font-size: 14px; font-weight: 700; color: #8b5cf6; margin: 0;">{{ $course->lessons_count }}</p>
                            </div>
                        </div>

                        <!-- Mô tả ngắn -->
                        <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit($course->description, 60) }}</p>

                        <!-- Nút hành động -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            @if(!$isTrashed)
                                <a href="{{ route('courses.edit', $course) }}" style="text-align: center; padding: 8px; background: #e0e7ff; color: #4f46e5; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#c7d2fe'" onmouseout="this.style.background='#e0e7ff'">Sửa</a>
                                <a href="{{ route('courses.lessons.index', $course) }}" style="text-align: center; padding: 8px; background: #dbeafe; color: #0284c7; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#bfdbfe'" onmouseout="this.style.background='#dbeafe'">Bài học</a>
                                <form action="{{ route('courses.destroy', $course) }}" method="POST" style="grid-column: 1 / -1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="width: 100%; padding: 8px; background: #fee2e2; color: #dc2626; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">Xóa</button>
                                </form>
                            @else
                                <form action="{{ route('courses.restore', $course->id) }}" method="POST" style="grid-column: 1 / -1;">
                                    @csrf
                                    <button type="submit" style="width: 100%; padding: 8px; background: #d1fae5; color: #059669; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#a7f3d0'" onmouseout="this.style.background='#d1fae5'">Khôi phục</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px; text-align: center;">
            <p style="font-size: 16px; color: #64748b; margin: 0;">📭 Không có khóa học nào.</p>
        </div>
    @endif

    <div class="mt-6">{{ $courses->links() }}</div>
@endsection
