@extends('layouts.app', ['page_title' => "قائمة الأسرى"])

@section('content')

    <div class="container py-5 pt-4">

        {{-- Page Header --}}
        <div class="row align-items-center justify-content-between mb-4">
            <div class="col-md-6">
                <h2 class="mb-0 text-dark"><i class="fas fa-users me-2 text-primary"></i> قائمة الأسرى</h2>
            </div>
            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                <a href="{{ route('front.detainees.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> إضافة جديد
                </a>
            </div>
        </div>

        {{-- Search Form --}}
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">الاسم</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                   placeholder="بحث بالاسم...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الموقع</label>
                            <select name="location" class="form-control select2-select">
                                <option value="">كل المواقع</option>
                                @foreach($locations as $loc)
                                    <option
                                        value="{{ $loc }}" @selected(request('location') == $loc)>{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-control select2-select">
                                <option value="">كل الحالات</option>
                                <option value="detained" @selected(request('status') == 'detained')>معتقل</option>
                                <option value="missing" @selected(request('status') == 'missing')>مفقود</option>
                                <option value="released" @selected(request('status') == 'released')>مُفرج عنه</option>
                                <option value="martyr" @selected(request('status') == 'martyr')>شهيد</option>
                            </select>
                        </div>

                        <div class="col-md-2 p-4">
                            <button type="submit" class="btn btn-outline-success w-100">
                                <i class="fas fa-search me-1"></i> بحث
                            </button>
                            <button type="reset" class="btn btn-outline-danger w-100" onclick="this.form.reset();">
                                <i class="fas fa-times me-1"></i> مسح
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Search Results --}}
        @if($detainees->count())
            <div class="row g-4">
                @foreach($detainees as $detainee)
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                        <div class="card h-100 shadow-sm border-0">
                            @php
                                $image = $detainee->photos->first()->path ?? 'images/default-avatar.png';
                            @endphp
                            {{-- Image --}}
                            <a href="{{ route('front.detainees.show', $detainee->id) }}" target="_blank">
                                <img src="{{ asset('storage/public/' . $image) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="صورة الأسير">
                            </a>

                            {{-- Card Body --}}

                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $detainee->name }}</h5>
                                <p class="text-muted mb-1">
                                    <strong>الحالة : </strong> {{ __('status.' . $detainee->status) }}</p>
                                <p class="text-muted"><strong>بتاريخ : </strong> {{ $detainee->detention_date }}
                                </p>
                            </div>

                            <div class="card-footer bg-white text-end">
                                <a href="{{ route('front.detainees.show', $detainee->id) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $detainees->withQueryString()->links() }}
            </div>
        @else
            <div class="alert alert-info mt-4">لا توجد نتائج حاليًا.</div>
        @endif
    </div>
@endsection
