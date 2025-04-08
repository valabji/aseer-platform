@extends('layouts.admin', ['page_title' => 'الترافيك'])
@section('content')
<div class="col-12 pt-3">


<div class="col-12 px-0 row d-flex pb-2" style="margin-top:15px">
    <form method="GET" action="{{route('admin.traffics.logs')}}" class="row col-12 px-0">
        <div class="col-6 col-lg-2 pb-1">
            <input type="" name="ip" placeholder="ip" value="{{\Request::get('ip')}}" class="form-control">
        </div>
        <div class="col-6 col-lg-2 pb-1">
            <input type="" name="user_id" placeholder="user_id" value="{{\Request::get('user_id')}}" class="form-control">
        </div>
        <div class="col-6 col-lg-2 pb-1">
            <input type="" name="domain" placeholder="domain" value="{{\Request::get('domain')}}" class="form-control">
        </div>
        <div class="col-6 col-lg-2 pb-1">
            <input type="" name="country_code" placeholder="country_code" value="{{\Request::get('country_code')}}" class="form-control">
        </div>
        <div class="col-6 col-lg-2 pb-1">
            <button class="btn btn-primary">بحث</button>
        </div>
    </form>
</div>
</div>

<div class="col-12   row p-4" style="padding: 30px 0px;position: relative;background: #fff;overflow-x: auto;">
    <table id="myTable" class="table table-striped table-bordered col-12 " style="padding: 0px;min-width: 1200px;">
        <thead>
            <tr>
                <th style="font-size: 12px">#</th>
                <th style="font-size: 12px">جاي من</th>
                <th style="font-size: 12px">دخل على</th>
                <th style="font-size: 12px">تفاصيل الجهاز</th>
                <th style="font-size: 12px">في</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td style="font-size: 11px; background-color: {{ $log->user_id ? 'green' : 'transparent' }}; color: {{ $log->user_id ? '#fff' : '#000' }}">
                    @if($log->user_id)
                        <a href="{{ route('admin.users.show', $log->user) }}" style="color: #fff;">
                            {{ $log->id }} - {{ $log->user->name }}
                        </a>
                    @else
                        {{ $log->id }}
                    @endif
                </td>


                <td style="font-size: 12px;">
                    <a href="{{$log->rate_limit->prev_link}}" target="_blank">
                        {{str_ireplace('www.', '', parse_url($log->rate_limit->prev_link, PHP_URL_HOST)) }}
                    </a>
                </td>
                <td style="font-size: 12px;">
                    <a href="{{ $log->url }}" target="_blank" title="{{ $log->url }}">
                        {{ parse_url($log->url, PHP_URL_PATH) }}
                    </a>
                </td>
                <td style="font-size: 12px; line-height: 1.6">
                    <strong>المتصفح:</strong> {{ $log->rate_limit->browser }}
                    <br>
                    <strong>الجهاز:</strong> {{ $log->rate_limit->device }}
                    <br>
                    <strong>النظام:</strong> {{ $log->rate_limit->operating_system }}
                    <br>
                    <strong>الدولة:</strong>
                    @if($log->rate_limit->country_code)
                        <img src="https://flagcdn.com/16x12/{{ strtolower($log->rate_limit->country_code) }}.png" alt="علم الدولة" style="vertical-align: middle;">
                    @endif
                    {{ $log->rate_limit->country_name ?? 'غير معروفة' }}
                    <hr class="my-1">
                    <div style="word-break: break-word;">
                        <strong class="text-muted">Agent:</strong>
                        <span style="font-size: 11px; color: #666;">{{ $log->rate_limit->agent_name }}</span>
                    </div>
                </td>

                <td style="font-size: 12px;">
                    {{$log->created_at}} {{\Carbon::parse($log->created_at)->diffForHumans()}}
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-12 pt-3 ">
        {{$logs->appends(request()->query())->links()}}
    </div>
</div>
@endsection
@section('scripts')
@endsection
