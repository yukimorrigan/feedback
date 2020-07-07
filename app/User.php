<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function applications() {
        return $this->hasMany('App\Application');
    }

    public function hasRole($role)
    {
        return User::where('role', $role)->get()->count();
    }

    /*пользователь может создавать заявки*/
    public function canCreate() {
        # получить заявки, созданные за последние 24 часа
        $applications = $this->applications()->where('created_at', '>', Carbon::now()->subDay())->get();
        # если заявок не было - можно создать новую заявку
        return $applications->isEmpty();
    }
}
