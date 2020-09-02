@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <form action="{{route('admin.flats.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label class="col-form-label text-md-left" for="image">Immagine di copertina</label>
          <input id="image" type="file" name="image" class="form-control-file">
        </div>
        <div class="form-group">
          <label for="title">Titolo:</label>
          <input name="title" type="text" class="form-control" id="title" aria-describedby="title" placeholder="Inserisci un titolo">
          <small id="title" class="form-text text-muted">inserisci un titolo al tuo annuncio</small>
        </div>
        <div class="form-group">
          <label for="description">Descrizione:</label>
          <textarea name="description" type="text" class="form-control" id="description" placeholder="Descrizione.."></textarea>
        </div>
        <div class="form-group">
          <label for="city">Città:</label>
          <input name="city" type="text" class="form-control" id="city" placeholder="Città..">
        </div>
        <div class="form-group">
          <label for="address">Indirizzo:</label>
          <input name="address" type="text" class="form-control" id="address" placeholder="Indirizzo..">
        </div>
        <div class="form-group">
          <label for="postal_code">Codice Postale:</label>
          <input name="postal_code" type="text" class="form-control" id="postal_code">
        </div>
        <div class="form-group">
          <label for="square_meters">Metri quadrati:</label>
          <input name="square_meters" type="text" class="form-control" id="square_meters">
        </div>
        <div class="form-group">
          <label for="price">Prezzo per notte:</label>
          <input name="price" type="text" class="form-control" id="price">
        </div>
        <div class="form-group">
          <label for="max_guest">Ospiti Max:</label>
          <input name="max_guest" type="text" class="form-control" id="max_guest">
        </div>
        <div class="form-group">
          @foreach ($services as $service)
          <input type="checkbox" value="{{$service->id}}" name="services[]" id="{{$service->name}}">
          <label for="{{$service->name}}">{{$service->name}}</label>
          @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
</div>

@endsection
