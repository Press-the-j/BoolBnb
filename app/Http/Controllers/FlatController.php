<?php

namespace App\Http\Controllers;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use App\Flat;
use App\Service;
use Carbon\Carbon;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $flats=Flat::where('is_promoted', 1)->get();
      $services=Service::all();
      $now=Carbon::now();
      foreach($flats as $flat){
        foreach($flat->promotions as $promotion){
          $end_at=$promotion->pivot->end_at;
          $end_atCarbon=new Carbon($end_at);
          if($now->greaterThan($end_at)){
            $flat->is_promoted=0;
            $flat->save();
            $flat->promotions()->sync([]);
          }
        }
      }
      return view('home', compact('flats', 'services'));
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
      
      //dd($id);
      $flat=Flat::where('id',$id)->first();
     
      $lat=$flat->position->getLat();
      $lon=$flat->position->getLng();
      return view('show', compact('flat', 'lat', 'lon'));
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