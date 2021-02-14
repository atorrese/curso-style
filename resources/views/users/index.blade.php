@extends('layout')
@section('title',"Usuarios")
@section('content')
        <h1>{{$title}}</h1>
        <a href="{{ route('users.create') }}"
            class="btn btn-success" title="Crear Usuario">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>
        <table class="table table-light">
            <thead>
                <th>Id </th>
                <th>Nombre </th>
                <th>Correo </th>
                <th>Acciones </th>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>

                    <td>
                        <form class="m-0" action="{{ route('users.destroy', $user) }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <a href="{{ route('users.show',$user) }}" {{-- {{ route('users.show', ['user'=>$user]) }} --}}
                                class="btn btn-info " title="Ver Detalle">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                           </a>
                           <a href="{{ route('users.edit',$user) }}"
                               class="btn btn-warning" title="Editar Usuario">
                               <i class="fa fa-edit" aria-hidden="true"></i>
                           </a>
                            <button type="submit"
                            class="btn btn-danger" title="Eliminar Usuario">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        </form>

                    </td>
                </tr>
                @empty
                    <tr>
                        <td>No hay usuarios registrados.</td>
                    </tr>

                @endforelse   
            </tbody>
        </table>

{{--         <ul>
            @forelse ($users as $user)
                <li>
                    {{$user->name}}, ({{$user->email}})
                    <a href="{{ route('users.show', ['id'=>$user->id]) }}">Ver detalles</a>
                </li>
            @empty
                <li>No hay usuarios registrados.</li>
            @endforelse   
        </ul>  --}}     
@endsection
{{-- @section('sidebar')
    @parent
    <h2>Barra Lateral personalizada</h2>
@endsection --}}
    