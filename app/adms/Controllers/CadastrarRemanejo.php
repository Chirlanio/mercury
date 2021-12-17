<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarRemanejo {

    private $Dados;

    public function cadRemanejo() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadRemanejo'])) {
            unset($this->Dados['CadRemanejo']);
            $this->Dados['arquivo'] = ($_FILES['arquivo'] ? $_FILES['arquivo'] : null);
            $cadRemanejo = new \App\adms\Models\AdmsCadastrarRemanejo();
            $cadRemanejo->cadRemanejo($this->Dados);
            if ($cadRemanejo->getResultado()) {
                $UrlDestino = URLADM . 'remanejo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadRemanejoViewPriv();
            }
        } else {
            $this->cadRemanejoViewPriv();
        }
    }

    private function cadRemanejoViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarRemanejo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_remanejo' => ['menu_controller' => 'remanejo', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/remanejo/cadRemanejo", $this->Dados);
        $carregarView->renderizar();
    }

}
