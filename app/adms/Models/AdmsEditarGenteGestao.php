<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarGenteGestao
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarGenteGestao {

    private $Resultado;
    private $Dados;
    private $Arquivo;
    private $ArqAntigo;

    function getResultado() {
        return $this->Resultado;
    }

    public function verGenteGestao() {
        $verGenteGestao = new \App\adms\Models\helper\AdmsRead();
        $verGenteGestao->fullRead("SELECT * FROM adms_gente_gestao WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verGenteGestao->getResultado();
        return $this->Resultado;
    }

    public function altGenteGestao(array $Dados) {
        $this->Dados = $Dados;
        $this->Arquivo = $this->Dados['arquivo_novo'];
        $this->ArqAntigo = $this->Dados['arquivo_antigo'];
        unset($this->Dados['arquivo_novo'], $this->Dados['arquivo_antigo']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valArquivo();
        } else {
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (empty($this->Arquivo['name'])) {
            $this->updateGenteGestao();
        } else {
            $slugArq = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['arquivo'] = $slugArq->nomeSlug($this->Arquivo['name']);

            $uploadArq = new \App\adms\Models\helper\AdmsUpload();
            $uploadArq->upload($this->Arquivo, 'assets/download/gente-gestao/', $this->Arquivo['name']);
            
            if ($uploadArq->getResultado()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/download/gente-gestao/' . $this->ArqAntigo);
                $this->updateGenteGestao();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateGenteGestao() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upGenteGestao = new \App\adms\Models\helper\AdmsUpdate();
        $upGenteGestao->exeUpdate("adms_gente_gesta", $this->Dados, "WHERE id =:id", "id=1");
        if ($upGenteGestao->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Dados atualizados com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Os dados não foram atualizados!</div>";
            $this->Resultado = false;
        }
    }

}
