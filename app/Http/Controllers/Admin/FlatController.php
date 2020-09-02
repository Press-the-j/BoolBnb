<?php

namespace App\Http\Controllers\Admin;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Flat;
use App\FlatInfo;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.flats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data= $request->all();
       $slug= Str::of($data['title'])->slug('-');

       $data['position'] = new Point(33.5567, -50.5050);
       $flat= new Flat();
       $flatData =[
         'user_id' =>Auth::id(),
         'title'=> $data['title'],
         'position'=>$data['position'],
         'slug'=>$slug
       ];
       $flat->fill($flatData);
       $flat->save();
       $flatId=$flat->id;
       /* $flat->flatInfo= new FlatInfo(); */
       $flatInfoData=[
         'flat_id'=>$flatId,
         'image_path'=> 'default',
         'description' => $data['description'],
         'city'=>$data['city'],
         'address'=>$data['address'],
         'postal_code'=>$data['postal_code'],
         'square_meters'=>$data['square_meters'],
         'price'=>$data['price'],
         'max_guest'=>$data['max_guest']
       ];
       $flatInfo= new FlatInfo();
       $flatInfo->fill($flatInfoData);
       $flatInfo->save();
       return redirect()->route('admin.home');
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
