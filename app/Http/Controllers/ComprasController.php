<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Unidade;
use App\Models\Catalogo;
use App\Models\Laboratorio;
use Illuminate\Support\Str;
use App\Models\ComprasNotas;
use App\Models\EnvioEstoque;
use Illuminate\Http\Request;
use App\Models\ComprasNotasItens;
use App\Models\IdEnvioEstoque;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use App\Models\LaboratorioInsumosEquipamentos;
use App\Models\User;

class ComprasController extends Controller
{
    protected $unidades;

    public function __construct()
    {
        $this->unidades = Unidade::all()->except('1');
    }
    //====================================================
    // NOTA FISCAL
    //====================================================
    public function insertNota(){

        $unidades = $this->unidades;
        return view('compras.inserirNota',compact('unidades'));
    }

    public function salvarNota(Request $request){
        // dd($request->nota_fiscal_path->getClientOriginalName());
        $novo_notaDeCompra = new ComprasNotas();
        $novo_notaDeCompra->nota_fiscal_numero = $request->nota_fiscal_numero;
        $novo_notaDeCompra->empresa = $request->empresa;
        $novo_notaDeCompra->data_compra = $request->data_compra;
        $novo_notaDeCompra->valor_total_nota = $request->valor_total_nota;

        $novo_notaDeCompra->nota_fiscal_path = $request->file('nota_fiscal_path')->storeAs(
            'notas/'.Str::slug($request->nota_fiscal_numero), $request->nota_fiscal_path->getClientOriginalName()
        );

        $novo_notaDeCompra->save();

        return redirect()->route('listNotas')->with('success', true);
    }

    public function listNotas(){
        $unidades = $this->unidades;

        $notasFiscais = ComprasNotas::all();

        return view('compras.listNotasFiscais',compact(['unidades','notasFiscais']));
    }

    public function addItensNota($id){
        $unidades = $this->unidades;

        $notaFiscal = ComprasNotas::find($id);
        $itensCatalogo =  Catalogo::where('natureza','!=','Bens Móveis')->orderBy('natureza','desc')
        ->orderBy('nome','asc')
        ->get();

        return view('compras.inserirItemNota',compact(['unidades','notaFiscal','itensCatalogo']));
    }

    public function salvarItensNota(Request $request){

        //essa funcao vai salvar os itens na nota e depois vi salvar os itens no estoque.

        foreach($request->itemCatalogo_id as $chave => $valor){
            $novoItem = new ComprasNotasItens();
            $novoEstoque = new Estoque();

            //chaves
            $novoItem->comprasnota_id = $request->comprasnota_id;
            $novoItem->itemCatalogo_id = $request->itemCatalogo_id[$chave];

            //ESTOQUE
            $novoEstoque->comprasnota_id = $request->comprasnota_id;
            $novoEstoque->itemCatalogo_id = $request->itemCatalogo_id[$chave];


            //pegando ultimo id para criar codigo do produto
            $ultimoIdSalvo = ComprasNotasItens::orderBy('id','desc')->select('id')->first();
            if ( $ultimoIdSalvo == null) {
                $novoItem->codCompraItem = $request->nota_fiscal_numero.'-'.'0';

                //ESTOQUE
                $novoEstoque->codCompraItem = $request->nota_fiscal_numero.'-'.'0';
            }else{
                $novoItem->codCompraItem = $request->nota_fiscal_numero.'-'.$ultimoIdSalvo->id;

                 //ESTOQUE
                $novoEstoque->codCompraItem = $request->nota_fiscal_numero.'-'.$ultimoIdSalvo->id;
            }


            $novoItem->quantidadeItem = $request->quantidadeItem[$chave];
            $novoItem->valorUndItem = $request->valorUndItem[$chave];
            $novoItem->valorTotalItem = $request->valorTotalItem[$chave];

            //ESTOQUE
            $novoEstoque->quantidadeItem = $request->quantidadeItem[$chave];
            $novoEstoque->valorUndItem = $request->valorUndItem[$chave];
            $novoEstoque->valorTotalItem = $request->valorTotalItem[$chave];


           $novoItem->save();
           $novoEstoque->save();

        }

        return redirect()->route('addItensNota',['id'=>$request->comprasnota_id])->with('success', true);
    }

    public function destroyItensNota($codCompraItem){

        $itemNota = ComprasNotasItens::where('codCompraItem','=',$codCompraItem)->first();
        $itemNota->delete();

        //destruindo do estoque

        $itemNotaEstoque = Estoque::where('codCompraItem','=',$codCompraItem)->first();
        $itemNotaEstoque->delete();

        return back()->withInput()->with('delete-success', true);

    }

    public function destroyNota($notaFiscal_id){
        $notaFiscal = ComprasNotas::find($notaFiscal_id);
        File::deleteDirectory(public_path('storage/notas/'.$notaFiscal->nota_fiscal_numero));
        $notaFiscal->delete();
        return redirect()->route('listNotas')->with('delete-success', true);
    }


