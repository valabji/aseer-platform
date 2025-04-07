@extends('layouts.admin')
@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center"><i class="fas fa-user-edit me-2"></i> تعديل بيانات الأسير</h2>

        <form method="POST" action="{{ route('admin.detainees.update', $detainee) }}" enctype="multipart/form-data"
              class="bg-white p-4 p-md-5 rounded shadow">
            @csrf
            @method('PUT')

            {{-- القسم الأول: المعلومات الشخصية --}}
            <div class="mb-4">
                <h5 class="text-muted border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2"></i> المعلومات الشخصية
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $detainee->name) }}"
                               required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">الجنس</label>
                        <select name="gender" class="form-control select2-select">
                            <option value="">-- اختر --</option>
                            <option value="male" @selected($detainee->gender == 'male')>ذكر</option>
                            <option value="female" @selected($detainee->gender == 'female')>أنثى</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" class="form-control"
                               value="{{ old('birth_date', $detainee->birth_date) }}">
                    </div>
                </div>
            </div>

            {{-- معلومات الاعتقال --}}
            <div class="mb-4">
                <h5 class="text-muted border-bottom pb-2 mb-3"><i class="fas fa-lock me-2"></i> معلومات الاعتقال</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">مكان الاعتقال</label>
                        <input type="text" name="location" class="form-control"
                               value="{{ old('location', $detainee->location) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تاريخ الاعتقال</label>
                        <input type="date" name="detention_date" class="form-control"
                               value="{{ old('detention_date', $detainee->detention_date) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الحالة *</label>
                        <select name="status" class="form-control select2-select" required>
                            <option value="detained" @selected($detainee->status == 'detained')>معتقل</option>
                            <option value="kidnapped" @selected($detainee->status == 'kidnapped')>مختطف</option>
                            <option value="missing" @selected($detainee->status == 'missing')>مفقود</option>
                            <option value="released" @selected($detainee->status == 'released')>مُفرج عنه</option>
                            <option value="martyr" @selected($detainee->status == 'martyr')>شهيد</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الجهة المعتقلة</label>
                        <input type="text" name="detaining_authority" class="form-control"
                               value="{{ old('detaining_authority', $detainee->detaining_authority) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اسم السجن</label>
                        <input type="text" name="prison_name" class="form-control"
                               value="{{ old('prison_name', $detainee->prison_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اختفاء قسري؟</label>
                        <select name="is_forced_disappearance" class="form-control select2-select">
                            <option value="0" @selected(!$detainee->is_forced_disappearance)>لا</option>
                            <option value="1" @selected($detainee->is_forced_disappearance)>نعم</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- معلومات الشهادة (إذا كان شهيدًا) --}}
            @if($detainee->status == 'martyr')
                <div class="mb-4">
                    <h5 class="text-muted border-bottom pb-2 mb-3"><i class="fas fa-heart-broken me-2"></i> معلومات
                        الاستشهاد</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الاستشهاد</label>
                            <input type="date" name="martyr_date" class="form-control"
                                   value="{{ old('martyr_date', $detainee->martyr_date) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">مكان الاستشهاد</label>
                            <input type="text" name="martyr_place" class="form-control"
                                   value="{{ old('martyr_place', $detainee->martyr_place) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">سبب الاستشهاد</label>
                            <input type="text" name="martyr_reason" class="form-control"
                                   value="{{ old('martyr_reason', $detainee->martyr_reason) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ملاحظات الاستشهاد</label>
                            <textarea name="martyr_notes" class="form-control"
                                      rows="4">{{ old('martyr_notes', $detainee->martyr_notes) }}</textarea>
                        </div>
                    </div>
                </div>
            @endif

            {{-- جهة الاتصال --}}
            <div class="mb-4">
                <h5 class="text-muted border-bottom pb-2 mb-3"><i class="fas fa-user-friends me-2"></i> جهة الاتصال</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم جهة الاتصال من العائلة</label>
                        <input type="text" name="family_contact_name" class="form-control"
                               value="{{ old('family_contact_name', $detainee->family_contact_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">رقم هاتف العائلة</label>
                        <input type="text" name="family_contact_phone" class="form-control"
                               value="{{ old('family_contact_phone', $detainee->family_contact_phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">المصدر</label>
                        <input type="text" name="source" class="form-control"
                               value="{{ old('source', $detainee->source) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">ملاحظات إضافية</label>
                        <textarea name="notes" class="form-control"
                                  rows="4">{{ old('notes', $detainee->notes) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- الصور (اختياري) --}}
            <div class="mb-4">
                <h5 class="text-muted border-bottom pb-2 mb-3"><i class="fas fa-image me-2"></i> إدارة الصور</h5>
                <input type="file" class="filepond" name="photos[]" multiple data-allow-reorder="true"
                       data-max-files="10">
                <small class="text-muted">يمكن رفع صور جديدة. لإدارة الصور الحالية، استخدم الواجهة أدناه.</small>
            </div>

            {{-- Display the current photos as thumbnails --}}

            <div class="mb-4">
                <h5 class="text-muted border-bottom pb-2 mb-3">
                    <i class="fas fa-images me-2"></i> معرض الصور ({{ $detainee->photos->count() }})
                </h5>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
                    @foreach($detainee->photos as $photo)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="position-relative">
                                    <img src="{{ $photo->url }}"
                                         class="card-img-top img-fluid"
                                         style="height: 180px; object-fit: cover;"
                                         loading="lazy"
                                         alt="صورة الأسير">

                                    @if($photo->is_featured)
                                        <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-2">مميزة</span>
                                    @endif
                                </div>

                                <div class="card-body text-center p-2">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger w-100 delete-photo"
                                            data-photo-id="{{ $photo->id }}">
                                        <i class="fas fa-trash-alt me-1"></i> حذف
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger w-100 set-featured"
                                            data-photo-id="{{ $photo->id }}">
                                        <i class="fas fa-trash-alt me-1"></i> تعيين مميزة
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Display the current photos as thumbnails --}}
            {{-- زر الحفظ --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i> حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Your script using $() -->
    <script>
        $(document).ready(function () {
            $('.delete-photo').on('click', function () {
                const photoId = $(this).data('photo-id');
                if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                    $.ajax({
                        url: '{{ url('admin/detainees/photo/delete') }}/' + photoId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: photoId
                        },
                        success: () => location.reload(),
                        error: () => toastr.error('حدث خطأ أثناء حذف الصورة')
                    });
                }
            });

            $('.set-featured').on('click', function () {
                const photoId = $(this).data('photo-id');
                if (confirm('هل أنت متأكد من تعيين الصورة كمميزة؟')) {
                    $.ajax({
                        url: '{{ url('admin/detainees/photo/featured') }}/' + photoId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: photoId
                        },
                        success: () => location.reload(),
                        error: () => toastr.error('حدث خطأ أثناء تمييز الصورة')
                    });
                }
            });
        });
    </script>
@endpush




