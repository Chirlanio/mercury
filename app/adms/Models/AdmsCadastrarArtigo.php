<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarArtigo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsCadastrarArtigo {

    private $Resultado;
    private $Dados;
    private $Foto;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadArtigo(array $Dados) {
        
        $this->Dados = $Dados;
        
        $this->Foto = $this->Dados['imagem_nova'];
        unset($this->Dados['imagem_nova']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirArtigo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirArtigo() {
        
        $this->Dados['created'] = date("Y-m-d H:i:s");
        
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

        $slugPg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['slug'] = $slugPg->nomeSlug($this->Dados['slug']);

        $cadArtigo = new \App\adms\Models\helper\AdmsCreate;
        $cadArtigo->exeCreate("adms_artigos", $this->Dados);
        if ($cadArtigo->getResult()) {
            if (empty($this->Foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Artigo</strong>  cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadArtigo->getResult();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Artigo não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valFoto() {
        $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImg->uploadImagem($this->Foto, 'assets/imagens/artigos/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 1200, 627);
        if ($uploadImg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Artigo</strong>  cadastrado com sucesso. Upload da imagem realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Artigo cadastrado. Erro ao realizar o upload da imagem!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $listar->fullRead("SELECT id id_tpart, nome nome_tpart FROM adms_tps_artigos ORDER BY nome ASC");
        $registro['tpart'] = $listar->getResult();

        $listar->fullRead("SELECT id id_catart, nome nome_catart FROM adms_cats_artigos ORDER BY nome ASC");
        $registro['catart'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit'], 'tpart' => $registro['tpart'], 'catart' => $registro['catart']];

        return $this->Resultado;
    }

}
