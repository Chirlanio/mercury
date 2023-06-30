<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarArquivo {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Arquivo;

    function getResultado() {
        return $this->Resultado;
    }

    public function verArquivo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verArq = new \App\adms\Models\helper\AdmsRead();
        $verArq->fullRead("SELECT * FROM adms_up_down WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verArq->getResultado();
        return $this->Resultado;
    }

    public function cadArquivo(array $Dados) {

        $this->Dados = $Dados;
        $this->Arquivo = $this->Dados['slug'];
        unset($this->Dados['slug']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirArquivo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirArquivo() {

        $this->Dados['slug'] = $this->Arquivo['name'];
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['slug'] = $slugImg->nomeSlug($this->Arquivo['name']);

        $cadArq = new \App\adms\Models\helper\AdmsCreate;
        $cadArq->exeCreate("adms_up_down", $this->Dados);

        if ($cadArq->getResultado()) {
            if (empty($this->Arquivo['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Arquivo</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadArq->getResultado();
                $this->valArquivo();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> O arquivo não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valArquivo() {

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->Arquivo, 'assets/files/downloads/' . $this->Dados['id'] . '/', $this->Dados['slug']);

        if ($uploadArq->getResultado()) {
            if ($uploadArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Arquivos</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Arquivo cadastrado, porém não foi enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Arquivo </strong> cadastrado com sucesso, arquivo não enviado, excede o tamanho máximo de 4M!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['loja'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit'], 'loja' => $registro['loja']];

        return $this->Resultado;
    }

}
