@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="flat-container ">
      <div class="promotedFlat">
        <h2>appartamenti promossi</h2>
        <div class="promotedFlat-container d-flex">
          @forelse ($flatsPromoted as $flatPromoted)
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="
            @if ($flatPromoted->flatInfo->image_path)
                {{asset('storage/' . $flatPromoted->flatInfo->image_path)}}
            @else
                {{asset('img/standard.jpg')}}
            @endif
            " alt="Card image cap">
            <div class="card-body">
            <h5 class="card-title">{{$flatPromoted->title}}</h5>
            <p class="card-text">{{$flatPromoted->flatInfo->description}}</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <a href="{{route('admin.flats.show', ['flat'=>$flatPromoted->id])}}" class="btn btn-primary">Dettagli</a>
          </div>
          @empty
          <span>Non c'e niente</span>
          @endforelse
        </div>
      </div>
      <div class="allFlats">
        <h2>Ecco tutti gli appartamenti</h2>
        <div class="allFlats-container d-flex">
          @forelse($flats as $flat)
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="
            @if ($flat->flatInfo->image_path)
                {{asset('storage/' . $flat->flatInfo->image_path)}}
            @else
                {{asset('img/standard.jpg')}}
            @endif
            " alt="Card image cap">
            <div class="card-body">
            <h5 class="card-title">{{$flat->title}}</h5>
            <p class="card-text">{{$flat->flatInfo->description}}</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <a href="{{route('admin.flats.show', ['flat'=>$flat->id])}}" class="btn btn-primary">Dettagli</a>
          </div>
          @empty
            <span>nesun appartamento</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection