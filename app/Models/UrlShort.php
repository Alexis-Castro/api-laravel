<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
    use HasFactory;

    protected $table = "URL_SHORTENER";
    protected $primarykey = "ID_URL";
    protected $fillable = ['SHORTEN_URL', 'FULL_URL', 'CLICKS'];
}
