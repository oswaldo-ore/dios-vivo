<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'telephone',
        'last_name',
        'rol_id',
        'ci',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }
    //usuarios q no son super admin
    public static function users()
    {
        return User::whereHas('rol', function ($query) {
            $query->where('id', '!=', 1);
        })->withTrashed()->paginate(10);
    }
    //usuarios con su rol q no son super admin
    public static function usersWithRol()
    {
        return User::whereHas('rol', function ($query) {
            $query->where('id', '!=', 1);
        })->withTrashed()->with('rol')->paginate(10);
    }

    //usuarios q son super admin
    public static function usersSuperAdmin()
    {
        return User::whereHas('rol', function ($query) {
            $query->where('id', '=', 1);
        })->get();
    }

    //create user administrador
    public static function createUser($request)
    {
        return User::create([
            'ci' => $request->ci,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);
    }

    //update user administrador
    public static function updateUser($request, $user)
    {
        return $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'rol_id' => $request->rol_id,
        ]);
    }

    public static function updateMyProfile($request,$user){
        if($request->has('change_password')){
            $user->password = Hash::make($request->new_password);
        }
        return $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $user->password,
        ]);
    }
}
