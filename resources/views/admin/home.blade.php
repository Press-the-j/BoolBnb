@extends('layouts.app')

@section('content')
@include('layouts.dashboard')

<div class="container container-admin">
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card register-container my-5">
              <h1 class="card-header">Profilo</h1>

              <div class="card-body">
                  <form autocomplete="off" method="POST" action="{{ route('admin.user.update') }}">
                      @csrf
                      @method('PUT')
                      <div class="form-group row">

                          <div class="col-md-12">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                  name="name" value="{{ old('name', $user->name) }}" required autocomplete="new-name" autofocus
                                  placeholder="Nome">
                                  
                              @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>
                      <div class="form-group row">

                          <div class="col-md-12">
                              <input id="surname" type="text"
                                  class="form-control @error('surname') is-invalid @enderror" name="surname"
                                  value="{{ old('surname', $user->surname) }}" required autocomplete="new-surname" autofocus
                                  placeholder="Cognome">

                              @error('surname')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>
                      <div class="form-group row">

                          <div class="col-md-12">
                              <input id="date_birth" type="date"
                                  class="form-control @error('date_birth') is-invalid @enderror" name="date_birth"
                                  value="{{ old('date_birth', $user->date_birth) }}" required autocomplete="new-date_birth" autofocus
                                  placeholder="Data di Nascita*">

                              @error('date_birth')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">

                          <div class="col-md-12">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                  name="email" value="{{ old('email', $user->email) }}" required autocomplete="new-email"
                                  placeholder="Indirizzo E-Mail*">

                              @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>

                     
                      <div class="form-group row mb-0 mt-3">
                          <div class="col-md-12">
                              <button type="submit" class="btn btn-primary">
                                  Aggiorna
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
              <small>{{ __('*Campi obbligatori') }}</small>
          </div>
      </div>
  </div>
</div>




@endsection