    //===================================================
    //ESTOQUE
    //===================================================

    public function estoque(){

        $unidades = $this->unidades;

        //usuarios administradores para poder lista-los no campos responsavel pelo envio
        $usuariosAdm = User::where('perfil','=','Administrador')->get();

        $estoques = Estoque::orderBy('codCompraItem','asc')->get();

        $estoqueInsumo = DB::table('estoques')
            ->join('catalogos', 'estoques.itemCatalogo_id', '=', 'catalogos.id')
            ->select('estoques.*', 'catalogos.nome',)
            ->where('estoques.statusItem','=', null)
            ->where('catalogos.natureza','=','Insumo')
            ->get();

        $estoqueEquipamento = DB::table('estoques')
            ->join('catalogos', 'estoques.itemCatalogo_id', '=', 'catalogos.id')
            ->select('estoques.*', 'catalogos.nome')
            ->where('estoques.statusItem','=', null)
            ->where('catalogos.natureza','=','Equipamento')
            ->get();

        $estoqueGeral = DB::table('estoques')
            ->join('catalogos', 'estoques.itemCatalogo_id', '=', 'catalogos.id')
            ->select('estoques.*', 'catalogos.nome','catalogos.natureza')
            ->orderBy('catalogos.natureza')
            ->get();



        // return view('compras.estoque',compact(['unidades','estoqueInsumo','estoqueEquipamento']));
        return view('compras.estoque',compact(['unidades','estoqueGeral','usuariosAdm']));

    }

    public function estoque_list_laboratorios($id){

        //recebe id unidade
        $laboratorios = Laboratorio::where('unidade_id','=',$id)->get();
        return response()->json($laboratorios);
    }

    public function estoque_envia_laboratorio(Request $request){

        //dd($request->all());

        //capturando produto no etoque
        $produtoEstoque = Estoque::where('id', '=', $request->estoque_Id)->first();

        //dd($produtoEstoque->quantidadeItem, $request->estoque_quantidadeItem);

        //verificando se existe o item no laboratorio
        $itemLaboratorio = LaboratorioInsumosEquipamentos::where('laboratorio_id','=',$request->estoque_laboratorio_id)
                                                            ->where('itemCatalogo_id','=',$request->estoque_itemCatalogo_id)->first();


        //se existe item com mesmo itemCatalogo_id no laboratorio, entao soma o quantidade recebida com quantidade existente no LaboratorioInsumosEquipamentos
        if($itemLaboratorio != null){

                $itemLaboratorio->quantidadeItem = $itemLaboratorio->quantidadeItem + $request->estoque_quantidadeSolicitada;
                $itemLaboratorio->save();

                //em estoque subtrai o item
                //sendo o valor total, ou seja, a quantidade maxima de itens no estoque, remove o registro
                if($produtoEstoque->quantidadeItem == $request->estoque_quantidadeSolicitada){
                    $produtoEstoque->delete();
                }else{
                //nao sendo o valor total, diminui a quantidade do estoque
                    $produtoEstoque->quantidadeItem = $produtoEstoque->quantidadeItem - $request->estoque_quantidadeSolicitada;
                    $produtoEstoque->save();
                }

                return redirect()->route('estoque')->with('envio-success', true);

        //senao existir, cria um registro com mesmo unidade id  laboratorio_id e item catalogo id e quantidade
        }else{

            $novoItem = new LaboratorioInsumosEquipamentos();
            $novoItem->itemCatalogo_id = $request->estoque_itemCatalogo_id;
            $novoItem->unidade_id = $request->estoque_unidade_id;
            $novoItem->laboratorio_id = $request->estoque_laboratorio_id;
            $novoItem->quantidadeItem = $request->estoque_quantidadeSolicitada;
            $novoItem->save();

            //em estoque subtrai o item
            //sendo o valor total, ou seja, a quantidade maxima de itens no estoque, remove o registro
            if($produtoEstoque->quantidadeItem == $request->estoque_quantidadeSolicitada){
                    $produtoEstoque->delete();
            }else{
                //nao sendo o valor total, diminui a quantidade do estoque
                    $produtoEstoque->quantidadeItem = $produtoEstoque->quantidadeItem - $request->estoque_quantidadeSolicitada;
                    $produtoEstoque->save();
            }



            return redirect()->route('estoque')->with('envio-success', true);
        }

    }


