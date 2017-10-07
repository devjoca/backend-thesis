<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public const ADMIN = 1;
    public const DEVELOPER = 2;
}
