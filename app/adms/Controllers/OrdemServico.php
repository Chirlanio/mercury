<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of OrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class OrdemServico {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_ordem_servico' => ['menu_controller' => 'cadastrar-ordem-servico', 'menu_metodo' => 'cad-ordem-servico'],
            'gerar' => ['menu_controller' => 'gerar-planilha-order-service', 'menu_metodo' => 'gerar'],
            'vis_ordem_servico' => ['menu_controller' => 'ver-ordem-servico', 'menu_metodo' => 'ver-ordem-servico'],
            'edit_ordem_servico' => ['menu_controller' => 'editar-ordem-servico', 'menu_metodo' => 'edit-ordem-servico'],
            'del_ordem_servico' => ['menu_controller' => 'apagar-ordem-servico', 'menu_metodo' => 'apagar-ordem-servico']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsListarOrdemServico();
        $this->Dados['select'] = $listarSelect->listCad();

        $listarOrdemSevico = new \App\adms\Models\AdmsListarOrdemServico();
        $this->Dados['list_ordem_servico'] = $listarOrdemSevico->listar($this->PageId);
        $this->Dados['paginacao'] = $listarOrdemSevico->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/ordemServico/listarOrdemServico", $this->Dados);
        $carregarView->renderizar();
    }

}
