<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    // сколько заявок выводить на одной странице
    const SHOW_BY_DEFAULT = 5;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'subject', 'message', 'file',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
