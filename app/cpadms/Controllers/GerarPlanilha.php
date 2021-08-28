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

        $botao = ['gerar' => ['menu_controller' => 'gerar-planilha', 'menu_metodo' => 'gerar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarBairro = new \App\cpadms\Models\CpAdmsGerarPlanilha();
        $this->Dados['listPlanilha'] = $listarBairro->listar($this->PageId);

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/planilha/gerarPlanilha", $this->Dados);
        $carregarView->renderizarListar();
    }

}
