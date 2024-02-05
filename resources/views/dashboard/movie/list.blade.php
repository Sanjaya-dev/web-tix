@extends('layouts.dashboard')

@section('content')
<div class="mb-2">
    <a href="{{route('dashboard.movies.create')}}" class="btn btn-primary btn-sm">+ Movie</a>
</div>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-8 align-self-center">
                <h3>Movie</h3>
            </div>
            <div class="col-4">
                <form action="{{route('dashboard.movies')}}" method="GET">
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
        @if ($movies->total())
        <table class="table table-borderless table-striped table-hover">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie )
                <tr>
                    <td class="col-thumbnail">
                        <img src="{{asset('storage/movies/'.$movie->thumbnail)}}" class="img-fluid">
                    </td>
                    <td>{{$movie->title}}</td>
                    <td>
                        <a href="{{route('dashboard.movies.edit',['id' => $movie->id])}}" title="Edit"
                            class="btn btn-success btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$movies->appends($request)->links()}}
        @else
        <h4 class="text-center">Belum ada data movies</h4>
        @endif
    </div>
</div>
@endsection