<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Unidade;
use App\Models\Catalogo;
use App\Models\Componente;
use App\Models\EnvioEstoque;
use App\Models\IdEnvioEstoque;
use App\Models\Laboratorio;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LaboratorioBemMoveis;
use Illuminate\Support\Facades\Auth;
use App\Models\LaboratorioInsumosEquipamentos;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class LaboratorioController extends Controller
{

    protected $unidades;

    public function __construct()
    {
        $this->unidades = Unidade::all()->except('1');
    }

    public function insertlab($base)
    {
        $unidades = $this->unidades;

        $base == 'BNCC' ? $base = 'BASE NACIONAL COMUM' : $base = 'BASE TÉCNICA';


        $componentes = Componente::where('base','=', $base)->get();


         //revertendo somente para aprsentação
         $base == 'BASE NACIONAL COMUM' ?  $base ='BNCC' :  $base = 'BT';

        return view('laboratorio.inserirLab',compact(['unidades','componentes','base']));
    }

    public function salvarlab(Request $request){

        //Laboratorio::create($request->all());
        $laboratorio = new Laboratorio;
        $componente = Componente::where('id', '=', $request->componente_id)->first();

        $laboratorio->unidade_id = $request->unidade_id;
        $laboratorio->base = $request->base;
        $laboratorio->componente_id = $request->componente_id;
        $laboratorio->status = $request->status;
        $laboratorio->valorLab = $request->valorLab;
        $laboratorio->valorLab_total = $request->valorLab;
        $laboratorio->data_prevista_entrega = $request->data_prevista_entrega;
        $laboratorio->fornecedor = $request->fornecedor;

        if($request->aquisicao != "outra"){
            $laboratorio->aquisicao = $request->aquisicao;
        }else{
            $laboratorio->aquisicao = $request->aquisicao_outra;
        }

        $laboratorio->investimento = $request->investimento;

        $laboratorio->save();


        //criando e salvando prefixoLab - prefixo da unidade | base | 3 caracacteres do componente | id do ultimo registro salvo
        //=====================
        $unidade = Unidade::find($request->unidade_id);
        $PrefixoLab = $unidade->prefixo;
        $ultimoIdSalvo = Laboratorio::orderBy('id','desc')->select('id')->first();

            $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö','Ù', 'Ü', 'Ú');
            $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O','U', 'U', 'U');

        if($request->base == 'BASE NACIONAL COMUM'){

              $PrefixoLab = $PrefixoLab.'_'.'BNCC'.'_'.str_replace($comAcentos, $semAcentos,$componente->prefixo).'_'.$ultimoIdSalvo->id;
        }
        if($request->base == 'BASE TÉCNICA'){

            $PrefixoLab = $PrefixoLab.'_'.'BT'.'_'.str_replace($comAcentos, $semAcentos,$componente->prefixo).'_'.$ultimoIdSalvo->id;
      }

        $laboratorio->prefixo = strtolower($PrefixoLab);
        $laboratorio->save();
        //======================


         //revertendo somente para aprsentação
         $request->base == 'BASE NACIONAL COMUM' ?   $request->base ='BNCC' : $request->base = 'BT';

        return redirect()->route('list_lab',['baseLab'=> $request->base])->with('success', true);

        // return redirect('dashboard')->with('status', 'Profile updated!');

    }

    public function list_lab($base){
        $unidades = $this->unidades;

        $base == 'BNCC' ? $base = 'BASE NACIONAL COMUM' : $base = 'BASE TÉCNICA';



        if(auth()->user()->perfil == 'Gestor'){


            $laboratorios = Laboratorio::where('unidade_id','=',auth()->user()->unidade_id)
            ->where('base','=',$base)
            ->orderBy('componente_id', 'asc')
            ->orderBy('status', 'asc')
            ->get();


        }else{
            $laboratorios = Laboratorio::where('base','=',$base)
            ->orderBy('unidade_id','asc')
            ->orderBy('componente_id', 'asc')
            ->orderBy('status', 'asc')
            ->get();

        }




        //revertendo somente para aprsentação
        $base == 'BASE NACIONAL COMUM' ?  $base ='BNCC' :  $base = 'BT';

        return view('laboratorio.listLab',compact(['unidades','laboratorios','base']));
    }

    public function detalheslab($id){
        $unidades = $this->unidades;
        $laboratorio = Laboratorio::find($id);

        //======================================================
        //UTILIZADO COM A TABELA ESTOQUE - ainda tem que fazer a logica do envio da tabela estoque para tabela laboratorio_insumo_equipamento
        //======================================================
        // $laboratorioInsumos = DB::table('estoques')
        // ->join('catalogos', 'estoques.itemCatalogo_id', '=', 'catalogos.id')
        // ->select('estoques.*', 'catalogos.nome')
        // ->where('laboratorio_id','=', $laboratorio->id)
        // ->where('catalogos.natureza','=','Insumo')
        // ->get();

        // $laboratorioEquipamentos = DB::table('estoques')
        // ->join('catalogos', 'estoques.itemCatalogo_id', '=', 'catalogos.id')
        // ->select('estoques.*', 'catalogos.nome')
        // ->where('laboratorio_id','=', $laboratorio->id)
        // ->where('catalogos.natureza','=','Equipamento')
        // ->get();

        $laboratorioInsumos = DB::table('laboratorio_insumos_equipamentos')
        ->join('catalogos', 'laboratorio_insumos_equipamentos.itemCatalogo_id', '=', 'catalogos.id')
        ->select('laboratorio_insumos_equipamentos.*', 'catalogos.nome')
        ->where('laboratorio_id','=', $laboratorio->id)
        ->where('catalogos.natureza','=','Insumo')
        ->get();

        $laboratorioEquipamentos = DB::table('laboratorio_insumos_equipamentos')
        ->join('catalogos', 'laboratorio_insumos_equipamentos.itemCatalogo_id', '=', 'catalogos.id')
        ->select('laboratorio_insumos_equipamentos.*', 'catalogos.nome')
        ->where('laboratorio_id','=', $laboratorio->id)
        ->where('catalogos.natureza','=','Equipamento')
        ->get();



        //exportando catalogo para criacao dos insumos e equipamentos pelo professor
        $CatalogoInsumos = Catalogo::where('natureza','=','Insumo')->get();

         //exportando catalogo para criacao dos insumos e equipamentos pelo professor
        $CatalogoEquipamentos = Catalogo::where('natureza','=','Equipamento')->get();



        //exportando catalogo para criacao dos ben moveis
        $CatalogoBensMoveis = Catalogo::where('natureza','=','Bens Móveis')->get();

        //exportando os bens moveis existentes do laboratorio
        $bensMoveisLab = LaboratorioBemMoveis::where('laboratorio_id','=',$id)->get();


        //enviar lista de documentos Enviados pelo Estoque
        $documentosEnviados = IdEnvioEstoque::where('laboratorio_id','=',$id)->get();


         //criando variavel base somente para apresentacao de link - definindo base
         $base = '';
         $laboratorio->base == 'BASE NACIONAL COMUM' ?  $base ='BNCC' :  $base = 'BT';

        return view('laboratorio.detalhesLab',compact(['unidades','laboratorio','base','laboratorioInsumos', 'laboratorioEquipamentos','CatalogoInsumos','CatalogoEquipamentos','CatalogoBensMoveis','bensMoveisLab','documentosEnviados']));

    }

    public function editlab($id){
        $unidades = $this->unidades;
        $editLaboratorio = Laboratorio::find($id);
        $baselab = $editLaboratorio->base;
        $componentes = Componente::where('base','=', $baselab)->get();


        $base = $editLaboratorio->base;
         //revertendo somente para apresentação
        $base == 'BASE NACIONAL COMUM' ?  $base ='BNCC' :  $base = 'BT';

        return view('laboratorio.editLab',compact(['unidades','editLaboratorio','base','componentes']));
    }

    public function updatelab(Request $request, $id){
        $uploadLab = Laboratorio::find($id);

        $uploadLab->status = $request->status;
        $uploadLab->fornecedor = $request->fornecedor;

        if($request->aquisicao != "outra"){
            $uploadLab->aquisicao = $request->aquisicao;
        }else{
            $uploadLab->aquisicao = $request->aquisicao_outra;
        }

        $uploadLab->investimento = $request->investimento;
        $uploadLab->valorLab = $request->valorLab;
        $uploadLab->data_prevista_entrega = $request->data_prevista_entrega;
        $uploadLab->save();

        $uploadLab->atualizaValorTotalLab($id);
        $uploadLab->save();

        $base = '';
        $uploadLab->base == 'BASE NACIONAL COMUM' ?  $base ='BNCC' :  $base = 'BT';

        return redirect()->route('detalheslab',['id'=> $uploadLab->id, 'base'=>$base])->with('atualizacao-success', true);

    }

    public function salvardataEntrega(Request $request){
        $laboratorio = Laboratorio::find($request->id);
        $laboratorio->data_entrega = $request->data_entrega;
        $laboratorio->save();
        return back()->withInput()->with('data-success', true);
    }

    public function salvarObsesrvacao(Request $request){

        $laboratorio = Laboratorio::find($request->id);
        $dataAtual = date('d/m/Y H:i');
        $laboratorio->observacao = $laboratorio->observacao.'<br>'.'<strong>'.$dataAtual.'('.auth()->user()->primeiroNome().'-'.auth()->user()->perfil.')'.'</strong>'.' - '.$request->observacao;
        $laboratorio->save();
        return back()->withInput()->with('obs-success', true);


    }

    public function destroyLab($id)
    {

        $deletarLaboratorio = Laboratorio::find($id);

         //revertendo somente para aprsentação
         $deletarLaboratorio->base == 'BASE NACIONAL COMUM' ?  $deletarLaboratorio->base ='BNCC' :  $deletarLaboratorio->base = 'BT';
         $base = $deletarLaboratorio->base;



        //===================================================================
         //DEVOLVENDO ITENS PARA ESTOQUE APOS EXCLUSAO
        //===================================================================

        //pesquisar dentro de estoque os registros que tem o id do laboratorio
        $estoque = Estoque::where('laboratorio_id','=',$id)->get();

        //se encontrar algum registro, significa q tem itens no etoque, tendo que ser atualizados
        if($estoque != null) {


            foreach($estoque as $itemDevolvidoEstoque){
                //faz uma pesquisa para econtrar o mesmo codCompraItem com status null,
                $estoqueEncontrado = Estoque::where('codCompraItem','=',$itemDevolvidoEstoque->codCompraItem)
                                        ->where('statusItem','=',null)
                                        ->first();

                // encontrando o registro no estoque, soma a qunatidade e o valor total e por fim deleta esse registro vindo do laboratorio
                if($estoqueEncontrado != null){
                        $estoqueEncontrado->quantidadeItem = $estoqueEncontrado->quantidadeItem + $itemDevolvidoEstoque->quantidadeItem;
                        $estoqueEncontrado->valorTotalItem = $estoqueEncontrado->quantidadeItem * str_replace(',', '.',str_replace('.', '', $estoqueEncontrado->valorUndItem));

                        $estoqueEncontrado->save();

                    $itemDevolvidoEstoque->delete();

                //senao, nao foi encontrado codCompraItem com status null(ou seja nao tem item disponivel no estoque para atualizar | esse registro passa a ficar disponivel no estoque)
                //entao esse registro passa a ter como null unidade_id laboratorio_id statusItem dataEnvioItem
                }else{
                    $itemDevolvidoEstoque->unidade_id = null;
                    $itemDevolvidoEstoque->laboratorio_id = null;
                    $itemDevolvidoEstoque->statusItem = null;
                    $itemDevolvidoEstoque->dataEnvioItem = null;
                    $itemDevolvidoEstoque->save();
                }

            }

        }

        //===================================================================

        $deletarLaboratorio->delete();

        return redirect()->route('list_lab',['baseLab'=> $base])->with('delete-success', true);
    }

    public function devolverEstoque(Request $request)
    {

        //pesquisar dentro de estoque
        //faz uma busca pelo codCompraItem e se ele tem statusItem igual a null
        $estoque = Estoque::where('codCompraItem','=',$request->devolve_estoque_codCompraItem)
                           ->where('statusItem','=',null)
                           ->first();


        //se encontrar algum registro, significa q tem itens disponiveis no etoque, podendo ser atualizados
        // - soma o quantitativo e multiplica o valor total
        if($estoque != null) {
            $estoque->quantidadeItem = $estoque->quantidadeItem + $request->devolve_estoque_quantidade;
            $estoque->valorTotalItem = $estoque->quantidadeItem * str_replace(',', '.',str_replace('.', '', $estoque->valorUndItem));
            $estoque->save();

                //do registro existente no laboratorio, se for o mesmo quantitativo, deleta o registro
                if($request->devolve_estoque_quantidade == $request->limite_disponivel){

                    $registroDeletado = Estoque::find($request->devolve_estoqueItemId);
                    $registroDeletado->delete();

                        //==========================================
                        //atualizando o valor total do laboratorio
                        //==========================================
                        $laboratorio = new Laboratorio();
                        $laboratorio->atualizaValorTotalLab($request->lab_id);


                    return back()->withInput()->with('devolucao-success', true);

                //senao, atualiza quantitativo e o valor total
                }else{
                    $registroAtualizado = Estoque::find($request->devolve_estoqueItemId);
                    $registroAtualizado->quantidadeItem = $registroAtualizado->quantidadeItem - $request->devolve_estoque_quantidade;
                    $registroAtualizado->valorTotalItem = $registroAtualizado->quantidadeItem * (double)$request->devolve_estoque_valorUndItem;
                    $registroAtualizado->save();

                        //==========================================
                        //atualizando o valor total do laboratorio
                        //==========================================
                        $laboratorio = new Laboratorio();
                        $laboratorio->atualizaValorTotalLab($request->lab_id);


                    return back()->withInput()->with('devolucao-success', true);
                }
         //senao encontrar algum registro, significa q NAO tem itens disponiveis no etoque, tem q criar registro de estoque
        }else{
            $novoItemEstoque = new Estoque;
            $novoItemEstoque->comprasnota_id = $request->devolve_estoque_comprasnota_id;
            $novoItemEstoque->itemCatalogo_id = $request->devolve_estoque_itemCatalogo_id;
            $novoItemEstoque->codCompraItem = $request->devolve_estoque_codCompraItem;
            $novoItemEstoque->quantidadeItem = $request->devolve_estoque_quantidade;
            $novoItemEstoque->valorUndItem = (double)$request->devolve_estoque_valorUndItem;
            $novoItemEstoque->valorTotalItem = $request->devolve_estoque_quantidade * (double)$request->devolve_estoque_valorUndItem;
            $novoItemEstoque->save();


              //do registro existente no laboratorio, se for o mesmo quantitativo, deleta o registro
                if($request->devolve_estoque_quantidade == $request->limite_disponivel){

                    $registroDeletado = Estoque::find($request->devolve_estoqueItemId);
                    $registroDeletado->delete();

                        //==========================================
                        //atualizando o valor total do laboratorio
                        //==========================================
                        $laboratorio = new Laboratorio();
                        $laboratorio->atualizaValorTotalLab($request->lab_id);


                    return back()->withInput()->with('devolucao-success', true);

                //senao, atualiza quantitativo e o valor total
                }else{
                    $registroAtualizado = Estoque::find($request->devolve_estoqueItemId);
                    $registroAtualizado->quantidadeItem = $registroAtualizado->quantidadeItem - $request->devolve_estoque_quantidade;
                    $registroAtualizado->valorTotalItem = $registroAtualizado->quantidadeItem * (double)$request->devolve_estoque_valorUndItem;
                    $registroAtualizado->save();

                        //==========================================
                        //atualizando o valor total do laboratorio
                        //==========================================
                        $laboratorio = new Laboratorio();
                        $laboratorio->atualizaValorTotalLab($request->lab_id);


                    return back()->withInput()->with('devolucao-success', true);
                }



        }



    }

    //========================================================
    //INSERIR BENS MOVEIS NA TELA DE DETALHES DO LABORATORIO (ADMINISTRADOR)
    //========================================================

    public function salvarBensMoveis(Request $request){


        $bemMovelNovo = new LaboratorioBemMoveis();

        $bemMovelNovo->itemCatalogo_id = $request->itemCatalogo_id;
        $bemMovelNovo->unidade_id = $request->unidade_id;
        $bemMovelNovo->laboratorio_id = $request->laboratorio_id;
        $bemMovelNovo->quantidadeItem = $request->quantidadeItem;
        $bemMovelNovo->valorUndItem = $request->valorUndItem;
        $bemMovelNovo->valorTotalItem = $request->valorTotalItem;


        $bemMovelNovo->save();

        return back()->withInput()->with('bemmovel-success', true);

    }

    //========================================================
    //INSERIR INSUMOS E EQUIPAMENTOS NA TELA DE DETALHES DO LABORATORIO (PROFESSOR)
    //========================================================

    public function salvarInsumosEquipamentos(Request $request){

        $insumoEquipamento = new LaboratorioInsumosEquipamentos();

        //dd($request->all());

        $insumoEquipamento->itemCatalogo_id = $request->itemCatalogo_id;
        $insumoEquipamento->unidade_id = $request->unidade_id;
        $insumoEquipamento->laboratorio_id = $request->laboratorio_id;
        $insumoEquipamento->quantidadeItem = $request->quantidadeItem;


        $insumoEquipamento->save();

        return back()->withInput()->with('InsumosEquipamentos-success', true);

    }

    //========================================================
    //REQUISICAO FETCH PARA LISTAGEM DOS ITENS ENVIADOS PELO ESTOQUE
    //========================================================
    public function list_itens_enviados($id){

            $listItens = EnvioEstoque::where('id_envio','=',$id)->get();
            return response()->json($listItens);
    }

    public function confirmarRecebimento(Request $request){
        //dd($request->all());

        //deixar como entregue o status
        $envioEstoque = IdEnvioEstoque::find($request->id_envio);

        //dd($envioEstoque);
        $envioEstoque->statusItem = 'entregue';
        $envioEstoque->dataRecebimento = $request->data_recebimento;
        $envioEstoque->save();


        //somar os qnts com os itens da laboratorio
        $listItens = EnvioEstoque::where('id_envio','=',$request->id_envio)->get();

        $itensLab = LaboratorioInsumosEquipamentos::where('laboratorio_id','=',$request->id_lab)->get();


        foreach ($listItens as $itemEnviado) {

                $itemNaoExistente = true;

                foreach($itensLab as $itemLab){

                        //se encontrar algum registro, significa q tem itens disponiveis tendo que ser atualizados
                        if($itemEnviado->itemCatalogo_id == $itemLab->itemCatalogo_id){
                            $itemLab->quantidadeItem =  $itemLab->quantidadeItem + $itemEnviado->quantidadeItem;
                            $itemLab->save();
                            $itemNaoExistente = false;
                            break;
                        }

                }

                if( $itemNaoExistente == true){
                    $novoItem = new LaboratorioInsumosEquipamentos();
                    $novoItem->unidade_id = $request->id_unidade;
                    $novoItem->laboratorio_id = $request->id_lab;
                    $novoItem->itemCatalogo_id = $itemEnviado->itemCatalogo_id;
                    $novoItem->quantidadeItem = $itemEnviado->quantidadeItem;
                    $novoItem->save();
                }


        }

        return back()->withInput()->with('recebimento-success', true);

    }
}
