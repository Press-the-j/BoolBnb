@extends('layouts.app')

@section('content')
@include('layouts.dashboard')
<div class="container container-admin">
  <div class="row">
    <div class="flat-container ">
    {{-- <a href="{{route('admin.flats.create')}}" class="btn btn-primary">Crea un appartamento</a> --}}
      <div class="promotedFlat ">
        <div class="promotedFlat-container container-flat-index">
          @forelse ($flatsPromoted as $flatPromoted)
          <div class="card card-flat card-flat-admin" data-lat="{{$flatPromoted->position->getLat()}}" data-lon="{{$flatPromoted->position->getLng()}}" data-id="{{$flatPromoted->id}}" style="width: 18rem;">
            <img class="card-img-top" src="
            @if ($flatPromoted->flatInfo->image_path)
                {{asset('storage/' . $flatPromoted->flatInfo->image_path)}}
            @else
                {{asset('img/standard.jpg')}}
            @endif
            " alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{{$flatPromoted->title}}</h5>
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
            <p class="card-service">Ospiti: {{$flatPromoted->flatInfo->max_guest }}, 
            Stanze: {{$flatPromoted->flatInfo->rooms}}, Bagni:  {{$flatPromoted->flatInfo->baths}}</p>
            </div>
          </div>
          @empty
          @endforelse
          <div class="allFlats ">
           <div class="allFlats-container container-flat-index">
            @forelse($flats as $flat)
            <div class="card card-flat card-flat-admin" data-lat="{{$flat->position->getLat()}}" data-lon="{{$flat->position->getLng()}}" data-id="{{$flat->id}}"style="width: 18rem;">
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
              <p class="card-service">Ospiti: {{$flat->flatInfo->max_guest }}, 
                Stanze: {{$flat->flatInfo->rooms}}, Bagni: {{$flat->flatInfo->baths}}</p>
            </div>
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

