<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile');
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
    public function edit(Request $request)
    {
        if ($request->hasFile('image')) {
            $file=$request->file('image');
            $imageFinal = processImage($file);
        }

        User::where('id',auth()->user()->id)->update([
            'image'=>$imageFinal,
        ]);
        Post::insert([
            'status'=> auth()->user()->fname.' has updated his profile picture',
            'photo'=>  $request->hasFile('image') ? $imageFinal : '',
            'likes'=>  json_encode(array()),
            'shares'=> json_encode(array()),
            'user_id'=>Auth::user()->id,
        ]);
        return back();
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
        $fieldName= $request->get('fld_name')?? '';
        $fieldVal= $request->get('fld_value')?? '';
        if ($fieldName=='birthday') {
            $fieldVal= date('Y-m-d',strtotime($fieldVal));
        }
        $columnName= config('app.columns.'.$fieldName);

        User::where('id',$id)->update([
            $columnName=>$fieldVal
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
