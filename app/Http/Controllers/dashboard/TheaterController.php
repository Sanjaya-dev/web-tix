<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Theater;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TheaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Theater $theater)
    {
        $q = $request->input('q');
        $active = 'Theaters';
        $theaters = $theater->when($q,function($query) use ($q) {
                    return $query->where('theater','like','%'.$q.'%');
                })
                ->paginate(10); //menampilkan data user 10 perhalaman
        $request = $request->all();
        // dd($request);
        return view('dashboard/theater/list',['theaters' => $theaters,
                                            'request' => $request,
                                            'active' => $active]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'Theaters';

        return view('dashboard/theater/form',['url' => 'dashboard.theaters.store',
                                            'button' => 'Create',
                                            'active' => $active]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Theater $theater)
    {
        $validator = Validator::make($request->all(),[
            'theater' => 'required|unique:App\Models\theater,theater',
            'address' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                    ->route('dashboard.theaters.create')
                    ->withErrors($validator)
                    ->withInput();
        } else {
            $theater->theater = $request->input('theater');
            $theater->address = $request->input('address');
            $theater->status = $request->input('status');
            $theater->save();
            return redirect()
                    ->route('dashboard.theaters')
                    ->with('message',__('messages.store',['title' => $request->input('theater')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function show(Theater $theater)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function edit(Theater $theater)
    {
        $active = 'Theaters';

        return view('dashboard/theater/form',['url' => 'dashboard.theaters.update',
                                            'theater' => $theater,
                                            'button' => 'Update',
                                            'active' => $active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theater $theater)
    {
        $validator = Validator::make($request->all(),[
            'theater' => 'required|unique:App\Models\theater,theater,'.$theater->id,
            'address' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                    ->route('dashboard.theaters.update',$theater->id)
                    ->withErrors($validator)
                    ->withInput();
        } else {
            $theater->theater = $request->input('theater');
            $theater->address = $request->input('address');
            $theater->status = $request->input('status');
            $theater->save();
            return redirect()
                    ->route('dashboard.theaters')
                    ->with('message',__('messages.update',['title' => $request->input('theater')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theater $theater)
    {
        $title = $theater->theater;

        $theater->delete();
        return redirect()
                ->route('dashboard.theaters')
                ->with('message',__('messages.delete',['title' => $title]));
    }
}
