<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of GerarPlanilha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class GerarPlanilha {

    private $Dados;
    private $PageId;

    public function gerar($PageId = null) {

        $this->Dados['loja_id'] = filter_input(INPUT_GET, 'loja' , FILTER_DEFAULT);
        $this->Dados['min_id'] = filter_input(INPUT_GET, 'min_id' , FILTER_DEFAULT);
        $this->Dados['max_id'] = filter_input(INPUT_GET, 'max_id' , FILTER_DEFAULT);
        $this->Dados['sit_id'] = filter_input(INPUT_GET, 'situacao' , FILTER_DEFAULT);
        $this->Dados['cliente'] = filter_input(INPUT_GET, 'cliente' , FILTER_DEFAULT);
        
        $botao = ['gerar' => ['menu_controller' => 'gerar-planilha', 'menu_metodo' => 'gerar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarBairro = new \App\cpadms\Models\CpAdmsGerarPlanilha();
        $this->Dados['listPlanilha'] = $listarBairro->listar($this->PageId, $this->Dados);

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/planilha/gerarPlanilha", $this->Dados);
        $carregarView->renderizarListar();
    }

}