    public function estoque_envia_laboratorio_pendente(Request $request){

        //return response()->json($request->all());


        //salvando referencia do envio
        $novoEnvio = new IdEnvioEstoque();
        $novoEnvio->unidade_id = $request->unidade_id;
        $novoEnvio->laboratorio_id = $request->laboratorio_id;
        $novoEnvio->numDocumento = $request->numDocumento;
        $novoEnvio->responsavelEnvio = $request->responsavelEnvio;
        $novoEnvio->dataEnvio = $request->dataEnvio;
        $novoEnvio->statusItem = 'pendente';
        $novoEnvio->save();

         //capturando ultimo id
         $ultimoIdEnvio = IdEnvioEstoque::orderBy('id','desc')->select('id')->first();


        //salvando itens
        $itens = $request->itens;
        foreach($itens as $item ){
            $enviarEstoque = new EnvioEstoque();

            $enviarEstoque->id_envio = $ultimoIdEnvio->id;
            $enviarEstoque->itemCatalogo_id = $item['itemCatalogo_id'];
            $enviarEstoque->itemNome = $item['itemNome'];
            $enviarEstoque->quantidadeItem = $item['quantidadeItem'];
            $enviarEstoque->save();

            //diminundo qnt do estoque
            //capturando produto no etoque
            $produtoEstoque = Estoque::where('id', '=', $item['estoqueId'])
                ->first();

            if($produtoEstoque->quantidadeItem == $item['quantidadeItem']){
                    $produtoEstoque->delete();
            }else{
                //nao sendo o valor total, diminui a quantidade do estoque
                    $produtoEstoque->quantidadeItem = $produtoEstoque->quantidadeItem - $item['quantidadeItem'];
                    $produtoEstoque->save();
            }

        }



         return response()->json('envio com sucesso');






    }






    //COMO ERA FEITO ANTES
    // public function estoque_envia_laboratorio(Request $request){

    //     //dd($request->all());

    //     //capturando produto no etoque
    //     $produtoEstoque = Estoque::where('id', '=', $request->estoque_Id)
    //     ->where('statusItem','=',null)
    //     ->first();

    //      //verificando se o quantitativo é igual ao do estoque, se sim, so altera o status para EM_USO e adiciona a UNIDADE E O LABORATORIO
    //      if($produtoEstoque->quantidadeItem == $request->estoque_quantidadeSolicitada){

    //         $produtoEstoque->unidade_id = $request->estoque_unidade_id;
    //         $produtoEstoque->laboratorio_id = $request->estoque_laboratorio_id;
    //         $produtoEstoque->dataEnvioItem = $request->estoque_dataEnvioItem;
    //         $produtoEstoque->statusItem = 'EM_USO';
    //         $produtoEstoque->save();

    //         //==========================================
    //         //atualizando o valor total do laboratorio
    //         //==========================================
    //         $laboratorio = new Laboratorio();
    //         $laboratorio->atualizaValorTotalLab($request->estoque_laboratorio_id);


    //         return redirect()->route('estoque')->with('envio-success', true);
    //      }

    //      //se o quantitativo for menor, cria outro registro no estoque com status EM_USO, com o laboratorio e a unidade informada e o quantitativo solicitado e atualiza o rgistro do estque com a quantidade que sobrou        if($request->quantidadeItem < $produtoEstoque->quantidadeItem){
    //     if($produtoEstoque->quantidadeItem > $request->estoque_quantidadeSolicitada){


    //         //salvando novo registro
    //         $novo_produtoEstoque = new Estoque;
    //         $novo_produtoEstoque->comprasnota_id = $request->estoque_comprasnota_id;
    //         $novo_produtoEstoque->unidade_id = $request->estoque_unidade_id;
    //         $novo_produtoEstoque->laboratorio_id = $request->estoque_laboratorio_id;
    //         $novo_produtoEstoque->itemCatalogo_id = $request->estoque_itemCatalogo_id;
    //         $novo_produtoEstoque->codCompraItem = $request->estoque_codCompraItem;
    //         $novo_produtoEstoque->quantidadeItem = $request->estoque_quantidadeSolicitada;
    //         $novo_produtoEstoque->valorUndItem = $request->estoque_valorUndItem;
    //         $novo_produtoEstoque->valorTotalItem = $request->estoque_valorUndItem * $request->estoque_quantidadeSolicitada;
    //         $novo_produtoEstoque->dataEnvioItem = $request->estoque_dataEnvioItem;
    //         $novo_produtoEstoque->statusItem = 'EM_USO';
    //         $novo_produtoEstoque->save();

    //         //atualizando item do estoque com valor subtraido e permanecendo o status como null prq ainda esta disponivel no estoque

    //         $produtoEstoque->quantidadeItem = $produtoEstoque->quantidadeItem - $request->estoque_quantidadeSolicitada;
    //         $produtoEstoque->valorTotalItem =  $produtoEstoque->quantidadeItem * $request->estoque_valorUndItem;
    //         $produtoEstoque->save();


    //         //==========================================
    //         //atualizando o valor total do laboratorio
    //         //==========================================
    //         $laboratorio = new Laboratorio();
    //         $laboratorio->atualizaValorTotalLab($request->estoque_laboratorio_id);


    //         return redirect()->route('estoque')->with('envio-success', true);

    //     }


    // }






}


