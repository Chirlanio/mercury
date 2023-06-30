<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: login-treinamento/acesso/");
    exit();
}

/**
 * Description of AdmsLoginTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsLoginTreinamento {

    private $Dados;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function acesso(array $Dados) {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $validaLogin = new \App\adms\Models\helper\AdmsRead();
            $validaLogin->fullRead("SELECT user.id, user.nome, user.usuario, user.email, user.cpf, user.senha, user.image, user.adms_niveis_acesso_id, user.adms_sits_usuario_id,
                    nivac.ordem	ordem_nivac, nivac.adms_cor_id, c.cor nivac_cor
                    FROM adms_users_treinamentos user
                    INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                    INNER JOIN adms_cors c ON c.id=nivac.adms_cor_id
                    WHERE user.cpf =:cpf AND user.adms_sits_usuario_id =:adms_sits_usuario_id LIMIT :limit", "cpf={$this->Dados['cpf']}&adms_sits_usuario_id=1&limit=1");
            $this->Resultado = $validaLogin->getResultado();
            if (!empty($this->Resultado)) {
                $this->validarSenha();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Senha Inválida!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function validarDados() {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário preencher todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function validarSenha() {
        if (password_verify($this->Dados['senha'], $this->Resultado[0]['senha'])) {
            $_SESSION['usuario_id'] = $this->Resultado[0]['id'];
            $_SESSION['usuario_nome'] = $this->Resultado[0]['nome'];
            $_SESSION['usuario'] = $this->Resultado[0]['usuario'];
            $_SESSION['usuario_email'] = $this->Resultado[0]['email'];
            $_SESSION['usuario_cpf'] = $this->Resultado[0]['cpf'];
            $_SESSION['usuario_image'] = $this->Resultado[0]['image'];
            $_SESSION['adms_niveis_acesso_id'] = $this->Resultado[0]['adms_niveis_acesso_id'];
            $_SESSION['status'] = $this->Resultado[0]['adms_sits_usuario_id'];
            $_SESSION['ordem_nivac'] = $this->Resultado[0]['ordem_nivac'];
            $_SESSION['nivac_cor'] = $this->Resultado[0]['nivac_cor'];
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário ou a senha incorreto!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
