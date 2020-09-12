@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="weekly-chart">
      <h2>Visualizzazioni settimanali:</h2>
      <select  id="flats-chart-select">
        @forelse($flats as $flat)
        <option {{$flat->id == $id ? 'selected' : ''}} value="{{$flat->id}}">{{$flat->title}}</option>
        @empty
        <option value="">Nessun Appartamento</option>
        @endforelse
      </select>
      <canvas id="flat-chart" width="300" height="300"></canvas>
    </div>
  </div>
</div>

@endsection