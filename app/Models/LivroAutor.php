<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivroAutor extends Model
{
    use HasFactory;

    protected $table      = 'livro_autor';

    protected $guarded    = [];

    public    $timestamps = false;
}
