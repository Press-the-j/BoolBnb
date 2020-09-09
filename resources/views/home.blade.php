@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <h1>Pagina GUEST</h1>
    <div class="col-md-8">
      <input type="text" class="form-control" id="search-input" placeholder="Cerca un appartamento...">
      <label for="number-guests-search">Ospiti(<em>minimo</em>):
        <input type="number"  class="form-control guests-arr guests" id="number-guests-search" min="0" max="15" value="0" >
      </label>
      <label for="number-rooms-search">Stanze(<em>minimo</em>):
        <input type="number" class="form-control guests-arr rooms" id="number-rooms-search" min="0" max="15" value="0" >
      </label>
      <label for="number-baths-search">Bagni(<em>minimo</em>):
        <input type="number" class="form-control guests-arr baths" id="number-baths-search" min="0" max="15" value="0" >
      </label>
      <button id ="submit-search" class="btn btn-primary">Submit</button>
      <div class="alert alert-danger hide">Purtroppo non è stato trovato nessun luogo con quel nome</div>
      <div class="filters-search">
        @foreach($services as $service)
          <label for="{{$service->slug}}">{{$service->name}}</label>
          <input id="{{$service->slug}}"class="filter-checkbox-search" type="checkbox" value="{{$service->slug}}">
        @endforeach
        <br>
        <label for="radius-range">Range di ricerca:</label>
        <input id="radius-range" type="range"  min="1" max="40" step="1" value="20">
        <span><span id="range-value">20</span>KM</span>
      </div>
    </div>
  </div>
</div>
<div class="container flat-searched-container hide">
  <div class="row justify-content-center ">
    <div id="flats-searched" class="d-flex">
    </div>
  </div>
</div>



@endsection


{{-- @forelse ($flats as $flat)

    <div class="card card-flat" data-lat="{{$flat->position->getLat()}}" data-lon="{{$flat->position->getLng()}}" style="width: 18rem;">
      <img class="card-img-top" src="
      @if ($flat->flatInfo->image_path)
          {{asset("storage/" . $flat->flatInfo->image_path)}}
      @else
          {{asset("img/standard.jpg")}}
      @endif
      " alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title">{{$flat->title}}</h5>
        <p class="card-text">{{$flat->flatInfo->description}}</p>
      </div>
      <a href="{{route("admin.flats.show", ["flat"=>$flat->id])}}" class="btn btn-primary" id="details-flat">Dettagli</a>
      @foreach($services as $service)
      @if($flat->services->contains($service->id)) 
      <div class="data-services hide">{{$service->slug}}{{$loop->last ? '' : ','}}</div>
      @endif 
      @endforeach
    </div>
      @empty
        <span>nada</span>
      @endforelse --}}