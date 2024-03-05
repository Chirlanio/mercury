<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarUsuarioTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarUsuarioTreinamento {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;

    function getResultado() {
        return $this->Resultado;
    }

    public function verUsuario($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_users_treinamentos WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPerfil->getResult();
        return $this->Resultado;
    }

    public function cadUsuario(array $Dados) {
        $this->Dados = $Dados;
        $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
        $this->Foto = $this->Dados['imagem_nova'];
        unset($this->Dados['imagem_nova']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valCampos();
        } else {
            $this->Resultado = false;
        }
    }

    private function valCampos() {

        $this->Dados['cpf'] = str_replace('.', '', str_replace('-', '', $this->Dados['cpf']));

        $valEmail = new \App\adms\Models\helper\AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnicoTreinamento();
        $valEmailUnico->valEmailUnico($this->Dados['email']);

        $valCpfUnico = new \App\adms\Models\helper\AdmsCpfUnico();
        $valCpfUnico->valCpfUnico($this->Dados['cpf']);

        $valSenha = new \App\adms\Models\helper\AdmsValSenha();
        $valSenha->valSenha($this->Dados['senha']);

        if (($valSenha->getResultado()) AND ( $valCpfUnico->getResultado()) AND ( $valEmailUnico->getResultado()) AND ( $valEmail->getResultado())) {
            $this->inserirUsuario();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirUsuario() {
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['image'] = $slugImg->nomeSlug($this->Foto['name']);

        $cadUsuario = new \App\adms\Models\helper\AdmsCreate;
        $cadUsuario->exeCreate("adms_users_treinamentos", $this->Dados);
        if ($cadUsuario->getResult()) {
            if (empty($this->Foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadUsuario->getResult();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O usuario não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valFoto() {
        $uploadImg = new \App\adms\Models\helper\AdmsUploadImg();
        $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/treinamento/' . $this->Dados['id'] . '/', $this->Dados['image'], 150, 150);
        if ($uploadImg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O usuario não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_nivac, nome nome_nivac FROM adms_niveis_acessos WHERE id =:id ORDER BY nome ASC", "id=11");
        $registro['nivac'] = $listar->getResult();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits_usuarios ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['nivac' => $registro['nivac'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
