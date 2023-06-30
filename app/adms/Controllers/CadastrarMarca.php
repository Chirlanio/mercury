<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarMarca {

    private $Dados;

    public function cadMarca() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadMarca'])) {
            unset($this->Dados['CadMarca']);
            $cadMarca = new \App\adms\Models\AdmsCadastrarMarca();
            $cadMarca->cadMarca($this->Dados);
            if ($cadMarca->getResultado()) {
                $UrlDestino = URLADM . 'marcas/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadMarcaViewPriv();
            }
        } else {
            $this->cadMarcaViewPriv();
        }
    }

    private function cadMarcaViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarMarca();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_marca' => ['menu_controller' => 'marcas', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/marca/cadMarca", $this->Dados);
        $carregarView->renderizar();
    }

}
