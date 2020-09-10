@extends('layouts.app')

@section('content')

<div class="box-message-wrapper">
  <div class="message-received-list">
    @forelse ($allMessages as $message)
      <div class="d-flex message-row">
        <span class="d-flex align-items-center">{{$message['email']}}</span>
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