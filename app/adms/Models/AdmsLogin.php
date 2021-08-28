<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsLogin
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsLogin {

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
            $validaLogin->fullRead("SELECT user.id, user.nome, user.email, user.usuario, user.senha, user.imagem, user.loja_id, user.adms_niveis_acesso_id,
                    nivac.ordem	ordem_nivac, nivac.adms_cor_id, c.cor, f.usuario nome_usuario, cg.nome cargo, l.nome loja
                    FROM adms_usuarios user
                    INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                    INNER JOIN adms_cors c ON c.id=nivac.adms_cor_id
                    INNER JOIN tb_funcionarios f ON f.loja_id=user.loja_id AND f.cargo_id=2 AND f.status_id=1
                    INNER JOIN tb_cargos cg ON cg.id=f.cargo_id
                    INNER JOIN tb_lojas l ON l.id=user.loja_id
                    WHERE user.usuario =:usuario AND f.status_id =:status_id LIMIT :limit", "usuario={$this->Dados['usuario']}&status_id=1&limit=1");
            $this->Resultado = $validaLogin->getResultado();
            if (!empty($this->Resultado)) {
                $this->validarSenha();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function validarDados() {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário preencher todos os campos!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function validarSenha() {
        if (password_verify($this->Dados['senha'], $this->Resultado[0]['senha'])) {
            $_SESSION['usuario_id'] = $this->Resultado[0]['id'];
            $_SESSION['usuario_nome'] = $this->Resultado[0]['nome'];
            $_SESSION['usuario_email'] = $this->Resultado[0]['email'];
            $_SESSION['usuario_imagem'] = $this->Resultado[0]['imagem'];
            $_SESSION['usuario_loja'] = $this->Resultado[0]['loja_id'];
            $_SESSION['adms_niveis_acesso_id'] = $this->Resultado[0]['adms_niveis_acesso_id'];
            $_SESSION['ordem_nivac'] = $this->Resultado[0]['ordem_nivac'];
            $_SESSION['nivac_cor'] = $this->Resultado[0]['cor'];
            $_SESSION['nome_gerente'] = $this->Resultado[0]['nome_usuario'];
            $_SESSION['nome_loja'] = $this->Resultado[0]['loja'];
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário ou a senha incorreto!</div>";
            $this->Resultado = false;
        }
    }

}
