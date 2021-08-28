<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarFunc {

    private $Dados;

    public function cadFunc() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadFunc'])) {
            unset($this->Dados['CadFunc']);
            $cadFunc = new \App\adms\Models\AdmsCadastrarFunc();
            $cadFunc->cadFunc($this->Dados);
            if ($cadFunc->getResultado()) {
                $UrlDestino = URLADM . 'funcionarios/listar-func';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadFuncViewPriv();
            }
        } else {
            $this->cadFuncViewPriv();
        }
    }

    private function cadFuncViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarFunc();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_func' => ['menu_controller' => 'funcionarios', 'menu_metodo' => 'listar-func']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/funcionarios/cadFunc", $this->Dados);
        $carregarView->renderizar();
    }

}
