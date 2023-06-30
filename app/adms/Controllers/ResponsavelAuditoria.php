<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ResponsavelAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ResponsavelAuditoria {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_resp_auditoria' => ['menu_controller' => 'cadastrar-resp-auditoria', 'menu_metodo' => 'cad-resp-auditoria'],
            'vis_resp_auditoria' => ['menu_controller' => 'ver-resp-auditoria', 'menu_metodo' => 'ver-resp-auditoria'],
            'edit_resp_auditoria' => ['menu_controller' => 'editar-resp-auditoria', 'menu_metodo' => 'edit-resp-auditoria'],
            'del_resp_auditoria' => ['menu_controller' => 'apagar-resp-auditoria', 'menu_metodo' => 'apagar-resp-auditoria']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarRespAuditoria = new \App\adms\Models\AdmsListarRespAuditoria();
        $this->Dados['listRespAuditoria'] = $listarRespAuditoria->listarRespAuditoria($this->PageId);
        $this->Dados['paginacao'] = $listarRespAuditoria->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/responsavelAuditoria/listarRespAuditoria", $this->Dados);
        $carregarView->renderizar();
    }

}
