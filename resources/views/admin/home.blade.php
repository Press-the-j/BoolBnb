@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Pagina ADMIN</h1>
        <div class="col-md-8">
          <a href="{{route('admin.flats.index')}}">Tutti o tuoi appartamenti</a>
          <a href="{{route('admin.flats.create')}}" class="new-flat">+ aggiungi un appartamento</a>
          <form>
              <div class="form-group">
                  <input type="text" class="form-control" id="search-input" placeholder="Cerca un appartamento...">

              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          {{-- Bottone dei messaggi, poi lo sposteremo nell'Header(?forse?) --}}
          <div class="dropdown message-box">
            @if($unreadMessages['exist'])
            <div class="circle-notice">
              <span class="number-notice">{{$unreadMessages['count']}}</span>
            </div>
            @endif
            <button class="btn btn-secondary dropdown-toggle" type="button" id="message-box-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-inbox"></i>
            </button>
            {{-- Dropdown dei messaggi, poi lo sposteremo nell'Header(?forse?) --}}
            <div class="dropdown-menu" aria-labelledby="message-box-dropdown">
              <ul class="list-group list-group-flush">
                @forelse($allMessages as $message)
                <li class="list-group-item {{$message['is_read'] !==0 ? '' : 'unread-message'}}">
                  <a class="message-link"href="{{route('admin.messages.index', ['messageClicked'=>$message['id']])}}">
                    <strong> {{$message['email']}}</strong>
                    <p>{{$message['content']}}</p>
                  </a>
                </li>
                @empty 
                <span>Non ci sono messaggi</span>
                @endforelse
              </ul>
            </div>
            {{--------------fine dropdown-------------- --}}
          </div>
    </div>
</div>


@endsection

