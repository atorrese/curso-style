@extends('layout')
@section('title',"Crear Usuario")
@section('content')
    <div class="card">
      <div class="card-header">
        <h2>Editar Usuario</h2>
      </div>
      <div class="card-body">
        <form action="{{ url("usuarios/{$user->id}") }}" method="POST" class="">
          {{ method_field('PUT') }}
          {{ csrf_field() }}
          <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Nombre</label>
              <div class="col-sm-10">
                <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" id="name" name="name" value="{{old('name',$user->name)}}">
                @if ($errors->has('name'))
                <div class="invalid-feedback">
                  <p>{{$errors->first('name')}}</p>
                </div>
                @endif
              </div>
          </div>
          <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">Correo Electrónico</label>
              <div class="col-sm-10">
                <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" id="email" name="email" value="{{old('email',$user->email)}}">
                @if ($errors->has('email'))
                <div class="invalid-feedback">
                  <p>{{$errors->first('email')}}</p>
                </div>
                @endif
              </div>
          </div>
          <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
              <div class="col-sm-10">
                <input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" id="password" name="password" value="{{old('password')}}">
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                      <p>{{$errors->first('password')}}</p>
                    </div>
                @endif
              </div>
          </div>
          <div class="form-group row text-center">
              <div class="col-sm-10">
                  <button type="submit" title="Guardar" class="btn btn-info"><i class="fa fa-save"></i></button>
                  <a href="{{ route('users.index') }}"
                  class="btn btn-danger" title="Volver ">
                      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                  </a>
              </div>
            </div>
      </form>
      </div>
    </div>

@endsection