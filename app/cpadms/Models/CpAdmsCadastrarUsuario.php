<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsCadastrarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsCadastrarUsuario {

    private $Dados;
    private $Resultado;
    private $Foto;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadUsuario(array $Dados) {
        $this->Dados = $Dados;
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
        $valEmail = new \App\adms\Models\helper\AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
        $valEmailUnico->valEmailUnico($this->Dados['email']);

        $valUsuario = new \App\adms\Models\helper\AdmsValUsuario();
        $valUsuario->valUsuario($this->Dados['usuario']);

        $valSenha = new \App\adms\Models\helper\AdmsValSenha();
        $valSenha->valSenha($this->Dados['senha']);

        if (($valSenha->getResultado()) AND ( $valUsuario->getResultado()) AND ( $valEmailUnico->getResultado()) AND ( $valEmail->getResultado())) {
            if(!empty($this->Foto['name'])){
                $this->validarImagem();
            } else {
                $this->inserirUsuario();
            }
            
        } else {
            $this->Resultado = false;
        }
    }
    
    private function validarImagem() {
        $valImagem = new \App\cpadms\Models\helper\CpAdmsValImg();
        $valImagem->validarImagem($this->Foto);
        if($valImagem->getResultado()){
            $this->inserirUsuario();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirUsuario() {
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

        $cadUsuario = new \App\adms\Models\helper\AdmsCreate;
        $cadUsuario->exeCreate("adms_usuarios", $this->Dados);
        if ($cadUsuario->getResultado()) {
            if (empty($this->Foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadUsuario->getResultado();
                $this->uploadFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    private function uploadFoto() {
        $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 150, 150);
        if ($uploadImg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_nivac, nome nome_nivac FROM adms_niveis_acessos WHERE ordem >=:ordem ORDER BY nome ASC", "ordem=" . $_SESSION['ordem_nivac']);
        $registro['nivac'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits_usuarios ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY nome ASC");
        $registro['loja'] = $listar->getResultado();

        $this->Resultado = ['nivac' => $registro['nivac'], 'sit' => $registro['sit'], 'loja' => $registro['loja']];

        return $this->Resultado;
    }

}
