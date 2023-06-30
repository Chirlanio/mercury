<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarTransferencia
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarTransf {

    private $Dados;

    public function cadTransf() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadTransf'])) {
            unset($this->Dados['CadTransf']);
            $cadTransf = new \App\adms\Models\AdmsCadastrarTransf();
            $cadTransf->cadTransf($this->Dados);
            if ($cadTransf->getResultado()) {
                $UrlDestino = URLADM . 'transferencia/listarTransf';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTransfViewPriv();
            }
        } else {
            $this->cadTransfViewPriv();
        }
    }

    private function cadTransfViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarTransf();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_transf' => ['menu_controller' => 'transferencia', 'menu_metodo' => 'listar-transf']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/transferencia/cadTransf", $this->Dados);
        $carregarView->renderizar();
    }

}
