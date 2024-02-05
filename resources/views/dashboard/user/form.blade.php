@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-8 align-self-center">
                <h3>User</h3>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-sm text-secondary" data-toggle="modal" data-target='#deleteModal'>
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{route('dashboard.users.update',['id' => $user->id])}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name'){{'is-invalid'}}@enderror" value="{{old('name') ?? $user->name}}">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control @error('email'){{'is-invalid'}}@enderror" value="{{old('email') ?? $user->email}}">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="window.history.back()">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                    </div>
                </form>
            </div>
    </div>
    </div>
</div>

<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Delete</h5>
                <button type="button" class="close" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus akun dengan nama : {{$user->name}}</p>
            </div>
            <div class="modal-footer">
                <form action="{{route('dashboard.users.delete',['id' => $user->id])}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection