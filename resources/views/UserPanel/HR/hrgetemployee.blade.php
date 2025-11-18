@extends('UserPanel.userindex')

@section("content")
@if (isset($employeedata))
@if ($employeedata->isNotEmpty())

<div style="background: white;margin-bottom: 10px;">

    <h5>Employees</h5>

    <form class="d-flex" style="width: 40%;margin-left: 57%;padding-bottom: 17px;" role="search" action="{{ route('hrget.employee.data') }}" method="post">
        @csrf
        <input type="text" name="action" value="Search" id="" hidden>
        <input class="form-control me-2" name="searchdata" value="{{ isset($input_search)?$input_search:'' }}" type="search" placeholder="Search" aria-label="Search" />
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
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
@else
<div style="display: flex;justify-content: center;font-size: 22px;margin-top: 190px;">
    <div style="background: white;width: 200px;display: flex;justify-content: center;">
        Not Found Data
    </div>
</div>
@endif

@endif
@endsection
