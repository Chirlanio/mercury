<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarArq
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarArq {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Arquivo;

    function getResultado() {
        return $this->Resultado;
    }

    public function verArq($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_artigos WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPerfil->getResult();
        return $this->Resultado;
    }

    public function cadArq(array $Dados) {

        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Arquivo = $this->Dados['slug'];
        unset($this->Dados['slug']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirArq();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirArq() {

        $this->Dados['slug'] = $this->Arquivo['name'];
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['slug'] = $slugImg->nomeSlug($this->Arquivo['name']);

        $cadArq = new \App\adms\Models\helper\AdmsCreate;
        $cadArq->exeCreate("adms_up_down", $this->Dados);

        if ($cadArq->getResult()) {
            if (empty($this->Arquivo['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Arquivo cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadArq->getResult();
                $this->valArq();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O arquivo não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    private function valArq() {

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->Arquivo, 'assets/download/' . $this->Dados['id'] . '/', $this->Dados['slug']);

        if ($uploadArq->getResultado()) {
            if ($uploadArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Arquivo cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warnnig'>Arquivo cadastrado com sucesso, arquivo não enviado!</div>";
                $this->Resultado = true;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning'>Erro: Arquivo cadastrado, porém não foi enviado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_art, titulo FROM adms_artigos WHERE adms_sit_id =:adms_sit_id ORDER BY id DESC", "adms_sit_id=1");
        $registro['art'] = $listar->getResult();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['art' => $registro['art'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
