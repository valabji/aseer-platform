@extends('layouts.app', ['page_title' => 'شكرًا لك'])

@section('content')
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4 p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success fa-3x"></i>
                    </div>
                    <h2 class="mb-3 fw-bold">شكرًا لمساهمتك</h2>
                    <p class="lead mb-4">تم إرسال بيانات الأسير بنجاح، سنقوم بمراجعتها ونشرها بعد التحقق منها.</p>
                    <a href="{{ route('front.detainees') }}" class="btn btn-primary rounded-pill px-5">عرض قائمة الأسرى</a>
                </div>
            </div>
        </div>
    </div>
@endsection
