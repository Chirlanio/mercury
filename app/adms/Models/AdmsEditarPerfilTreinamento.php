<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarPerfilTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarPerfilTreinamento {

    private $Resultado;
    private $Dados;
    private $Foto;
    private $ImgAntiga;

    function getResultado() {
        return $this->Resultado;
    }

    public function altPerfil(array $Dados) {
        $this->Dados = $Dados;
        var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['image'];
        unset($this->Dados['imagem_nova'], $this->Dados['image']);

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

        if ( $valEmail->getResultado()) {
            $this->valFoto();
        } else {
            $this->Resultado = false;
        }
    }

    private function valFoto() {
        if (empty($this->Foto['name'])) {
            $this->updateEditPerfil();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['image'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/treinamento/' . $_SESSION['usuario_id'] . '/', $this->Dados['image'], 150, 150);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/usuario/treinamento/' . $_SESSION['usuario_id'] . '/' . $this->ImgAntiga);
                $this->updateEditPerfil();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditPerfil() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_users_treinamentos", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['usuario_id']);
        if ($upAltSenha->getResultado()) {
            $_SESSION['usuario_nome'] = $this->Dados['nome'];
            $_SESSION['usuario_email'] = $this->Dados['email'];
            $_SESSION['usuario_imagem'] = $this->Dados['image'];
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Perfil</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O perfil não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
