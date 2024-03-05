<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarSenhaTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarSenhaTreinamento {

    private $DadosId;
    private $Dados;
    private $Resultado;
    private $DadosUsuario;

    function getResultado() {
        return $this->Resultado;
    }

    public function valUsuario($DadosId) {
        $this->DadosId = (int) $DadosId;
        $validaUsuario = new \App\adms\Models\helper\AdmsRead();
        $validaUsuario->fullRead("SELECT user.id FROM adms_users_treinamentos user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->DadosUsuario = $validaUsuario->getResult();
        if (!empty($this->DadosUsuario)) {
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function editSenha(array $Dados) {
        $this->Dados = $Dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampoVazio->validarDados($this->Dados);
        if ($valCampoVazio->getResultado()) {
            $valSenha = new \App\adms\Models\helper\AdmsValSenha();
            $valSenha->valSenha($this->Dados['senha']);
            if ($valSenha->getResultado()) {
                $this->updateEditSenha();
            } else {
                $this->Resultado = false;
            }
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSenha() {
        $this->valUsuario($this->Dados['id']);
        if ($this->Resultado) {
            $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
            $this->Dados['modified'] = date("Y-m-d H:i:s");
            $upAtualSenha = new \App\adms\Models\helper\AdmsUpdate();
            $upAtualSenha->exeUpdate("adms_users_treinamentos", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
            if ($upAtualSenha->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Senha</strong> atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A senha não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A senha não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
