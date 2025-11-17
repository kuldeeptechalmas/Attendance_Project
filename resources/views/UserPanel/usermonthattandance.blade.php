@extends('UserPanel/userindex')

@section('content')
@if ($months->isNotEmpty())
Select Month To Get Data:
<div class="row" style="margin: 35px;">
    @foreach ($months as $item)
    <a href="/Month-AttendanceData/{{ $item->month }}/{{ $item->year }}">
        <input type="button" class="btn btn-white card" style="align-items: center;margin: 10px;height: 50px;display: flex;justify-content: center;width: 282px;" value="{{ $item->month }}/{{ $item->year }}">
    </a>
    @endforeach
</div>
@else
<div style="display: flex;justify-content: center;font-size: 22px;margin-top: 180px;">
    <div style="background: white;width: 200px;display: flex;justify-content: center;">
        Not Found Data
    </div>
</div>
@endif

@endsection
