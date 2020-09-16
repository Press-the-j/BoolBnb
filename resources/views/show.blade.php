@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

    <div class="coordinate-hide">
      <span class="lat hide">{{$lat}}</span>
      <span class="lon hide">{{$lon}}</span>
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
        <div class="description-flat">
          <p class="description-flat-text lead ">{{$flat->flatInfo->description}}</p>
          <div class="flat-info-row">
            <ul class="flat-info list-group-flush">
              <li class="list-group-item"><strong>Metri Quadrati:</strong> {{$flat->flatInfo->square_meters}}</li>
              <li class="list-group-item"><strong>Limite Ospiti:</strong> {{$flat->flatInfo->max_guest}}</li>
              <li class="list-group-item"><strong>Numero di stanze:</strong> {{$flat->flatInfo->rooms}}</li>
              <li class="list-group-item"><strong>Numero di bagni:</strong> {{$flat->flatInfo->baths}}</li>
            </ul>
            <ul class="flat-info-services">
              @forelse ($flat->services as $service)
                <li><i class="fas fa-check-circle"></i>{{$service->name}}</li>
              @empty
                <li></li>
              @endforelse
            </ul>
          </div>
          <div class="flat-position-info-row hide">
            <ul class="flat-position-info">
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
        </div>
        @if(session()->has('message-success'))
        <div class="alert alert-success">{{session()->get('message-success')}}</div>
        @endif
        <div class="message-box-show col-12 col-md-8 col-lg-6">
          <form action="{{route('messages.send', ['flat'=>$flat->id])}}" method="post">
            @csrf
            <div class="box-row price-border">
              <span class="price-box">
                {{$flat->flatInfo->price}} &euro; <small>(per notte)</small> 
              </span>
            </div>
            <div class="box-row">
              <input type="email" id="sender-email" name="email" placeholder="Inserisci una email..." 
              @if(Auth::check())
                value="{{Auth::user()->email}}"
              @endif>
            </div>
            <div class="box-row">
              <textarea name="message-content" id="message-content" cols="30" rows="10" placeholder="Scrivi un messaggio..."
              style="height:200px; resize:none;"></textarea>
            </div>
            <button type="submit" class="btn "> Invia</button>
          </form>
        </div>
      </div>
      
      
      
      <div class="map-container-flat col-12">
        {{-- qui andrà renderizzata la mappa --}}
        <div id="map">
         
        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection