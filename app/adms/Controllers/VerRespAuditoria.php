<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerRespAuditoria {

    private $Dados;
    private $DadosId;

    public function verRespAuditoria($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verRespAuditoria = new \App\adms\Models\AdmsVerRespAuditoria();
            $this->Dados['dados_resp_auditoria'] = $verRespAuditoria->verRespAuditoria($this->DadosId);

            $botao = ['list_resp_auditoria' => ['menu_controller' => 'responsavel-auditoria', 'menu_metodo' => 'listar'],
                'edit_resp_auditoria' => ['menu_controller' => 'editar-resp-auditoria', 'menu_metodo' => 'edit-resp-auditoria'],
                'del_resp_auditoria' => ['menu_controller' => 'apagar-resp-auditoria', 'menu_metodo' => 'apagar-resp-auditoria']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/responsavelAuditoria/verRespAuditoria", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'responsavel-auditoria/listar';
            header("Location: $UrlDestino");
        }
    }

}
