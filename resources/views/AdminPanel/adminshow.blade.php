@extends('UserPanel/userindex')

@section('content')
@toastifyCss
@session('delete')
{{ toastify()->error('Remove Record Successful!') }}
@endsession
@toastifyJs
@if ($data->isNotEmpty())
<h3 style="background: white;text-align: center;">Admins</h3>
<table class="table table-hover">
    <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Phone No.</td>
        <td>Action</td>
    </tr>
    @foreach ($data as $item)
    <tr>

        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->phoneno }}</td>
        <td>
            <div style="display: flex;">
                <a href="/SuperAdmin-Admin/{{ $item->id }}">
                    <button class="btn btn-primary" style="margin-right: 11px;">Edit</button>
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteShow('{{ $item->id }}','{{ $item->email }}')" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Remove
                </button>
            </div>
        </td>
    </tr>
    @endforeach
</table>
<div class="row" style="margin: 0px;background: white;padding-top: 20px;margin-bottom: 20px;">
    <div class="col-5">
        {{ $data->currentPage() }} of {{ $data->lastPage() }} in {{ $data->count() }}
    </div>
    <div class="col-7">
        {{$data->links('pagination::bootstrap-4') }}
    </div>
</div>
@else
<div style="display: flex;justify-content: center;font-size: 22px;margin-top: 190px;">
    <div style="background: white;width: 200px;display: flex;justify-content: center;">
        Not Found Data
    </div>
</div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 3px;">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are Shore Delete This Records
                <span id="deletedemail" style="font-weight: bold;"></span>
            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.employee.manage') }}" method="post">
                    @csrf
                    <input type="text" name="action" value="Remove" hidden>
                    <input type="text" name="id" id="deletedid" hidden>
                    <button type="submit" class="btn btn-primary">Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function deleteShow(id, email) {
        $("#deletedid").val(id);
        $("#deletedemail").text(email);
    }

</script>
@endsection
