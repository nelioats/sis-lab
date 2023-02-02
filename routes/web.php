<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\ItensLaboratorioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('login');
// });

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin')->name('login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/saveuser', 'saveUser')->name('saveUser');

    Route::post('/verifica_login', 'verificaLogin')->name('verificaLogin');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(UserController::class)->group(function () {
        Route::get('/dashboard', 'showDashBoard')->name('dashboard');
        Route::get('/list_users', 'listUsers')->name('listUsers');
        Route::get('/list_users/editPerfil/{id}', 'editPerfil')->name('editPerfil');
        Route::post('/list_users/updatePerfil/{id}', 'updatePerfil')->name('updatePerfil');
    });

    Route::controller(LaboratorioController::class)->group(function () {
        Route::get('/insert_lab/{baseLab}', 'insertlab')->name('insertlab');//**
        Route::post('/salvar_lab', 'salvarlab')->name('salvartlab');
        Route::get('/list_lab/{baseLab}', 'list_lab')->name('list_lab'); //**
        Route::get('/detalhes_lab/{id}', 'detalheslab')->name('detalheslab');

        Route::get('/edit_lab/{id}', 'editlab')->name('editlab');
        Route::post('/update_lab/{id}', 'updatelab')->name('updatelab');

        Route::post('/salvar_data_entrega/{id}', 'salvardataEntrega')->name('salvardataEntrega');
        Route::post('/salvar_observacao/{id}', 'salvarObsesrvacao')->name('salvarObsesrvacao');
        Route::get('/destroy_lab/{id}', 'destroyLab')->name('destroyLab');
        Route::post('/devolver_estoque', 'devolverEstoque')->name('devolverEstoque');
        Route::post('/salvar_bens_moveis', 'salvarBensMoveis')->name('salvarBensMoveis');
        Route::post('/salvar_insumos_equipamentos', 'salvarInsumosEquipamentos')->name('salvarInsumosEquipamentos');

        //buscar itens enviados pelo estoque
        Route::get('/list_itens_enviados/{id}', 'list_itens_enviados')->name('list_itens_enviados');//json
        //confirmar recebimento
        Route::post('/confirmar_recebimento', 'confirmarRecebimento')->name('confirmarRecebimento');

    });

    Route::controller(ComponenteController::class)->group(function () {
        Route::get('/insert_componente', 'insertComponente')->name('insertComponente');
        Route::post('/salvar_componente', 'salvarComponente')->name('salvarComponente');
        Route::get('/edit_componente/{id}', 'editComponente')->name('editComponente');
        Route::post('/update_componente/{id}', 'updateComponente')->name('updateComponente');
        Route::get('/list_componente', 'listComponente')->name('listComponente');
        Route::get('/destroy_componente/{id}', 'destroyComponente')->name('destroyComponente');

    });

    Route::controller(CatalogoController::class)->group(function () {
        Route::get('/insert_catalogo/{natureza}', 'insertItemCatalogo')->name('insertItemCatalogo');
        Route::post('/salvar_catalogo', 'salvarItemCatalogo')->name('salvarItemCatalogo');
        Route::get('/list_catalogo/{natureza}', 'listItemCatalogo')->name('listItemCatalogo');
        Route::get('/destroy_catalogo/{id}', 'destroyItemCatalogo')->name('destroyItemCatalogo');
        Route::get('/edit_catalogo/{id}', 'editItemCatalogo')->name('editItemCatalogo');
        Route::post('/update_catalogo/{id}', 'updateItemCatalogo')->name('updateItemCatalogo');

    });

    Route::controller(ComprasController::class)->group(function () {
        Route::get('/insert_nota', 'insertNota')->name('insertNota');
        Route::post('/salvar_nota', 'salvarNota')->name('salvarNota');
        Route::get('/list_notas', 'listNotas')->name('listNotas');
        Route::get('/add_itens_nota/{id}', 'addItensNota')->name('addItensNota');
        Route::post('/salvar_itens_nota', 'salvarItensNota')->name('salvarItensNota');
        Route::get('/destroy_itens_nota/{codCompraItem}', 'destroyItensNota')->name('destroyItensNota');
        Route::get('/destroy_nota/{notaFiscal_id}', 'destroyNota')->name('destroyNota');
        //ESTOQUE
        Route::get('/estoque', 'estoque')->name('estoque');
        Route::get('/estoque_list_laboratorios/{id}', 'estoque_list_laboratorios')->name('estoque_list_laboratorios');//json
        Route::post('/estoque_envia_laboratorio', 'estoque_envia_laboratorio')->name('estoque_envia_laboratorio');

        //novo envio de estoque
        Route::post('/estoque_envia_laboratorio_pendente', 'estoque_envia_laboratorio_pendente')->name('estoque_envia_laboratorio_pendente');



    });



    Route::controller(UnidadeController::class)->group(function () {
        Route::get('/detalhes_unidade/{id}', 'detalhesUnidade')->name('detalhesUnidade');

    });

});



//==============================================



//php artisan make:model Unidade -m
//php artisan make:controller UnidadeController

//php artisan migrate

//php artisan make:seeder UnidadeTableSeeder
//php artisan make:seeder CatalogoTableSeeder
//php artisan db:seed

//php artisan make:model Laboratorio -m
//php artisan migrate
//php artisan make:controller LaboratorioController -r

//php artisan make:model Componente -m
//php artisan migrate
//php artisan make:controller ComponenteController -r


//php artisan make:model Catalogo -m
//php artisan migrate
//php artisan make:controller CatalogoController -r

//php artisan storage:link




//================================================



//php artisan make:controller ComprasController -r

//php artisan make:model ComprasNotas -m
//php artisan migrate

//php artisan make:model ComprasNotasItens -m
//php artisan migrate



//php artisan make:model Estoque -m
//php artisan migrate



//php artisan make:model LaboratorioBemMoveis -m
//php artisan migrate

//php artisan make:model LaboratorioInsumosEquipamentos -m
//php artisan migrate


//php artisan make:model IdEnvioEstoque -m
//php artisan make:model EnvioEstoque -m


//========================================


//subtrair do estoque apos envio dos itens
//criar aba de pendentes









//teste
//criar dash com numero de laboratorios pendentents
//dash de acordo com dash adryan

//inserir tipo de perfil no campo atualizacao

//Valor total de Insumo(s):


//pendete ate confirmaçã de ass
//criar log

//criar funcao de perfil

//encotrar melhor lugar para gerar total de gasto do laboratorio - ta em laboratorioController - detalheslab

//tirar INSERIR laboratorio na visao do gestor













