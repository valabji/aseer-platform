@extends('layouts.admin')
@section('content')

    <div class="col-12 p-3">
        <div class="main-box shadow rounded bg-white">

            {{-- ✅ رأس الصفحة --}}
            <div class="col-12 px-3 py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i> إدارة الأسرى</h5>
            </div>

            {{-- 🔍 نموذج البحث --}}
            <div class="col-12 p-3 border-bottom">
                <form method="GET" class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label">بحث بالاسم</label>
                        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="مثال: محمد أحمد">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-control select2">
                            <option value="">كل الحالات</option>
                            <option value="detained" @selected(request('status') === 'detained')>معتقل</option>
                            <option value="missing" @selected(request('status') === 'missing')>مفقود</option>
                            <option value="released" @selected(request('status') === 'released')>مفرج عنه</option>
                            <option value="martyr" @selected(request('status') === 'martyr')>شهيد</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">الموقع</label>
                        <select name="location" class="form-control select2">
                            <option value="">كل المواقع</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" @selected(request('location') == $loc)>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">حالة الموافقة</label>
                        <select name="is_approved" class="form-control select2">
                            <option value="">كل الحالات</option>
                            <option value="0" @selected(request('is_approved') === '0')>بانتظار الموافقة</option>
                            <option value="1" @selected(request('is_approved') === '1')>تمت الموافقة</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-3 mt-4">
                        <button class="btn btn-outline-primary w-100">
                            <i class="fas fa-search me-1"></i> تنفيذ البحث
                        </button>
                        <a href="{{ route('admin.detainees.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-times-circle me-1"></i> مسح البحث
                        </a>
                    </div>

                </form>
            </div>

            {{-- 📋 جدول العرض --}}
            <div class="col-12 p-3">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الحالة</th>
                            <th>تاريخ الاعتقال</th>
                            <th>الموافقة</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($detainees as $detainee)
                            <tr>
                                <td>{{ $detainee->id }}</td>
                                <td>{{ $detainee->name }}</td>

                                {{-- ✅ تغيير الحالة --}}
                                <td>
                                    @can('detainees-update')
                                        <form method="POST" action="{{ route('admin.detainees.update_status', $detainee->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="detained" @selected($detainee->status === 'detained')>معتقل</option>
                                                <option value="missing" @selected($detainee->status === 'missing')>مفقود</option>
                                                <option value="released" @selected($detainee->status === 'released')>مفرج عنه</option>
                                                <option value="martyr" @selected($detainee->status === 'martyr')>شهيد</option>
                                            </select>
                                        </form>
                                    @else
                                        {{ __('status.' . $detainee->status) }}
                                    @endcan
                                </td>

                                <td>{{ $detainee->detention_date }}</td>

                                <td>
                                    @if($detainee->is_approved)
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> معتمد</span>
                                    @else
                                        @can('detainees-update')
                                            <form method="POST" action="{{ route('admin.detainees.approve', $detainee->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="fas fa-check"></i> موافقة
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </td>

                                {{-- 🔘 الإجراءات --}}
                                <td class="text-center">

                                    @can('detainees-read')
                                        <a href="{{ route('front.detainees.show', $detainee->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                    @endcan

                                    @can('detainees-update')
                                            <a href="{{ route('admin.detainees.edit', $detainee->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                    @endcan

                                    @can('detainees-delete')
                                        <form method="POST" action="{{ route('admin.detainees.destroy', $detainee->id) }}" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i> حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">لا توجد نتائج حاليًا.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $detainees->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
