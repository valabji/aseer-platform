@extends('layouts.app', ['page_title' => "إضافة أسير"])

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center"><i class="fas fa-user-plus me-2"></i> إضافة أسير / مختطف / مفقود</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('front.detainees.store') }}" enctype="multipart/form-data"
              class="bg-white p-4 p-md-5 rounded shadow">
            @csrf

            {{-- القسم الأول: المعلومات الأساسية --}}
            <div class="mb-4">
                <h5 class="text-danger border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2"></i> المعلومات الشخصية
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم رباعي *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">الجنس</label>
                        <select name="gender" class="form-control select2-select">
                            <option value="">-- اختر --</option>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" class="form-control">
                    </div>
                </div>
            </div>

            {{-- القسم الثاني: معلومات الاعتقال --}}
            <div class="mb-4">
                <h5 class="text-danger border-bottom pb-2 mb-3"><i class="fas fa-lock me-2"></i> معلومات الاعتقال / الإختطاف / الأسر</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">المدينة التي اعتقل فيها</label>
                        <input type="text" name="location" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تاريخ الاعتقال / الأسر / الإختطاف</label>
                        <input type="date" name="detention_date" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الحالة *</label>
                        <select name="status" class="form-control select2-select" required>
                            <option value="detained">معتقل</option>
                            <option value="kidnapped">مختطف</option>
                            <option value="missing">مفقود</option>
                            <option value="released">مُفرج عنه</option>
                            <option value="martyr">شهيد</option>
                        </select>
                        <ul class="text-danger">
                            <li>إذا كان مدني اختر مختطف</li>
                            <li>إذا كان عسكري اختر معتقل</li>
                        </ul>

                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الجهة المعتقلة</label>
                        <input type="text" name="detaining_authority" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اسم السجن</label>
                        <input type="text" name="prison_name" class="form-control">
                        <small class="text-muted">إذا كان غير معروف دعه فارغاً</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اختفاء قسري؟</label>
                        <select name="is_forced_disappearance" class="form-control select2-select">
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- القسم الثالث: جهة الاتصال والملاحظات --}}
            <div class="mb-4">
                <h5 class="text-danger border-bottom pb-2 mb-3"><i class="fas fa-user-friends me-2"></i> جهة الاتصال</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">إسم صاحب البلاغ</label>
                        <input type="text" name="family_contact_name" class="form-control">
                        <small>اسمك رباعي</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">رقم هاتف صاحب البلاغ بالمفتاح الدولي</label>
                        <input type="text" placeholder="249912740956" name="family_contact_phone" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">صلة القرابة</label>
                        <input type="text" name="source" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">ملاحظات إضافية</label>
                        <textarea name="notes" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>

            {{-- القسم الرابع: الصور --}}

            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3" style="color: red;">
                    <i class="fas fa-image me-2"></i> صور للأسير(ضرورية)
                </h5>
                <div class="col-md-12">
                    <input required type="file" name="photos[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">يمكن رفع عدة صور دفعة واحدة</small>
                </div>
            </div>

            {{-- زر الإرسال --}}
            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-paper-plane me-1"></i> إرسال البيانات للمراجعة
                </button>
            </div>

        </form>
    </div>
@endsection
