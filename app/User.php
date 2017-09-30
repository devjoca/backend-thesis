<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeApplicant($query)
    {
        return $query->whereNull('approved_date')->whereUserTypeId(UserType::DEVELOPER);
    }

    public static function createDeveloper($name, $email)
    {
        self::create([
            'name' => $name,
            'email' => $email,
            'password' => '',
            'user_type_id' => UserType::DEVELOPER,
        ]);
    }

    public function approveAsDeveloper()
    {
        $this->approved_date = Carbon::now();
        $this->save();
    }
}
