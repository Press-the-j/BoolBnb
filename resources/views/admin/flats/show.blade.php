@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

    <div class="coordinate-hide">
      <span class="lat hide">{{$lat}}</span>
      <span class="lon hide ">{{$lon}}</span>
    </div>

  <div class="flat-container" >
      <div class="image-flat">
        <img class="img-fluid"src="
        @if ($flat->flatInfo->image_path)
          {{asset('storage/' . $flat->flatInfo->image_path)}}
        @else
          {{asset('img/standard.jpg')}}
        @endif
        " alt="">
      </div>
      <div class="title-flat-row">
        <h3 class="title-flat">{{$flat->title}}</h3>
      </div>
      <div class="description-flat-row">
        <p class="description-flat ">{{$flat->flatInfo->description}}</p>
      </div>
      <div class="flat-info-row">
        <ul class="flat-info">
          <li>Metri Quadrati: {{$flat->flatInfo->square_meters}}</li>
          <li>Limite Ospiti: {{$flat->flatInfo->max_guest}}</li>
          <li>Numero di stanze: {{$flat->flatInfo->rooms}}</li>
          <li>Numero di bagni: {{$flat->flatInfo->baths}}</li>
          @forelse ($flat->services as $service)
            <li>{{$service->name}}</li>
          @empty
            <li></li>
          @endforelse
        </ul>
        <span class="price-box">
          {{$flat->flatInfo->price}} &euro; 
        </span>
      </div>
      
      <div class="flat-position-info-row">
        <ul class="flat-position-info list-group ">
          <li class="list-group-item">
            <strong> Indirizzo: </strong>
            <span class="address-flat">{{$flat->flatInfo->address}}</span>
          </li>
          <li class="list-group-item">
            <strong>città: </strong>
            <span class="city-flat"> {{$flat->flatInfo->city}}</span>
          </li>
          <li class="list-group-item">
          <strong>Codice-Postale: </strong>
          <span class="postal_code-flat">{{$flat->flatInfo->postal_code}}</span>
          </li>
        </ul>
      </div>
      <div class="map-container-flat">
        {{-- qui andrà renderizzata la mappa --}}
        <div id="map">
         
        </div>
      </div>
    </div>
  </div>
</div>

@endsection