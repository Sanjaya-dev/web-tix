@extends('layouts.dashboard')

@section('content')
<div class="mb-2">
    <a href="{{route('dashboard.theaters.create')}}" class="btn btn-primary btn-sm">+ Theater</a>
</div>

@if(session()->has('message'))
<div class="alert alert-success">
    <strong>{{session()->get('message')}}</strong>
    <button class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-8 align-self-center">
                <h3>Theater</h3>
            </div>
            <div class="col-4">
                <form action="{{route('dashboard.theaters')}}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="q"
                            value="{{$request['q'] ?? ''}}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if ($theaters->total())
        <table class="table table-borderless table-striped table-hover">
            <thead>
                <tr>
                    <th>Theater</th>
                    <th>Address</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($theaters as $theater )
                <tr>
                    <td>
                        {{$theater->theater}}
                    </td>
                    <td>
                        <h4>{{$theater->address}}</h4>
                    </td>
                    <td>
                        <a href="{{route('dashboard.theaters.edit',$theater->id)}}" title="Edit"
                            class="btn btn-success btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="{{route('dashboard.theaters.studio',$theater->id)}}" title="Arrange Movie"
                            class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-film"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$theaters->appends($request)->links()}}
        @else
        <h4 class="text-center py-4">{{__('messages.no_data',['module' => 'theaters'])}}</h4>
        @endif
    </div>
</div>
@endsection