<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    public function detallesventa(){
        return $this->hasMany(DetalleVenta::class,'venta_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
