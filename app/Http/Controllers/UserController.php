<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();//DB::table('users')->get();
        //dd($users);
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
