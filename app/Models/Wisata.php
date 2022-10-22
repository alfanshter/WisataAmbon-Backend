<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_wisata', 'id');
    }
}
