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
        <td>Details</td>
    </tr>
    @foreach ($employeedata as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->salary }}</td>
        <td>{{ $item->joinindate }}</td>
        <td>
            <a href="/Employees/{{ $item->id }}">
                <button class="btn btn-info">Details</button>
            </a>
        </td>
    </tr>
    @endforeach
    @endif
</table>
@endsection
