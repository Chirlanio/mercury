<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarUsuarioTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarUsuarioTreinamento {

    private $Dados;

    public function cadUsuario() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadUsuario'])) {
            unset($this->Dados['CadUsuario']);
            
            $cadUsuario = new \App\adms\Models\AdmsCadastrarUsuarioTreinamento();
            $cadUsuario->cadUsuario($this->Dados);
            if ($cadUsuario->getResultado()) {
                $UrlDestino = URLADM . 'usuarios-treinamento/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadUsuarioViewPriv();
            }
        } else {
            $this->cadUsuarioViewPriv();
        }
    }

    private function cadUsuarioViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarUsuarioTreinamento();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_usuario' => ['menu_controller' => 'usuarios-treinamento', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/cadUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}
