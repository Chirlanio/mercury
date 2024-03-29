<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarSenha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarSenha {

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
        $validaUsuario->fullRead("SELECT user.id FROM adms_usuarios user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->DadosUsuario = $validaUsuario->getResult();
        if (!empty($this->DadosUsuario)) {
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
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
            $upAtualSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
            if ($upAtualSenha->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }
}
