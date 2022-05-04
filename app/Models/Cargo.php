<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $table = "cargos";
    protected $primarykey="IDPERSONAL";
    protected $fillable=['IDCARGO','DESCRIPCION', 'SUELDO_BASICO'];
}
