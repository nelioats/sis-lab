<?php

namespace App\Models;

use App\Models\Unidade;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'perfil',
        'unidade_id',
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




    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            unset($this->attributes['password']);
            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    public function getNomeIP($id){
       $unidade = Unidade::where('id','=',$id)->first();
        $nomeIP = '';

       if($unidade == null){
        $nomeIP = '';
       }else{
        $nomeIP = $unidade->nome;
       }


        return  $nomeIP;
    }

    public function getNomeLaboratorio($id){
        $laboratorio = Laboratorio::where('id','=',$id)->first();
         $laboratorioUser = $laboratorio->prefixo;
         return  $laboratorioUser;
     }

     public function primeiroNome(){
        $nomeCompleto = explode(" ", $this->name);
        $primeiroNome = $nomeCompleto[0];
        return $primeiroNome;
     }


}
