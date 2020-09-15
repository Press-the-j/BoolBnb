@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <form action="{{route('admin.flats.store')}}" method="post"  enctype="multipart/form-data" id="flats-create">
        @csrf
        <div class="form-group">
          <label class="col-form-label text-md-left" for="image-create">Immagine di copertina</label>
          <input id="image-create" type="file" name="image" class="form-control-file">
        </div>
        <div class="form-group">
          <label for="title-create">Titolo:</label>
          <input name="title" type="text" class="form-control title-input" id="title-create"  aria-describedby="title" placeholder="Inserisci un titolo" value="{{old("title")}}">
          <small id="title-create" class="form-text text-muted">inserisci un titolo al tuo annuncio</small>
          @error('title')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="description-create">Descrizione:</label>
          <textarea name="description" type="text" class="form-control description-input" id="description-create"  placeholder="Descrizione.." >{{old("description")}}</textarea>
          @error('description')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="city-create">Città:</label>
          <input name="city" type="text" class="form-control city-input" id="city-create"  placeholder="Città.." value="{{old("city")}}">
          @error('city')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="address-create">Indirizzo:</label>
          <input name="address" type="text" class="form-control address-input" id="address-create" placeholder="Indirizzo.." value="{{old("address")}}">
          @error('address')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="postal_code-create">Codice Postale:</label>
          <input name="postal_code" type="text" class="form-control postal_code-input" id="postal_code-create" value="{{old("postal_code")}}">
          @error('postal_code')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="square_meters-create">Metri quadrati:</label>
          <input name="square_meters" type="text" class="form-control square_meters-input" id="square_meters-create" value="{{old("square_meters")}}">
          @error('square_meters')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="price-create">Prezzo per notte:</label>
          <input name="price" type="text" class="form-control price-input" id="price-create" value="{{old("price")}}">
          @error('price')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="max_guest-create">Ospiti Max:</label>
          <input name="max_guest" type="text" class="form-control max_guest-input" id="max_guest-create" value="{{old("max_guest")}}">
          @error('max_guest')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="rooms-create">Numero di stanze:</label>
          <input name="rooms" type="text" class="form-control rooms-input" id="rooms-create" value="{{old("rooms")}}">
          @error('rooms')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="baths-create">Numero di bagni:</label>
          <input name="baths" type="text" class="form-control baths-input" id="baths-create" value="{{old("baths")}}">
          @error('baths')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          @foreach ($services as $service)
          <input type="checkbox" value="{{$service->id}}" name="services[]" id="{{$service->name}}" {{in_array($service->id, old("services", [])) ? "checked" : ''}}>
          <label for="{{$service->name}}">{{$service->name}}</label>
          @endforeach
        </div>
        <input name="lat" type="hidden" value="" id="create-lat">
        <input name="long" type="hidden" value="" id="create-long">
        <button id="submit-create" type="submit" class="btn btn-primary" >Submit</button>
      </form>
    </div>
</div>

@endsection
@section("validation-script")
<script src="{{asset("./js/validation.js")}}"></script>
@endsection