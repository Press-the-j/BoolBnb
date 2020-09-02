@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="flat-container">
      <div class="image-flat">
        <img src="
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
        <p class="description-flat lead">{{$flat->flatInfo->description}}</p>
      </div>
      <div class="flat-map-container">
        <div class="flat-position-info-row">
          <ul class="flat-position-info">
            <li>Indirizzo:</li>
            <li>Città:</li>
            <li>Codice-Postale</li>
          </ul>
        </div>
        <div class="map-address-flat"></div>
      </div>
      <div class="flat-info-row">
        <ul class="flat-info">
          <li>Metri Quadrati: {{$flat->flatInfo->square_meters}}</li>
          <li>Limite Ospiti: {{$flat->flatInfo->max_guest}}</li>
        </ul>
        <span class="price-box">
          {{$flat->flatInfo->price}} &euro 
        </span>
      </div>
      <div class="services-flat-row">
        <ul class="services-flat">
          <li>fakeservizio1</li>
          <li>fakeservizio2</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection