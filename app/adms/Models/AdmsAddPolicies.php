<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddPolicies
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddPolicies {

    private $Resultado;
    private $Dados;
    private $Foto;
    private $Filename;

    function getResultado() {
        return $this->Resultado;
    }

    public function addPolicie(array $Dados) {

        $this->Dados = $Dados;

        $this->Filename = $this->Dados['file_name'];
        unset($this->Dados['file_name']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertPolicie();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertPolicie() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['link'] = $slugImg->nomeSlug($this->Filename['name']);
        $this->Dados['file_name'] = $this->Filename['name'];
        
        var_dump($this->Dados);

        $addPolicie = new \App\adms\Models\helper\AdmsCreate;
        $addPolicie->exeCreate("adms_policies", $this->Dados);
        if ($addPolicie->getResult()) {
            if (empty($this->Filename['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Política</strong> cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $addPolicie->getResult();
                $this->valFile();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Política não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valFile() {

        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['link'] = $slugImg->nomeSlug($this->Filename['name']);

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->Filename, 'assets/files/policies/' . $this->Dados['id'] . '/', $this->Dados['link']);

        if ($uploadArq->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Política</strong> cadastrada, arquivo enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Política cadastrada, arquivo não enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }
}
