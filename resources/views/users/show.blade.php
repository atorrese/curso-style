@extends('layout')
@section('title',"Usuario {$user->id}")
@section('content')
    <h1>Usuario #{{$user->id}}</h1>
    <p class="text-right">
        <a href="{{ route('users.index') }}"
        class="btn btn-danger" title="Volver ">
            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
        </a>
   </p>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Datos del Usuario</h5>
        </div>
        <div class="card-body">
            
            <p class="m-0"><b>Nombre del usuario:</b> {{$user->name}}</p>
            <p class="m-0"><b>Correo Electronico:</b> {{$user->email}}</p>
            @if ($user->profession)
            <p class="m-0"><b>Profesión:</b> {{$user->profession->title}}</p> 
            @endif
            

            @if ($user->is_admin)
            <span class="badge badge-pill badge-success align-right">Administrador</span>
            @else
            <span class="badge badge-pill badge-info">Usuario Normal</span>
            @endif
        </div>
    </div>    
@endsection