<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarResp {

    private $Dados;

    public function cadResp() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadResp'])) {
            unset($this->Dados['CadResp']);
            $cadResp = new \App\adms\Models\AdmsCadastrarResp();
            $cadResp->cadResp($this->Dados);
            if ($cadResp->getResultado()) {
                $UrlDestino = URLADM . 'autorizacao-resp/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadRespViewPriv();
            }
        } else {
            $this->cadRespViewPriv();
        }
    }

    private function cadRespViewPriv() {
        $botao = ['list_resp' => ['menu_controller' => 'autorizacao-resp', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/financeiro/cadResp", $this->Dados);
        $carregarView->renderizar();
    }

}
