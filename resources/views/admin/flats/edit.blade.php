@extends('layouts.app')

@section('content')
@include('layouts.dashboard')
<div class="container container-admin">
  <div class="row">
    <div class="flat-container">
      <form action="{{route('admin.flats.update', ['flat'=>$flat->id])}}" method="post" enctype="multipart/form-data" id="flats-edit">
        @csrf
        @method('PUT')
        <div class="hidden-flat col-6 ml-auto text-center ">
          <label for="is_hidden">Rendi non visibile l'appartamento</label>
          <input
            @if ($flat->is_hidden == 1)
                {{'checked'}}
            @endif
            name="is_hidden" type="checkbox" value="1" id="is_hidden">
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
        <div class="form-group">
          <label for="image-edit">Immagine di copertina</label>
        <input name="image" type="file" class="form-control-file" id="image-edit">
        </div>
        <div class="form-group">
          <label for="title-edit">Titolo:</label>
          <input name="title" type="text" class="form-control title-input" id="title-edit" value="{{old('title', $flat->title) ?? $flat->title}}">
          @error('title')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="description-edit">Descrizione:</label>
          <textarea name="description" type="text" class="form-control  description-input" id="description-edit"> {{old('description', $flat->flatInfo->description) ?? $flat->flatInfo->description}} </textarea>
          @error('description')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="city-edit">Città:</label>
          <input name="city" type="text" class="form-control city-input" id="city-edit" value="{{old('city', $flat->flatInfo->city) ?? $flat->flatInfo->city}}">
          @error('city')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="address-edit">Indirizzo:</label>
          <input name="address" type="text" class="form-control address-input" id="address-edit" value="{{old('address',$flat->flatInfo->address) ?? $flat->flatInfo->address}}">
          @error('address')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="postal_code-edit">Codice Postale:</label>
            <input name="postal_code" type="text" class="form-control postal_code-input" id="postal_code-edit" value="{{old('postal_code', $flat->flatInfo->postal_code) ?? $flat->flatInfo->postal_code}}">
            @error('postal_code')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group col-6">
            <label for="square_meters-edit">Metri quadrati:</label>
            <input name="square_meters" type="text" class="form-control square_meters-input " id="square_meters-edit" value="{{old('square_meters', $flat->flatInfo->square_meters) ?? $flat->flatInfo->square_meters}}">
            @error('square_meters')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="price-edit">Prezzo per notte:</label>
            <input name="price" type="text" class="form-control price-input" id="price-edit" value="{{old('price', $flat->flatInfo->price) ?? $flat->flatInfo->price}}">
            @error('price')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group col-6">
            <label for="max_guest-edit">Ospiti Max:</label>
            <input name="max_guest" type="text" class="form-control max_guest-input" id="max_guest-edit" value="{{old('max_guest', $flat->flatInfo->max_guest) ?? $flat->flatInfo->max_guest}}">
            @error('max_guest')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="rooms-edit">Numero di stanze:</label>
            <input name="rooms" type="text" class="form-control rooms-input" id="rooms-edit" value="{{old('rooms', $flat->flatInfo->rooms) ?? $flat->flatInfo->rooms}}">
            @error('rooms')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group col-6">
            <label for="baths-edit">Numero di bagni:</label>
            <input name="baths" type="text" class="form-control baths-input" id="baths-edit" value="{{old('baths', $flat->flatInfo->baths) ??$flat->flatInfo->baths}}">
            @error('baths')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="d-flex check-services">
          @foreach ($services as $service)
          <div class="form-group d-inline  ">
            <input 
            @if ($errors->any())
              {{in_array($service->id, old('services', [])) ? 'checked' : ''}}     
            @else
              {{$flat->services->contains($service) ? 'checked' : ''}}
            @endif  
            type="checkbox" value="{{$service->id}}" name="services[]" id="{{$service->name}}">
            <label class="mr-3" for="{{$service->name}}">{{$service->name}}</label>
          </div>
          @endforeach
        </div>
        <input class="hide" name="lat" type="text" value="" id="edit-lat">
        <input class="hide" name="long" type="text" value="" id="edit-long">
        <div>
          <button id="submit-edit"type="submit" class="btn  btn-edit">Aggiorna</button>
        </div>
    </form>
    </div>
  </div>
</div>

@endsection