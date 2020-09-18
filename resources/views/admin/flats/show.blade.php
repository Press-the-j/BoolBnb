@extends('layouts.app')

@section('content')
@include('layouts.dashboard')
<div class="container container-admin">
  <div class="row">

    <div class="coordinate-hide">
      <span class="lat hide">{{$lat}}</span>
      <span class="lon hide ">{{$lon}}</span>
    </div>

  <div class="flat-container" >
    <div class="cta-show-admin">
      @if($flat->is_promoted ==0)
      <div class="form-group">
          <a href="{{route('admin.promotion.transaction', ['flat'=>$flat->id])}} " class="btn btn-warning">Promuovi appartamento</a>
      </div>
      @else
      <div class="form-group">
        <span class="alert alert-success">
          Appartamento Promosso fino a {{$dateEnd}}
        </span>
      </div>
      @endif
      <form action="{{route('admin.flats.statistics')}}" method="post">
        @csrf
        @method('POST')
        <div class="form-group">
        <input type="hidden" name="id" value="{{$flat->id}}">
          <button type="submit" class="btn btn-cta" > Guarda le statistiche</button>
        </div>
      </form>
      
      <div class="form-group">
        <a href="{{route("admin.flats.edit", ["flat"=>$flat->id])}}" class="btn btn-cta">Modifica</a>
      </div>
    </div>
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
        <div class="description-flat">
          <p class="description-flat-text lead ">{{$flat->flatInfo->description}}</p>
          <div class="flat-info-row">
            <ul class="flat-info list-group-flush">
              <li class="list-group-item">Metri Quadrati: {{$flat->flatInfo->square_meters}}</li>
              <li class="list-group-item">Limite Ospiti: {{$flat->flatInfo->max_guest}}</li>
              <li class="list-group-item">Numero di stanze: {{$flat->flatInfo->rooms}}</li>
              <li class="list-group-item">Numero di bagni: {{$flat->flatInfo->baths}}</li>
            </ul>
            <ul class="flat-info-services">
              @forelse ($flat->services as $service)
                <li><i class="fas fa-check-circle"></i> {{$service->name}}</li>
              @empty
                <li></li>
              @endforelse
            </ul>
          </div>
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
          <div class="price-box">
            {{$flat->flatInfo->price}} &euro; <small>(per notte)</small>
          </div>
        </div>
      </div>
      <div class="map-container-flat col-12">
        {{-- qui andrà renderizzata la mappa --}}
        <div id="map">
         
        </div>
      </div>
      <form action="{{route("admin.flats.destroy", ["flat"=>$flat->id])}}" method="post">
        @method("DELETE")
        @csrf
        <div class="form-group">
          <button type="submit" class="btn btn-danger">Elimina</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection