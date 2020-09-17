@extends('layouts.app')

@section('content')
@include('layouts.dashboard')
<div class="container">
  <div class="row">
    <div class="flat-container ">
    {{-- <a href="{{route('admin.flats.create')}}" class="btn btn-primary">Crea un appartamento</a> --}}
      <div class="promotedFlat ">
        <div class="promotedFlat-container container-flat-index">
          @forelse ($flatsPromoted as $flatPromoted)
          <div class="card card-flat" data-lat="{{$flatPromoted->position->getLat()}}" data-lon="{{$flatPromoted->position->getLng()}}"  style="width: 18rem;">
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
          @endforelse
        </div>
      </div>
      <div class="allFlats ">
        <div class="allFlats-container container-flat-index">
          @forelse($flats as $flat)
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
              <div class="services-flat">
                @forelse ($services as $service)
                  
                  @if ($flat->services->contains($service))
                 <div class="service-flat-container">
                    <i class="fas fa-check-circle"></i><span>{{$service->name}}</span>
                 </div>
                 @endif
                @empty
                    
                @endforelse
              </div>
            </div>
            <form action="{{route("admin.flats.destroy", ["flat"=>$flat->id])}}" method="post">
              @method("DELETE")
              @csrf
              <button type="submit" class="btn btn-danger">Elimina</button>
            </form>
            <a href="{{route("admin.flats.edit", ["flat"=>$flat->id])}}" class="btn btn-primary">Modifica</a>
          <a href="{{route("admin.flats.show", ["flat"=>$flat->id])}}" class="btn btn-primary details-flat details-flat-home">Dettagli</a>
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