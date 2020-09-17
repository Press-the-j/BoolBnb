@extends('layouts.app')

@section('content')
@include('layouts.dashboard')

<div class="box-message-wrapper">
  <div class="message-received-list">
    @forelse ($allMessages as $message)
    <div class="message-row">
    <div class="d-flex message-row-title 
    {{$message['id'] == $idClicked ? 'selected' : ''}}
    {{$message['is_read'] == 0 ? 'unread' : ''}}" data-message="{{$message['id']}}">
        <span class="d-flex align-items-center">{{$message['email']}}</span>
      </div>
      <div class="message-row-content hide">
        <p class="message-row-content-email">{{$message['email']}}</p>
        <p class="message-row-content-text">{{$message['content']}}</p>
      </div>
    </div>
    @empty
        
    @endforelse
  </div>
  <div class="message-received-box hide">
    @forelse ($allMessages as $message)
      <div class="message-received-content" data-message="{{$message['id']}}">
        <p class="message-received-content-email">{{$message['email']}}</p>
        <p class="message-received-content-text">{{$message['content']}}</p>
      </div> 
    @empty
        
    @endforelse
  </div>
</div>

@endsection


{{-- <table class="table table-hover table-dark">
  <thead>
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Messaggio</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($allMessages as $message)
    <tr>
      <td>{{$message['email']}}</td>
      <td>{{$message['content']}}</td>
    </tr>
    @empty
      <tr>
        <td colspan="3">Non ci sono Messaggi</td>  
      </tr>
    @endforelse
  
  </tbody>
</table>
--}}