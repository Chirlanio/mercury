<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarArquivo {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Arquivo;
    private $ArqAntigo;

    function getResultado() {
        return $this->Resultado;
    }

    public function verArquivo($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verArq = new \App\adms\Models\helper\AdmsRead();
        $verArq->fullRead("SELECT * FROM adms_up_down
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verArq->getResult();
        return $this->Resultado;
    }

    public function altArquivo(array $Dados) {

        $this->Dados = $Dados;

        $this->Arquivo = $this->Dados['slug'];
        $this->ArqAntigo = $this->Dados['arq_antigo'];
        
        if (!empty($this->Dados['arq_antigo'])) {
            unset($this->Dados['arq_antigo'], $this->Dados['slug']);
        }

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            if(empty($this->Dados['slug'])){
                $this->Dados['slug'] = $this->ArqAntigo;
            } else {
                $this->Dados['slug'] = $this->Arquivo;
            }
            $this->valArquivo();
        } else {
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (empty($this->Arquivo['name'])) {
            $this->updateEditArquivo();
        } else {
            $slugArq = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['slug'] = $slugArq->nomeSlug($this->Arquivo['name']);

            $uploadArq = new \App\adms\Models\helper\AdmsUpload();
            $uploadArq->upload($this->Arquivo, 'assets/files/downloads/' . $this->Dados['id'] . '/', $this->Dados['slug']);
            if ($uploadArq->getResultado()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/files/downloads/' . $this->Dados['id'] . '/' . $this->ArqAntigo);
                $this->updateEditArquivo();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditArquivo() {

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltArq = new \App\adms\Models\helper\AdmsUpdate();
        $upAltArq->exeUpdate("adms_up_down", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltArq->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();
        
        $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas WHERE status_id =:status_id", "status_id=1");
        $registro['loja'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit'], 'loja' => $registro['loja']];

        return $this->Resultado;
    }

}
