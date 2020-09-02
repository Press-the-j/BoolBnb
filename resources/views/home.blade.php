@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <h1>Pagina GUEST</h1>
    <div class="col-md-8">
      @if(Auth::user())
          <a href="">
              <button class="new-flat">+ aggiungi un appartamento</button>
          </a>
      @endif
      <form>
        <div class="form-group">
          <input type="text" class="form-control" id="search-input" placeholder="Cerca un appartamento...">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>



@endsection
