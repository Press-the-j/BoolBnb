<?php

namespace App\Http\Controllers\Admin;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Flat;
use App\FlatInfo;
use App\Service;


class FlatController extends Controller
{

  /* use MakeSlugTrait; */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flats=Flat::where('is_promoted', 0)->where('user_id', Auth::id())->get();
        $flatsPromoted=Flat::where('is_promoted', 1)->where('user_id', Auth::id())->get();

        return view('admin.flats.index', compact('flats', 'flatsPromoted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //richiamiamo tutti i servizi
        $services=Service::all();
        return view('admin.flats.create', compact('services'));
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
       
        $slugTemp= Str::of($data['title'])->slug('-');
        $controlledSlug = control_slug($slugTemp);
       /*  $count=0;
        $foundTitle=Flat::where('slug', $slug)->first();
         while ($foundTitle) {
           $count++;
           $slug = $slugTemp . '-' . $count;
           $foundTitle=Flat::where('slug', $slug)->first();
         } */
       

       $data['position'] = new Point($data['lat'], $data['long']);
       $flat= new Flat();
       $flatData =[
         'user_id' =>Auth::id(),
         'title'=> $data['title'],
         'position'=>$data['position'],
         'slug'=>$controlledSlug
       ];
       $flat->fill($flatData);
       $flat->save();
       $flatId=$flat->id;


       /* $flat->flatInfo= new FlatInfo(); */
       if (isset($data['image'])){
         $img_path=Storage::put('uploads', $data['image']);
         /* $data['image_path']=$img_path; */
       }
       


       $flatInfoData=[
         'flat_id'=>$flatId,
         'image_path'=> $img_path ?? '',
         'description' => $data['description'],
         'city'=>$data['city'],
         'address'=>$data['address'],
         'postal_code'=>$data['postal_code'],
         'square_meters'=>$data['square_meters'],
         'price'=>$data['price'],
         'max_guest'=>$data['max_guest'],
         'rooms'=>$data['rooms'],
         'baths'=>$data['baths']
       ];

       $flatInfo= new FlatInfo();
       $flatInfo->fill($flatInfoData);
       $flatInfo->save();
       if(!empty($data['services'])){
         $flat->services()->sync($data['services']);
       }




       return redirect()->route('admin.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Flat $flat)
    {
        $lat=$flat->position->getLat();
        $lon=$flat->position->getLng();
        return view('admin.flats.show', compact('flat', 'lat', 'lon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Flat $flat)
    {
      $services=Service::all();
      return view('admin.flats.edit', compact('flat', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flat $flat)
    {
        $data=$request->all();
        $slugTemp=Str::of($data['title'])->slug('-');

        $slug = update_control_slug($slugTemp, $flat) ;
        
        /* $count=0;
        $foundTitle=Flat::where('slug', $slug)->first();
         while ($foundTitle && $foundTitle->id !=$flat->id) {
           $count++;
           $slug = $slugTemp . '-' . $count;
           $foundTitle=Flat::where('slug', $slug)->first();
         } */



        $data['position'] = new Point($data['lat'],$data['long'] );

        //dd($data);

        $flatToUpdate = Flat::find($flat)->first();
        
        $flatInfoToUpdate= FlatInfo::where('flat_id', $flat->flatInfo->flat_id)->first();
        
        

        $dataFlatToUpdate= [
          'user_id' =>Auth::id(),
          'title'=> $data['title'],
          'position'=>$data['position'],
          'slug'=>$slug
        ];
        $flatToUpdate->update($dataFlatToUpdate);
        $flatToUpdateId=$flatToUpdate->id;
        
        if (isset($data['image'])){
          $img_path=Storage::put('uploads', $data['image']);
        } elseif ($flatToUpdate->flatInfo->image_path){
          $img_path=$flatToUpdate->flatInfo->image_path;
        } 
        

        $dataFlatInfoToUpdate=[
         'flat_id'=>$flatToUpdateId,
         'image_path'=> $img_path ?? '',
         'description' => $data['description'],
         'city'=>$data['city'],
         'address'=>$data['address'],
         'postal_code'=>$data['postal_code'],
         'square_meters'=>$data['square_meters'],
         'price'=>$data['price'],
         'max_guest'=>$data['max_guest'],
         'rooms'=>$data['rooms'],
         'baths'=>$data['baths']
        ];


        $flatInfoToUpdate->update($dataFlatInfoToUpdate);

        if(!empty($data['services'])){
          $flatToUpdate->services()->sync($data['services']);
        } else {
          $flatToUpdate->services()->detach();
        }

        return redirect()->route('admin.flats.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flat $flat)
    {
      $flat=Flat::find($flat)->first();

      $flat->delete();

      return redirect()->route('admin.flats.index');
    }
}
