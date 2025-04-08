@extends('layouts.user')

@section('user-content')
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-4"><i class="fas fa-users me-2 text-primary"></i> سجل الأسرى والمفقودين المضافين بواسطتك</h5>
                <a href="{{ url('detainees/create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-plus me-1"></i> إضافة جديد
                </a>
                <div class="table-responsive">
                    <table id="detainees-table" class="table table-bordered table-striped">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الحالة</th>
                            <th>تاريخ الاعتقال</th>
                            <th>المتابعين</th>
                           <th>حالة النشر</th>
                            <th>إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detainees as $detainee)
                            <tr>
                                <td>{{ $detainee->id }}</td>
                                <td>{{ $detainee->name }}</td>
                                <td>{{ __('status.' . $detainee->status) }}</td>
                                <td>{{ $detainee->detention_date ?? '—' }}</td>
                                <td>{{ $detainee->followers_count }}</td>
                                <td>
                                    {{ $detainee->is_approved ? '✔️ منشور' : '🚫 في إنتظار النشر' }}
                                </td>
                                <td>
                                    <a href="{{ route('front.detainees.show', $detainee->id) }}"
                                       class="btn btn-sm btn-outline-secondary mb-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.detainees.edit', $detainee->id) }}"
                                       class="btn btn-sm btn-outline-primary mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS (CDN or local version) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#detainees-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
                }
            });
        });
    </script>
@endsection
