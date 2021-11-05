<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UninstallUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'domain',
        'country_name',
        'customer_email',
        'shop_owner'
    ];
}
