@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-comments"></span> عرض الكل
                    </div>
                    <div class="col-12 col-lg-4 p-0"></div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control" placeholder="بحث ... "
                               value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>

            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;">

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width:25px;">#</th>
                            <th style="width:130px;">المستخدم</th>
                            <th style="width:100px;">تمت المراجعة</th>
                            <th>المحتوى</th>
                            @if(auth()->user()->hasRole('superadmin'))
                                <th>IP</th>
                            @endif
                            <th style="width:250px;">المقال</th>
                            <th style="width:170px;">تحكم</th>
                        </tr>
                        </thead>
                        <tbody id="sortable-table">
                        @foreach($comments as $comment)
                            <tr>
                                <td class="ui-state-default drag-handler" data-comment="{{ $comment->id }}">{{ $comment->id }}</td>
                                <td>
                                    <img class="rounded-circle mx-2" alt=""
                                         src="{{ $comment->user ? $comment->user->getUserAvatar() : env('DEFAULT_IMAGE_AVATAR') }}"
                                         style="width:20px;height: 20px;"/>
                                    <a href="{{ $comment->user ? route('admin.users.show', $comment->user) : '#' }}" class="link-dark">
                                        {{ $comment->user ? mb_strimwidth($comment->user->name, 0, 20, "...") : mb_strimwidth($comment->adder_name, 0, 20, "...") }}
                                    </a>
                                </td>
                                <td>
                                    <div class="form-switch">
                                        <input name="id" class="form-check-input change_comment_status" type="checkbox"
                                               id="flexSwitchCheckDefault"
                                               {{ $comment->reviewed ? 'checked' : '' }}
                                               style="width: 50px;height:25px"
                                               value="1" data-id="{{ $comment->id }}">
                                    </div>
                                </td>
                                <td>{{ $comment->content }}</td>
                                @if(auth()->user()->hasRole('superadmin'))
                                    <td>
                                        <a href="{{ route('admin.traffics.logs', ['ip' => $comment->ip]) }}">{{ $comment->ip }}</a>
                                    </td>
                                @endif
                                <td>
                                    @if($comment->article)
                                        <a href="{{ route('article.show', ['article' => $comment->article, 'user' => $comment->article->user]) }}">
                                            {{ mb_strimwidth($comment->article->title, 0, 80, "...") }}
                                        </a>
                                    @else
                                        <span class="text-muted">[مقال غير متوفر]</span>
                                    @endif
                                </td>
                                <td style="width: 170px;">
                                    @can('comments-update')
                                        <a href="{{ route('admin.article-comments.edit', $comment) }}">
                                            <span class="btn btn-outline-success btn-sm font-1 mx-1">
                                                <span class="fas fa-wrench"></span> تحكم
                                            </span>
                                        </a>
                                    @endcan
                                    @can('comments-delete')
                                        <form method="POST" action="{{ route('admin.article-comments.destroy', $comment) }}" class="d-inline-block">
                                            @csrf @method("DELETE")
                                            <button class="btn btn-outline-danger btn-sm font-1 mx-1"
                                                    onclick="return confirm('هل أنت متأكد من عملية الحذف ؟');">
                                                <span class="fas fa-trash"></span> حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 p-3">
                {{ $comments->appends(request()->query())->render() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.change_comment_status').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    fetch("{{ route('admin.article-comments.change_status') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: this.dataset.id })
                    }).then(res => res.json()).then(data => {
                        // Optional feedback
                    });
                });
            });
        });
    </script>
@endpush
