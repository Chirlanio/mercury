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
        $this->Filename = $this->Dados['file_name'];
        unset($this->Dados['file_name']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valFile();
        } else {
            $this->Resultado = false;
        }
    }

    private function valFile() {
        if (isset($this->Filename['name']) and (!empty($this->Filename['name']))) {
            $this->Dados['file_name'] = $this->Filename['name'];

            $slugArq = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['link'] = $slugArq->nomeSlug($this->Filename['name']);

            $uploadArq = new \App\adms\Models\helper\AdmsUpload();
            $uploadArq->upload($this->Filename, 'assets/files/policies/' . $this->Dados['id'] . '/', $this->Dados['link']);
            if ($uploadArq->getResultado()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/files/policies/' . $this->Dados['id'] . '/' . $this->Dados['file_name_old']);
                $this->updateEditPolicie();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Não foi possível enviar o arquivo.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $this->updateEditPolicie();
        }
    }

    private function updateEditPolicie() {

        if(isset($this->Dados['file_name_old'])){
            unset($this->Dados['file_name_old']);
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
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
