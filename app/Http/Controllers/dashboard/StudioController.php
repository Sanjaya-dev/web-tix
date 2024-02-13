<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Movie;
use App\Models\Theater;
use App\Models\Studio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Theater $theater)
    {
        $q = $request->input('q');
        $active = 'Theaters';
        // $theaters = $theater->when($q,function($query) use ($q) {
        //             return $query->where('theater','like','%'.$q.'%');
        //         })
        //         ->paginate(10); //menampilkan data user 10 perhalaman
        $studios = Studio::where('theater_id',$theater->id)
                                            ->with('movies')//dari relasi table studios dengan movies
                                            ->whereHas('movies', function($query) use ($q) {
                                                $query->where('title', 'like', "%$q%");
                                            })
                                            ->paginate();

        $request = $request->all();
        // dd($arrangeMovies);
        return view('dashboard/studio/list',['theater' => $theater,
                                                    'studios' => $studios,
                                                    'request' => $request,
                                                    'active' => $active]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Theater $theater)
    {
        $active = 'Theaters';
        $movies = Movie::get();

        return view('dashboard/studio/form',['theater' => $theater,
        'url' => 'dashboard.theaters.studio.store',
        'button' => 'Create',
        'movies' => $movies,
        'active' => $active]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Studio $studio)
    {
        $validator = Validator::make($request->all(),[
            'studio' => 'required',
            'movie_id' => 'required',
            'theater_id' => 'required',
            'price' => 'required',
            'rows' => 'required',
            'columns' => 'required',
            'price' => 'required',
            'schedules' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                    ->route('dashboard.theaters.studio.create',$request->input('theater_id'))
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $seats = [
                'rows' => $request->input('rows'),
                'columns' => $request->input('columns')
            ];

            $studio->theater_id = $request->input('theater_id');
            $studio->movies_id = $request->input('movie_id');
            $studio->studio = $request->input('studio');
            $studio->price = $request->input('price');
            $studio->seats = json_encode($seats);
            $studio->schedules = json_encode($request->input('schedules'));
            $studio->status = $request->input('status');
            $studio->save();

            return redirect()
                    ->route('dashboard.theaters.studio',$request->input('theater_id'))
                    ->with('message',__('messages.store',['title' => $request->input('studio')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArrangeMovie  $arrangeMovie
     * @return \Illuminate\Http\Response
     */
    // public function show(ArrangeMovie $arrangeMovie)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArrangeMovie  $arrangeMovie
     * @return \Illuminate\Http\Response
     */
    public function edit(Theater $theater, Studio $studio)
    {
        $active = 'Theaters';
        $movies = Movie::get();

        return view('dashboard/studio/form',['theater' => $theater,
        'url' => 'dashboard.theaters.studio.update',
        'studio' => $studio,
        'button' => 'Update',
        'movies' => $movies,
        'active' => $active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArrangeMovie  $arrangeMovie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Studio $studio)
    {
        $validator = Validator::make($request->all(),[
            'studio' => 'required',
            'movie_id' => 'required',
            'theater_id' => 'required',
            'price' => 'required',
            'rows' => 'required',
            'columns' => 'required',
            'price' => 'required',
            'schedules' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                    ->route('dashboard.theaters.studio.edit',['theater' => $request->input('theater_id'),'studio' => $studio->id])
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $seats = [
                'rows' => $request->input('rows'),
                'columns' => $request->input('columns')
            ];

            $studio->theater_id = $request->input('theater_id');
            $studio->movies_id = $request->input('movie_id');
            $studio->studio = $request->input('studio');
            $studio->price = $request->input('price');
            $studio->seats = json_encode($seats);
            $studio->schedules = json_encode($request->input('schedules'));
            $studio->status = $request->input('status');
            $studio->save();

            return redirect()
                    ->route('dashboard.theaters.studio',$request->input('theater_id'))
                    ->with('message',__('messages.update',['title' => $request->input('studio')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArrangeMovie  $arrangeMovie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Studio $studio)
    {
        $title = $studio->studio;

        $studio->delete();

        return redirect()
                        ->route('dashboard.theaters.studio',$studio->theater_id)
                        ->with('message',__('messages.delete',['title' => $title]));
    }
}
