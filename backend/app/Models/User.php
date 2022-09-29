<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function create($fields)
    {
        return parent::create([
            'name' => $fields['name'],
            'email' => $fields['email'] ,
            'password' => Hash::make($fields['password']),
        ]);
    }

    public function login($credentials)
    {
        if(!Auth::attempt($credentials)){
            throw new \Exception('Credencias incorretas, verifique-as e tente novamente.', -404);
        }

        $user = $this->where('email', $credentials['email'])->first();

        $token = $user->createToken("api_token")->plainTextToken;       

        return $token;
    }

    public function logout($var = null)
    {
        # code...
    }

    public function tasklist(){
        return $this->hasMany('App\Models\TaskList', 'user_id', 'id');
    }
    
    public function tasks(){
        return $this->hasMany('App\Models\Tasks');
    }
    
}
