<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAlterarSenha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsAlterarSenha {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function altSenha(array $Dados) {
        $this->Dados = $Dados;

        $valSenha = new \App\adms\Models\helper\AdmsValSenha();
        $valSenha->valSenha($this->Dados['senha']);

        if ($valSenha->getResultado()) {
            $this->updateAltSenha();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateAltSenha() {
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['usuario_id']);
        if ($upAltSenha->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

}
