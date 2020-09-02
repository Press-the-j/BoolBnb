@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="flat-container">
    <form action="{{route('admin.flats.update')}}"></form>
      <div class="image-flat">
        <img class="img-fluid"src="
        @if ($flat->flatInfo->image_path)
          {{asset('storage/' . $flat->flatInfo->image_path)}}
        @else
          {{asset('img/standard.jpg')}}
        @endif
        " alt="">
      </div>
      
    </div>
  </div>
</div>

@endsection