@extends('UserPanel.userindex')

@section('content')
@if (isset($data))
<div style="font-size: 18px;background-color: #0000000d;text-align: center;">
    Members
</div>
<table class="table table-hover" style="margin-bottom: 40px;">
    <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Roles</td>
    </tr>
    @foreach ($data as $item)
    <tr style="height: 52px;">
        <td>{{ $item->name }}
            @if (Auth::user()->email==$item->email)
            <span style="margin-left: 9px;">(you)</span>
            @endif
        </td>
        <td>{{ $item->email }}</td>

        @if($item->email=='superadmin12@gmail.com')
        <td>Owner</td>
        @elseif (Auth::user()->roles!=$item->roles)
        <td>{{ $item->roles }}</td>
        @else
        <td></td>
        @endif
    </tr>
    @endforeach
</table>
@else

@endif
@endsection
