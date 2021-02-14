<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function show(User $user)
    {

        return  view('users.show',compact('user')); 
    }

    public function create()
    {
        return view('users.create');
    }
    public function store()
    {
        $data = request()->validate([
                'name' => 'required',
                'email' =>['required','email','unique:users,email'],// 'required|emai|unique:users,email',
                'password' => 'required'
            ],[
                'name.required' => 'El Campo es Obligatorio'
            ]);
        //dd($data);
        User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>bcrypt($data['password']),
            ]);

        return redirect()->route('users.index');
    }
   
    public function edit(User $user)
    {
        return view('users.edit',['user'=>  $user]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name'=>'required',
            'email'=>[
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],//'required|email|unique:users,email,'.$user->id,//
            'password'=>'',
            ]);
        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        }else{
            unset( $data['password']);
        }
        //dd($data);

        $user->update($data);
        return  redirect()->route('users.show',['user'=>$user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

}
