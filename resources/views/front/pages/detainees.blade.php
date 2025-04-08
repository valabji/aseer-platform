@extends('layouts.app', ['page_title' => "قائمة الأسرى"])

@section('content')
    <div class="container py-5 pt-4">
        @php
            $statusInfo = [
                'detained' => ['label' => 'معتقل',  'color' => 'dark'],
                'kidnapped' => ['label' => 'مختطف', 'color' => 'dark'],
                'missing' => ['label' => 'مفقود',  'color' => 'dark'],
                'released' => ['label' => 'مفرج عنه',  'color' => 'dark'],
                'martyr' => ['label' => 'شهيد',  'color' => 'danger'],
                'total' => ['label' => 'الكل',  'color' => 'dark'],
            ];
        @endphp
        <i class="fa-light fa-user-secret"></i>
        <div class="row g-3 mb-4">
            @foreach($statusInfo as $key => $info)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="p-3 text-center bg-{{$info['color']}} border shadow-sm rounded-3">
                        <div class="fw-bold h1 text-white text-center">{{ $allStatuses[$key] ?? 0 }}</div>
                        <small class="text-white">{{ $info['label'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 border-bottom pb-3">
            <h2 class="mb-0 text-dark"><i class="fas fa-users me-2 text-primary"></i> قائمة الأسرى</h2>
            <a href="{{ route('front.detainees.create') }}" class="btn btn-success rounded-pill">
                <i class="fas fa-plus me-1"></i> إضافة جديد
            </a>
        </div>

        {{-- Search Form --}}
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">الاسم</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control select2 rounded-pill"
                                   placeholder="بحث بالاسم...">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">الموقع</label>
                            <select name="location" class="form-control select2 rounded-pill">
                                <option value="">كل المواقع</option>
                                @foreach($locations as $loc)
                                    <option
                                        value="{{ $loc }}" @selected(request('location') == $loc)>{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-control select2 rounded-pill">
                                <option value="">كل الحالات</option>
                                <option value="detained" @selected(request('status') == 'detained')>معتقل</option>
                                <option value="kidnapped" @selected(request('status') == 'kidnapped')>مختطف</option>
                                <option value="missing" @selected(request('status') == 'missing')>مفقود</option>
                                <option value="released" @selected(request('status') == 'released')>مُفرج عنه</option>
                                <option value="martyr" @selected(request('status') == 'martyr')>شهيد</option>
                            </select>
                        </div>

                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="btn btn-outline-success rounded-pill px-4 me-2">
                                <i class="fas fa-search me-1"></i> بحث
                            </button>
                            <a href="{{ route('front.detainees') }}" class="btn btn-outline-danger rounded-pill px-4">
                                <i class="fas fa-times me-1"></i> مسح
                            </a>
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
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            @php
                                $image = $detainee->photos->first()->path ?? 'images/default-avatar.png';
                                if(str_contains($image,'images/default-avatar.png')){
                                    $image = 'images/default-avatar.png';
                                } else {
                                    $image = 'storage/public/' . $image;
                                }
                            @endphp
                            <a href="{{ route('front.detainees.show', $detainee->id) }}" target="_blank">
                                <img src="{{ asset($image) }}" class="card-img-top img-fluid"
                                     style="height: 220px; object-fit: cover;" alt="صورة الأسير">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-primary mb-2">{{ collect(explode(' ', $detainee->name))->take(3)->implode(' ') }}</h5>
                                <p class="text-muted mb-1 small">
                                    <strong>الحالة:</strong> {{ __('status.' . $detainee->status) }}</p>
                                <p class="text-muted mb-3 small">
                                    <strong>بتاريخ:</strong> {{ $detainee->detention_date }}</p>
                                <a href="{{ route('front.detainees.show', $detainee->id) }}"
                                   class="btn btn-outline-primary btn-sm mt-auto rounded-pill">
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
