@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="form-heading">Thêm mới khóa học</h2>
            <p class="form-subtitle">Điền đầy đủ thông tin và tải ảnh khóa học lên.</p>
        </div>

        <div class="form-card">
            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="form-label">Tên khóa học</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập tên khóa học" />
                    </div>
                    <div>
                        <label class="form-label">Giá</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" class="form-control" placeholder="Ví dụ: 1200000" />
                    </div>
                </div>

                <div>
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" rows="6" class="form-control" placeholder="Mô tả ngắn gọn về khóa học">{{ old('description') }}</textarea>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Ảnh khóa học</label>
                        <input type="file" name="image" accept="image/*" class="form-control" />
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="button button-primary">Lưu khóa học</button>
                    <a href="{{ route('courses.index') }}" class="button button-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
