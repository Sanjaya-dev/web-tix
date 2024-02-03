<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth'); //akan melakukan pengecekan apakah user sudah login atau belum
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $users)
    {   
        $q = $request->input('q');
        $active = 'Users';
        $users = $users->when($q,function($query) use ($q) {
                    return $query->where('name','like','%'.$q.'%')
                                ->orwhere('email','like','%'.$q.'%');
                })
                ->paginate(10); //menampilkan data user 10 perhalaman
        $request = $request->all();
        // dd($request);
        return view('dashboard/user/list',['users' => $users,'request' => $request,'active' => $active]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = USER::find($id);
        $active = 'Users';

        return view('dashboard/user/form',['user' => $user,'active' => $active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = USER::find($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:App\Models\User,email,'.$id
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/user/edit/'.$id)
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
    
            return redirect('dashboard/users');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = USER::find($id);
        $user->delete();
        return redirect('dashboard/users');
    }
}
