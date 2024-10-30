<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

     protected $fillable = [
        'name',
        'official_name',
        'currencies_name',
        'currencies_symbol',
        'region',
        'languages',
        'google_maps',
        'open_street_maps',
        'timezones',
        'flag_svg'
    ];

    protected $visible = [
        'name',
        'official_name',
        'currencies_name',
        'currencies_symbol',
        'region',
        'languages',
        'google_maps',
        'open_street_maps',
        'timezones',
        'flag_svg'
    ];
}
