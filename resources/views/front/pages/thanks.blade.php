@extends('layouts.app', ['page_title' => 'شكرًا لمساهمتك'])

@section('content')
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success fa-5x"></i>
                    </div>
                    <h2 class="mb-3 fw-bold text-success">شكرًا لمساهمتك القيمة</h2>

                    <p class="lead mb-3 text-muted">
                        تم إرسال بيانات الأسير بنجاح. نحن نُقدّر مشاركتك في توثيق قصص الأسرى والمفقودين.
                    </p>

                    <p class="text-muted">
                        سيقوم فريق التحقق لدينا بمراجعة المعلومات التي أرسلتها في أقرب وقت، وإذا تم اعتمادها، فستُعرض في قائمة الأسرى على المنصة.
                    </p>

                    <div class="mt-4 d-flex justify-content-center flex-wrap">
                        <a href="{{ route('front.detainees') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 btn-sm">
                            <i class="fas fa-list me-1"></i> قائمة الأسرى
                        </a>

                        <a href="{{ route('front.detainees.create') }}" class="btn btn-outline-success rounded-pill px-4 py-2 btn-sm ms-2">
                            <i class="fas fa-plus-circle me-1"></i> إضافة جديد
                        </a>
                    </div>


                    <div class="mt-5 text-muted small">
                        هل لاحظت خطأ أو تود تعديل بيانات؟ يمكنك <a href="{{ route('contact') }}">التواصل معنا</a> مباشرة أو استخدام خيار "تبليغ عن خطأ" في صفحة الأسير.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
