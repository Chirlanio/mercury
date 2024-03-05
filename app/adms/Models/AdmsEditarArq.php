<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarArq {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Arquivo;
    private $ArqAntiga;

    function getResultado() {
        return $this->Resultado;
    }

    public function verArq($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $verArq = new \App\adms\Models\helper\AdmsRead();
        $verArq->fullRead("SELECT id, nome, slug, adms_art_id, status_id, created, modified FROM adms_up_down
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verArq->getResult();
        return $this->Resultado;
    }

    public function altArq(array $Dados) {
        
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        
        $this->Arquivo = $this->Dados['slug'];
        unset($this->Arquivo['name']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);
        var_dump($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valArq();
        } else {
            $this->Resultado = false;
        }
    }

    private function valArq() {
        if (empty($this->Arquivo['name'])) {
            $this->updateEditArq();
        } else {
            $slugArq = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['slug'] = $slugArq->nomeSlug($this->Arquivo['name']);

            $uploadArq = new \App\adms\Models\helper\AdmsUpload();
            $uploadArq->upload($this->Dados, 'assets/download/' . $this->Dados['id'] . '/', $this->Arquivo['name']);
            if ($uploadArq->getResultado()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/download/' . $this->Dados['id'] . '/' . $this->ArqAntiga);
                $this->updateEditArq();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditArq() {
        
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltArq = new \App\adms\Models\helper\AdmsUpdate();
        $upAltArq->exeUpdate("adms_up_down", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltArq->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro do arquivo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro do arquivo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_art, titulo FROM adms_artigos ORDER BY titulo ASC");
        $registro['art'] = $listar->getResult();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['art' => $registro['art'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
