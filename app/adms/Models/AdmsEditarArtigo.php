<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarArtigo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditarArtigo {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;

    function getResultado() {
        return $this->Resultado;
    }

    public function verArtigo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT * FROM adms_artigos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verArtigo->getResult();
        return $this->Resultado;
    }

    public function altArtigo(array $Dados) {
        $this->Dados = $Dados;
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valArtigo();
        } else {
            $this->Resultado = false;
        }
    }

    private function valArtigo() {
        if (empty($this->Foto['name'])) {
            $this->updateEditArtigo();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/artigos/' . $this->Dados['id'] . '/', $this->Dados['imagem'], 1200, 627);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/artigos/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditArtigo();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditArtigo() {
        
        $slugPg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['slug'] = $slugPg->nomeSlug($this->Dados['slug']);

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltArtigo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltArtigo->getResult("adms_artigos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Artigo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Artigo não foi atualizado!</div>";
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
