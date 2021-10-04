<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarEstorno
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class CadastrarEstorno {

    private $Dados;

    public function cadEstorno() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadEstorno'])) {
            unset($this->Dados['CadEstorno']);
            $this->Dados['arquivo'] = ($_FILES['arquivo'] ? $_FILES['arquivo'] : null);
            $cadEstorno = new \App\adms\Models\AdmsCadastrarEstorno();
            $cadEstorno->cadEstorno($this->Dados);
            //var_dump($this->Dados);
            if ($cadEstorno->getResultado()) {
                $UrlDestino = URLADM . 'estorno/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadEstornoViewPriv();
            }
        } else {
            $this->cadEstornoViewPriv();
        }
    }

    private function cadEstornoViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsCadastrarEstorno();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_estorno' => ['menu_controller' => 'estorno', 'menu_metodo' => 'listar'],
            'cad_estorno' => ['menu_controller' => 'cadastrar-estorno', 'menu_metodo' => 'cad-estorno'],
            'ver_estorno' => ['menu_controller' => 'ver-estorno', 'menu_metodo' => 'ver-estorno'],
            'editar_estorno' => ['menu_controller' => 'editar-estorno', 'menu_metodo' => 'edit-estorno'],
            'del_estorno' => ['menu_controller' => 'apagar-estorno', 'menu_metodo' => 'apagar-estorno']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/estorno/cadEstorno", $this->Dados);
        $carregarView->renderizar();
    }

}
