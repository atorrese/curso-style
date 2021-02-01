<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (request()->has('empty')) {
            $users = [];
        }else{
            $users = [
                'Angel',
                'Karina',
                'Saul',
                'Karen',
                'Mariana',
                'Juan',
                '<script> alert("hola")</script>',
            ];
        }
        /**return view('users',[
            'users'=> $users,
            'title'=> 'Listado de Usuarios',
        ]);**/

        /**return view('users')
        ->with('users',$users)
        ->with('title','Listado de Usuarios');**/
        $title= 'Listado de Usuarios';
        #dd(compact('title','users'));
        return view('users.index',compact('title','users'));

    }

    public function show($id)
    {
        return  view('users.show',compact('id')); 
    }

    public function create()
    {
        return 'Crear nuevo usuario';
    }
   
    public function edit($id)
    {
        return "Editar usuario: {$id}";
    }

}
