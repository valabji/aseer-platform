@extends('layouts.app')
@section('content')
    <style>
        #navbar { display: none; }
        body { background: #fff !important; }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded">
                    <div class="card-header bg-white text-center">
                        <h4 class="mb-0">تأكيد رقم الهاتف</h4>
                        <small class="text-muted">يرجى إرسال الكود إلى رقم واتساب الخاص بنا، ثم إدخاله هنا</small>
                    </div>
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('verify.phone') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="code" class="form-label">أدخل الكود المرسل</label>
                                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" required autofocus>
                                @error('code')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    تأكيد الكود
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-2">إذا لم تقم بإرسال الكود بعد، يرجى إرساله عبر واتساب إلى:</p>
                            <h5 class="text-primary">+249XXXXXXXXX</h5>
                            <p>أرسل الكود التالي:</p>
                            <h4 class="fw-bold">{{ auth()->user()->phone_verification_code }}</h4>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                تسجيل الخروج
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
