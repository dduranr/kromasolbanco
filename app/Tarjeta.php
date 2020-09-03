<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    // Este array contiene los atributos que pueden editarse. Por lo que cualquier formulario destinado a editar books, solamente guardará en la BBDD los campos de este array, ningún otro.
    protected $fillable = [
        'cliente', 'numero', 'tipo', 'sucursal', 'en_tramite', 'beneficiarios'
    ];

    // Aquí se indica el nombre de la tabla de la BBDD donde se guardarán los books

    protected $table = 'tarjetas';
    // Aquí se indica cómo debe tratarse cada columna. Es decir, se indica al modelo que convierta automáticamente las columnas JSON en arrays, la columna ID en int, etc. De esta manera recibiremos $category->loquesea como array y no necesitamos hacer json_decode().
    // protected $casts = [
    //     'category' => 'integer'
    // ];
}
