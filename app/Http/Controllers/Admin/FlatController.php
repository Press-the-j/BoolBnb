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
use App\Promotion;
use App\View;


class FlatController extends Controller
{

    public function statistics(Request $request){
      $id=$request['id'];
     
      $flats=Flat::where('user_id', Auth::id())->get();
      $messageArr=getMessage();
      $allMessages=$messageArr[0];
      $unreadMessages=$messageArr[1];
      $data=[
        'allMessages'=>$allMessages,
        'unreadMessages'=>$unreadMessages,
        'flats'=> $flats,
        'id'=>$id,
        
      ];
    
      //$views=View::where('flat_id', $fla)
      return view('admin.flats.statistics', $data);
    }



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
        $services=Service::all();
        $messageArr=getMessage();
        $allMessages=$messageArr[0];
        $unreadMessages=$messageArr[1];
        $data=[
          'allMessages'=>$allMessages,
          'unreadMessages'=>$unreadMessages,
          'flats'=>$flats,
          'flatsPromoted'=>$flatsPromoted,
          'services'=>$services
        ];
        return view('admin.flats.index', $data);
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
        $messageArr=getMessage();
        $allMessages=$messageArr[0];
        $unreadMessages=$messageArr[1];
        $data=[
          'allMessages'=>$allMessages,
          'unreadMessages'=>$unreadMessages,
          'services'=>$services
        ];
        return view('admin.flats.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
          "title"=>"required|max:255",
          "description"=>"required|max:500",
          "city"=>"required|max:100",
          "address"=>"required|max:100",
          "postal_code"=>"required|numeric|min:1",
          "square_meters"=>"required|numeric|min:1",
          "price"=>"required|numeric|min:1",
          "max_guest"=>"required|numeric|min:1",
          "rooms"=>"required|numeric|min:1",
          "baths"=>"required|numeric|min:1"
        ]);

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
        //$flat = Flat::find($flat->id)->first();
        
        $promotions=Promotion::all();
        $lat=$flat->position->getLat();
        $lon=$flat->position->getLng();
        $dateStart = '';
        $dateEnd = '';
  
        foreach($flat->promotions as $promotion){
          if(!empty($promotion->pivot->started_at) && !empty($end_at=$promotion->pivot->end_at)){
            $started_at=$promotion->pivot->started_at;
            $end_at=$promotion->pivot->end_at;
            $dateStart= date_create($started_at)->format('d-m-Y');
            $dateEnd= date_create($end_at)->format('d-m-Y');
          } 
        }
        $messageArr=getMessage();
        $allMessages=$messageArr[0];
        $unreadMessages=$messageArr[1];
        

       

        return view('admin.flats.show', compact('flat', 'lat', 'lon', 'promotions', 'dateStart', 'dateEnd', 'allMessages', 'unreadMessages'));
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
      $messageArr=getMessage();
      $allMessages=$messageArr[0];
      $unreadMessages=$messageArr[1];
      $data=[
        'allMessages'=>$allMessages,
        'unreadMessages'=>$unreadMessages,
        'flat'=>$flat,
        'services'=>$services
      ];
      return view('admin.flats.edit', $data);
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
        $request->validate([
          "title"=>"required|max:255",
          "description"=>"required|max:500",
          "city"=>"required|max:100",
          "address"=>"required|max:100",
          "postal_code"=>"required|numeric|min:1",
          "square_meters"=>"required|numeric|min:1",
          "price"=>"required|numeric|min:1",
          "max_guest"=>"required|numeric|min:1",
          "rooms"=>"required|numeric|min:1",
          "baths"=>"required|numeric|min:1"
        ]);

        $data=$request->all();
        $slug = Str::of($data['title'])->slug('-');
        /* $titleData=Str::of($data["title"])->slug('-');
        $titleFlat=Str::of($flatToUpdate->title)->slug('-');
        
        if($titleData != $titleFlat ){ */
        
        $foundSlug = Flat::where('slug', $slug)->first();
        $count = 0;
        $slug_primary = $slug;
          
        while ($foundSlug && $foundSlug->id != $flat->id ) {
          $count++;
          $slug = $slug_primary . '-' . $count ;
          $foundSlug = Flat::where('slug', $slug)->first();
        }
          
        
        
        
        $flatToUpdate = Flat::where('id', $flat->id)->first();
        
        
        
        /* $count=0;
        $foundTitle=Flat::where('slug', $slug)->first();
         while ($foundTitle && $foundTitle->id !=$flat->id) {
           $count++;
           $slug = $slugTemp . '-' . $count;
           $foundTitle=Flat::where('slug', $slug)->first();
         } */



        $data['position'] = new Point($data['lat'],$data['long'] );

        
       
    
        
        $flatInfoToUpdate= FlatInfo::where('flat_id', $flatToUpdate->id)->first();
        
        if(!isset($data['is_hidden'])){
          $data['is_hidden']= 0;
        } else {
          $data['is_hidden']=1;
        }
        
        

        $dataFlatToUpdate= [
          'user_id' =>Auth::id(),
          'title'=> $data['title'],
          'position'=>$data['position'],
          'slug'=>$slug,
          'is_hidden'=>$data['is_hidden']
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

      $flat=Flat::where('id', $flat->id)->first();
      $flat->delete();

      return redirect()->route('admin.flats.index');
    }
}
