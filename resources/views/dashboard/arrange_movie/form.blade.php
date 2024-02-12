@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-8 align-self-center">
                <h3>theater</h3>
            </div>
            @if(isset($theater))
            <div class="col-4 text-right">
                <button class="btn btn-sm text-secondary" data-toggle="modal" data-target='#deleteModal'>
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{route($url,$theater->id ?? '')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (isset($theater)) {{-- mengecek apakah terdapat variable $theater jika true maka program akan di
                    jalankan --}}
                    {{-- @method('put') --}}
                    @endif
                    <input type="hidden" name="theater_id" value="{{$theater->id}}">
                    <div class="form-group">
                        <label for="movie">Movie</label>
                        <select name="movie_id" class="form-control">
                            <option value="">Pilih Movie</option>
                            @foreach ($movies as $movie )
                            @if ($movie->id == old('movie_id'))
                            <option value="{{$movie->id}}" selected>{{$movie->title}}</option>
                            @else
                            <option value="{{$movie->id}}">{{$movie->title}}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('movie_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="studio">Studio</label>
                        <input type="text" name="studio" class="form-control @error('studio'){{'is-invalid'}}@enderror"
                            value="{{old('studio') ?? $theater->studio ?? ''}}">
                        @error('studio')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" class="form-control @error('price'){{'is-invalid'}}@enderror"
                            value="{{old('price') ?? $theater->price ?? ''}}">
                        @error('price')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group form-row mt-4">
                        <div class="col-2 align-self-center">
                            <label for="seats">Seats</label>
                        </div>
                        <div class="col-5">
                            <input type="number" name="rows"
                                class="form-control @error('rows'){{'is-invalid'}}@enderror" placeholder="Rows"
                                value="{{old('rows') ?? $theater->rows ?? ''}}">
                            @error('rows')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <input type="number" name="columns"
                                class="form-control @error('colums'){{'is-invalid'}}@enderror" placeholder="Colums"
                                value="{{old('columns') ?? $theater->colums ?? ''}}">
                            @error('columns')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="price">Schedule</label>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <schedule-component :old-schedules='{{json_encode(old('schedules') ?? [])}}'></schedule-component>
                            @error('schedule')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group mb-0">
                            <label for="status">Status</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="status" class="form-check-input" value="coming soon"
                                id="coming soon" @if((old('status') ?? $theater->status ?? '') == 'coming soon')
                            checked
                            @endif>
                            <label for="coming soon" class="form-check-label">coming soon</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="status" class="form-check-input" value="in theater"
                                id="in theater" @if((old('status') ?? $theater->status ?? '') == 'in theater')
                            checked
                            @endif>
                            <label for="in theater" class="form-check-label">in theater</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="status" class="form-check-input" value="finish" id="finish"
                                @if((old('status') ?? $theater->status ?? '') == 'finish')
                            checked
                            @endif>
                            <label for="finish" class="form-check-label">finish</label>
                        </div>
                        @error('status')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="window.history.back()">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">{{$button}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (isset($theater))
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Delete</h5>
                <button type="button" class="close" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus theater: {{$theater->theater}}</p>
            </div>
            <div class="modal-footer">
                <form action="{{route('dashboard.theaters.delete',$theater->id)}}" method="post">
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
@endif

@endsection