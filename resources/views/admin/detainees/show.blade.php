@extends('layouts.admin')
@section('content')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-user-shield me-2"></i> تفاصيل الأسير: {{ $detainee->name }}</h4>
            <a href="{{ route('admin.detainees.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>

        <div class="card p-4 shadow-sm mb-4">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>الاسم:</strong> {{ $detainee->name }}</p>
                    <p><strong>الحالة:</strong> {{ __('status.' . $detainee->status) }}</p>
                    <p><strong>تاريخ الاعتقال:</strong> {{ $detainee->detention_date }}</p>
                    <p><strong>مكان الاعتقال:</strong> {{ $detainee->location ?? 'غير محدد' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>أضيف بواسطة:</strong>
                        @if($detainee->user)
                            <a href="{{ route('admin.users.show', $detainee->user_id) }}">{{ $detainee->user->name }}</a>
                        @else
                            <span class="text-muted">غير معروف</span>
                        @endif
                    </p>
                    <p><strong>تاريخ الإضافة:</strong> {{ $detainee->created_at->format('Y-m-d') }}</p>
                    <p><strong>ملاحظات:</strong> {{ $detainee->notes ?? 'لا توجد' }}</p>
                </div>
            </div>
        </div>

        <h5 class="mt-4 mb-3"><i class="fas fa-images me-2"></i> صور الأسير</h5>
        <div class="row g-3">
            @forelse($detainee->photos as $photo)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset($photo->url) }}" class="card-img-top img-fluid rounded" alt="صورة للأسير">
                    </div>
                </div>
            @empty
                <div class="text-muted">لا توجد صور مرفوعة.</div>
            @endforelse
        </div>

        <hr class="my-5">

        <h5 class="mb-3"><i class="fas fa-eye me-2 text-warning"></i> تبليغات "رأيت هذا الشخص"</h5>
        @if($detainee->seenReports->count())
            <div class="list-group mb-4">
                @foreach($detainee->seenReports as $seen)
                    <div class="list-group-item">
                        <div class="fw-bold">{{ $seen->location }}</div>
                        <small class="text-muted">{{ $seen->created_at->translatedFormat('Y-m-d') }} - {{ $seen->created_at->diffForHumans() }}</small>
                        <div>{{ $seen->details }}</div>
                        @if($seen->user)
                            <small class="text-primary">بواسطة {{ $seen->user->name }}</small>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">لا توجد تبليغات حتى الآن.</p>
        @endif

        <h5 class="mb-3"><i class="fas fa-bug me-2 text-danger"></i> تبليغات الأخطاء</h5>
        @if($detainee->errorReports->count())
            <div class="list-group">
                @foreach($detainee->errorReports as $error)
                    <div class="list-group-item">
                        <div class="fw-bold">{{ $error->details }}</div>
                        <small class="text-muted">{{ $error->created_at->translatedFormat('Y-m-d') }} - {{ $error->created_at->diffForHumans() }}</small>
                        @if($error->user)
                            <small class="text-primary d-block">بواسطة {{ $error->user->name }}</small>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">لا توجد تقارير حتى الآن.</p>
        @endif

    </div>
@endsection
