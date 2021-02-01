<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUsersController extends Controller
{
    public function __invoke($name,$nickname)
    {
        $name = ucfirst($name);
        return "Bienvenido {$name}, tu apodo es {$nickname}";        
    }


    function without_nickname($name)
    {
        $name = ucfirst($name);
        return "Bienvenido {$name}";
    }
}
