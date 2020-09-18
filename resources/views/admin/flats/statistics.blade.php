@extends('layouts.app')

@section('content')
@include('layouts.dashboard')

<div class="container container-admin">
  <div class="row">
    <div class="weekly-chart">
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
  </div>
</div>

@endsection