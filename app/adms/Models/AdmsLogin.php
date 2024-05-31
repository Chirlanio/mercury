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
    private $UserId;
    private $UserOnline;

    function getResultado() {
        return $this->Resultado;
    }

    public function acesso(array $Dados) {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $validaLogin = new \App\adms\Models\helper\AdmsRead();
            $validaLogin->fullRead("SELECT user.id, user.nome, user.email, user.usuario, user.senha, user.imagem, user.loja_id, user.adms_niveis_acesso_id, user.adms_area_id, nivac.ordem ordem_nivac, nivac.adms_cor_id, c.cor, f.usuario nome_usuario, cg.nome cargo, l.nome loja FROM adms_usuarios user INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id INNER JOIN adms_cors c ON c.id=nivac.adms_cor_id LEFT JOIN tb_funcionarios f ON f.loja_id=user.loja_id INNER JOIN tb_cargos cg ON cg.id=f.cargo_id AND cg.adms_niv_cargo_id = 1 INNER JOIN tb_lojas l ON l.id=user.loja_id WHERE user.usuario =:usuario AND (cg.adms_niv_cargo_id =:adms_niv_cargo_id) AND f.status_id =:status_id LIMIT :limit", "adms_niv_cargo_id=1&usuario={$this->Dados['usuario']}&status_id=1&limit=1");
            $this->Resultado = $validaLogin->getResult();
            if (!empty($this->Resultado)) {
                $this->validarSenha();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Senha Inválida!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $this->Resultado = false;
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
            $_SESSION['area_id'] = $this->Resultado[0]['adms_area_id'];

            $this->verifyUsersOnline($this->Resultado[0]['id']);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário ou senha incorretos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function insertUsersOnline(int $UserId = null) {

        unset($this->Dados['usuario'], $this->Dados['senha']);
        $this->Dados['adms_user_id'] = $UserId;
        $this->Dados['hash_user_id'] = md5($UserId);
        $this->Dados['adms_store_id'] = $this->Resultado[0]['loja_id'];
        $this->Dados['adms_nivac_id'] = $this->Resultado[0]['adms_niveis_acesso_id'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->Dados['ip_access'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->Dados['ip_access'] = $_SERVER['REMOTE_ADDR'];
        }
        $this->Dados['adms_date_access'] = date("Y-m-d");
        $this->Dados['adms_hours_access'] = date("H:i:s");
        $this->Dados['adms_sit_access_id'] = 1;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $UserOnline = new \App\adms\Models\helper\AdmsCreate();
        $UserOnline->exeCreate("adms_users_online", $this->Dados);
        if ($UserOnline->getResult()) {
            $this->Resultado = true;
        } else {
            $this->Resultado = false;
        }
    }

    private function verifyUsersOnline(int $UserId = null) {
        $this->UserId = $UserId;

        $UserOnline = new \App\adms\Models\helper\AdmsRead();
        $UserOnline->fullRead("SELECT user.id lastAccessId, user.adms_sit_access_id FROM adms_users_online user WHERE user.adms_user_id =:adms_user ORDER BY user.id DESC LIMIT :limit", "adms_user={$this->UserId}&limit=1");
        $this->UserOnline = $UserOnline->getResult();

        if ((!empty($this->UserOnline) and $this->UserOnline[0]['adms_sit_access_id'] == 2) or empty($UserOnline->getResult())) {
            $this->insertUsersOnline($this->UserId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário já logado em outro terminal!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function logoutUser(int $UserId) {
        $this->UserId = $UserId;

        $UserOnline = new \App\adms\Models\helper\AdmsRead();
        $UserOnline->fullRead("SELECT user.id lastAccessId, user.adms_sit_access_id FROM adms_users_online user WHERE user.adms_user_id =:adms_user ORDER BY user.id DESC LIMIT :limit", "adms_user={$this->UserId}&limit=1");
        $this->UserOnline = $UserOnline->getResult();

        $this->Dados['id'] = $this->UserOnline[0]['lastAccessId'];
        $this->Dados['adms_date_logout'] = date("Y-m-d");
        $this->Dados['adms_hours_logout'] = date("H:i:s");
        $this->Dados['adms_sit_access_id'] = 2;
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $logoff = new \App\adms\Models\helper\AdmsUpdate();
        $logoff->exeUpdate("adms_users_online", $this->Dados, "WHERE id=:user", "user={$this->Dados['id']}");

        if ($logoff->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário</strong> deslogado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuário não foi deslogado do sistema!</div>";
            $this->Resultado = false;
        }
    }
}
