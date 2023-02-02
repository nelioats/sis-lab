<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorioInsumosEquipamentos extends Model
{
    use HasFactory;
    protected $fillable = [
        'comprasnota_id',
        'unidade_id',
        'laboratorio_id',
        'itemCatalogo_id',
        'codCompraItem',
        'quantidadeItem',
        'valorUndItem',
        'valorTotalItem',

        'emitenteItem',
        'dataEnvioItem',
        'statusItem',
    ];
}
