@extends('layouts.app')

@section('content')
@include('layouts.dashboard')

<div class="container-fluid container-admin container-chart">
  <div class="row row-chart">
    <input type="hidden" id="user-id-pieChart"value="{{Auth::id()}}">
    <div class="weekly-chart chart">
      <h2>Visualizzazioni settimanali:</h2>
      <select  id="flats-chart-select">
        @forelse($flats as $flat)
        <option {{$flat->id == $id ? 'selected' : ''}} value="{{$flat->id}}">{{$flat->title}}</option>
        @empty
        <option value="0">Nessun Appartamento</option>
        @endforelse
      </select>
      <canvas id="flat-chart" width="300" height="300"></canvas>
    </div>
    <div class="chart">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Visualizzazioni Totali: <span class="tot-views"></span></li>
        <li class="list-group-item">Media visualizzazioni: <span class="media-views"></span><small>(Al giorno)</small></li>
        <li class="list-group-item">Tempo di promozione: <span class="promotion-time"></span> <small>gg</small></li>
        <li class="list-group-item">Media visualizzazioni in promozione: <span class="media-promoted-views"></span><small>(Al giorno)</small></li>
      </ul>
    </div>
    <div class="pie-chart chart">
      <h2>Visualizzazioni Totali:</h2>
      <canvas id="flat-chart-pie" width="300" height="300"></canvas>
    </div>
  </div>
</div>

@endsection