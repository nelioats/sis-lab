<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioEstoque extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_envio',
        'itemCatalogo_id',
        'itemNome',
        'comprasnota_id',
        'codCompraItem',
        'quantidadeItem',
        'valorUndItem',
        'valorTotalItem',

        'responsavelEnvio',
        'dataEnvio',
        'statusItem',
    ];
}

