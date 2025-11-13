@extends('UserPanel.userindex')

@section("content")
@if (isset($employeedata))
<div>
    <h5>Employees </h5>
</div>
<table class="table table-white table-hover">
    <tr style="height: 61px;">
        <td>Name</td>
        <td>Email</td>
        <td>Salary</td>
        <td>Join In Date</td>
        <td>Action</td>
        <td>Attendance</td>
        <td>Add Attendance</td>
    </tr>
    @foreach ($employeedata as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->salary }}</td>
        <td>{{ $item->joinindate }}</td>
        <td>
            <a href="/Employees/{{ $item->id }}">
                <button class="btn btn-info">Edit</button>
            </a>
        </td>
        <td>
            {{-- <form action="{{ route('month.attendance') }}" method="post">
            @csrf
            <input type="text" name="id" value="{{ $item->id }}" hidden>
            </form> --}}
            <a href="/Month-Attendance/{{ $item->id }}">

                <input type="button" class="btn btn-info" value="Attendance">
            </a>
        </td>
        <td>
            <a href="{{ route('add.attendance.employee',['userid'=>$item->id]) }}">

                <input type="button" class="btn btn-primary" value="Add Attendance">
            </a>
        </td>
    </tr>
    @endforeach
</table>
<div class="row" style="margin: 0px;background: white;padding-top: 20px;margin-bottom: 20px;">
    <div class="col-5">
        {{ $employeedata->currentPage() }} of {{ $employeedata->lastPage() }} in {{ $employeedata->count() }}
    </div>
    <div class="col-7">
        {{$employeedata->links('pagination::bootstrap-4') }}
    </div>
</div>
@endif
@endsection
