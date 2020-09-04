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
          <input name="title" type="text" class="form-control" id="title-create" aria-describedby="title" placeholder="Inserisci un titolo">
          <small id="title-create" class="form-text text-muted">inserisci un titolo al tuo annuncio</small>
        </div>
        <div class="form-group">
          <label for="description-create">Descrizione:</label>
          <textarea name="description" type="text" class="form-control" id="description-create" placeholder="Descrizione.."></textarea>
        </div>
        <div class="form-group">
          <label for="city-create">Città:</label>
          <input name="city" type="text" class="form-control" id="city-create" placeholder="Città..">
        </div>
        <div class="form-group">
          <label for="address-create">Indirizzo:</label>
          <input name="address" type="text" class="form-control" id="address-create" placeholder="Indirizzo..">
        </div>
        <div class="form-group">
          <label for="postal_code-create">Codice Postale:</label>
          <input name="postal_code" type="text" class="form-control" id="postal_code-create">
        </div>
        <div class="form-group">
          <label for="square_meters-create">Metri quadrati:</label>
          <input name="square_meters" type="text" class="form-control" id="square_meters-create">
        </div>
        <div class="form-group">
          <label for="price-create">Prezzo per notte:</label>
          <input name="price" type="text" class="form-control" id="price-create">
        </div>
        <div class="form-group">
          <label for="max_guest-create">Ospiti Max:</label>
          <input name="max_guest" type="text" class="form-control" id="max_guest-create">
        </div>
        <div class="form-group">
          <label for="rooms-create">Numero di stanze:</label>
          <input name="rooms" type="text" class="form-control" id="rooms-create">
        </div>
        <div class="form-group">
          <label for="baths-create">Numero di bagni:</label>
          <input name="baths" type="text" class="form-control" id="baths-create">
        </div>
        <div class="form-group">
          @foreach ($services as $service)
          <input type="checkbox" value="{{$service->id}}" name="services[]" id="{{$service->name}}">
          <label for="{{$service->name}}">{{$service->name}}</label>
          @endforeach
        </div>
        <input name="lat" type="text" value="" id="create-lat">
        <input name="long" type="text" value="" id="create-long">
        <button id="submit-create" type="submit" class="btn btn-primary" >Submit</button>
      </form>
    </div>
</div>

@endsection
