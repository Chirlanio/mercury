<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of MotivoEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class MotivoEstorno {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_motivo' => ['menu_controller' => 'cadastrar-motivo', 'menu_metodo' => 'cad-motivo'],
            'vis_motivo' => ['menu_controller' => 'ver-motivo', 'menu_metodo' => 'ver-motivo'],
            'edit_motivo' => ['menu_controller' => 'editar-motivo', 'menu_metodo' => 'edit-motivo'],
            'del_motivo' => ['menu_controller' => 'apagar-motivo', 'menu_metodo' => 'apagar-motivo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarMotivo = new \App\adms\Models\AdmsListarMotivo();
        $this->Dados['listMotivo'] = $listarMotivo->listarMotivo($this->PageId);
        $this->Dados['paginacao'] = $listarMotivo->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/motivo/listarMotivo", $this->Dados);
        $carregarView->renderizar();
    }

}
