<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditPolicies
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditPolicies {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;
    private $Filename;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewPolicie($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewPolicie = new \App\adms\Models\helper\AdmsRead();
        $viewPolicie->fullRead("SELECT * FROM adms_policies WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewPolicie->getResult();
        return $this->Resultado;
    }

    public function altPolicie(array $Dados) {
        $this->Dados = $Dados;
        $this->Foto = $this->Dados['new_image'];
        $this->ImgAntiga = $this->Dados['old_image'];
        $this->Filename = $this->Dados['file_name'];
        unset($this->Dados['new_image'], $this->Dados['old_image'], $this->Dados['file_name']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valFile();
        } else {
            $this->Resultado = false;
        }
    }

    private function valImage() {
        if (empty($this->Foto['name'])) {
            $this->updateEditPolicie();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['image'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/policies/' . $this->Dados['id'] . '/', $this->Dados['image'], 1200, 627);
            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/policies/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditPolicie();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function valFile() {
        if (empty($this->Filename['name'])) {
            $this->valImage();
        } else {
            $this->Dados['file_name'] = $this->Filename['name'];
            
            $slugArq = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['link'] = $slugArq->nomeSlug($this->Filename['name']);

            $uploadArq = new \App\adms\Models\helper\AdmsUpload();
            $uploadArq->upload($this->Filename, 'assets/files/policies/' . $this->Dados['id'] . '/', $this->Dados['file_name']);
            if ($uploadArq->getResultado()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/files/policies/' . $this->Dados['id'] . '/' . $this->Dados['file_name']);
                $this->valImage();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditPolicie() {

        $slugPg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['slug'] = $slugPg->nomeSlug($this->Dados['slug']);
        if (!empty($this->Foto['name'])) {
            $newImage = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['image'] = $newImage->nomeSlug($this->Foto['name']);
        } else {
            $this->Dados['image'] = $this->ImgAntiga;
        }

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        //var_dump($this->Dados);
        $upAltPolicie = new \App\adms\Models\helper\AdmsUpdate();
        $upAltPolicie->exeUpdate("adms_policies", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upAltPolicie->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Política</strong> atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Cadastro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listSit = new \App\adms\Models\helper\AdmsRead();

        $listSit->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listSit->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }
}
