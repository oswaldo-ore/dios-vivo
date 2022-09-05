<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(){
        $rols= Rol::where('id','!=',1)->get();
        return view('admin.rol.index',compact('rols'));
    }
}
