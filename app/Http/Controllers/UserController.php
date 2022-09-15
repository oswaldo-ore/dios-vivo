<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //sacar todos los usuarios que no tengan el rol de superadmin
        $users = User::usersWithRol();
        $roles = Rol::getRoles();
        return view('admin.users.index', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $user = User::createUser($request);
            return redirect('admin/users')->with('success','Usuario registrado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','No se pudo crear el usuario'.$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = User::updateUser($request,$user);
            return redirect('admin/users')->with('success','Usuario actualizado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','No se pudo actualizar el usuario'.$th->getMessage());
        }
    }
    public function changeState(User $user){
        try {
            $user->is_enabled = !$user->is_enabled;
            $user->update();
            return response()->json(['message' => 'La categoría fue '.($user->is_enabled ?'activada':'desactivada').' correctamente']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error '.$th->getMessage()],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->deleteOrFail();
            return redirect('admin/users')->with("success", "Eliminado con éxito");
        } catch (\Throwable $th) {
            return back()->with("error", "No se pudo eliminar el usuario");
        }
    }
}
