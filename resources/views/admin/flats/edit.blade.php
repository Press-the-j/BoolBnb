@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="flat-container">
    <form action="{{route('admin.flats.update', ['flat'=>$flat->id])}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
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
        <label for="image">Immagine di copertina</label>
      <input name="image" type="file" class="form-control" id="image">
      </div>
      <div class="form-group">
        <label for="title">Titolo:</label>
      <input name="title" type="text" class="form-control" id="title" value="{{old('title', $flat->title) ?? $flat->title}}">
      </div>
      <div class="form-group">
        <label for="description">Descrizione:</label>
        <textarea name="description" type="text" class="form-control" id="description"> {{old('description', $flat->flatInfo->description) ?? $flat->flatInfo->description}} </textarea>
      </div>
      <div class="form-group">
        <label for="city">Città:</label>
        <input name="city" type="text" class="form-control" id="city" value="{{old('city', $flat->flatInfo->city) ?? $flat->flatInfo->city}}">
      </div>
      <div class="form-group">
        <label for="address">Indirizzo:</label>
        <input name="address" type="text" class="form-control" id="address" value="{{old('address',$flat->flatInfo->address) ?? $flat->flatInfo->address}}">
      </div>
      <div class="form-group">
        <label for="postal_code">Codice Postale:</label>
        <input name="postal_code" type="text" class="form-control" id="postal_code" value="{{old('postal_code', $flat->flatInfo->postal_code) ?? $flat->flatInfo->postal_code}}">
      </div>
      <div class="form-group">
        <label for="square_meters">Metri quadrati:</label>
        <input name="square_meters" type="text" class="form-control" id="square_meters" value="{{old('square_meters', $flat->flatInfo->square_meters) ?? $flat->flatInfo->square_meters}}">
      </div>
      <div class="form-group">
        <label for="price">Prezzo per notte:</label>
        <input name="price" type="text" class="form-control" id="price" value="{{old('price', $flat->flatInfo->price) ?? $flat->flatInfo->price}}">
      </div>
      <div class="form-group">
        <label for="max_guest">Ospiti Max:</label>
        <input name="max_guest" type="text" class="form-control" id="max_guest" value="{{old('max_guest', $flat->flatInfo->max_guest) ?? $flat->flatInfo->max_guest}}">
      </div>
      <div class="form-group">
        <label for="rooms">Numero di stanze:</label>
        <input name="rooms" type="text" class="form-control" id="rooms" value="{{old('rooms', $flat->flatInfo->rooms) ?? $flat->flatInfo->rooms}}">
      </div>
      <div class="form-group">
        <label for="baths">Numero di bagni:</label>
        <input name="baths" type="text" class="form-control" id="baths" value="{{old('baths', $flat->flatInfo->baths) ??$flat->flatInfo->baths}}">
      </div>
      <div class="form-group">
        @foreach ($services as $service)
        <input 
        @if ($errors->any())
          {{in_array($service->id, old('services', [])) ? 'checked' : ''}}     
        @else
          {{$flat->services->contains($service) ? 'checked' : ''}}
        @endif  
        type="checkbox" value="{{$service->id}}" name="services[]" id="{{$service->name}}">
        <label for="{{$service->name}}">{{$service->name}}</label>
        @endforeach
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
      
    </div>
  </div>
</div>

@endsection