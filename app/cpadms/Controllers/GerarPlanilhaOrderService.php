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
class GerarPlanilhaOrderService {

    private $Dados;
    private $PageId;

    public function gerar($PageId = null) {
        
        $botao = ['gerar' => ['menu_controller' => 'gerar-planilha-orde-service', 'menu_metodo' => 'gerar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarBairro = new \App\cpadms\Models\CpAdmsGerarPlanilhaOrderService();
        $this->Dados['listPlanilha'] = $listarBairro->listar($this->PageId, $this->Dados);

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/ordemServico/gerarPlanilha", $this->Dados);
        $carregarView->renderizarListar();
    }

}
