<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarUsuarioModal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarUsuarioModal {

    private $Dados;

    public function cadUsuario() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        unset($_SESSION['msg']);
        $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);

        $DadosCadUsuario = new \App\cpadms\Models\CpAdmsCadastrarUsuario();
        $DadosCadUsuario->cadUsuario($this->Dados);

        if ($DadosCadUsuario->getResultado()) {
            $retorna = ['erro' => true, 'msg' => $_SESSION['msg']];
            unset($_SESSION['msg']);
        } else {
            $retorna = ['erro' => false, 'msg' => $_SESSION['msg']];
            unset($_SESSION['msg']);
        }

        header('Content-Type: application/json');
        echo json_encode($retorna);
    }

}
