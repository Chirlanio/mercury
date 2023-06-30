<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarRemanejo {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $File;
    private $FileAntigo;
    private $Nf;

    function getResultado() {
        return $this->Resultado;
    }

    public function verRemanejo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verRemanejo = new \App\adms\Models\helper\AdmsRead();
        $verRemanejo->fullRead("SELECT id, adms_marca_id, loja_origem_id, loja_destino_id,
                adms_tipo_rem_id, adms_prdd_id, adms_sit_rem_id, nf, arquivo
                FROM adms_remanejos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verRemanejo->getResultado();
        return $this->Resultado;
    }

    public function altRemanejo(array $Dados) {
        $this->Dados = $Dados;
        $this->File = $this->Dados['novo_file'];
        $this->FileAntigo = $this->Dados['file_antigo'];
        $this->Nf = $this->Dados['nf'];
        unset($this->Dados['novo_file'], $this->Dados['file_antigo'], $this->Dados['nf']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valArquivo();
        } else {
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (empty($this->File['name'])) {
            $this->updateEditRemanejo();
        } else {
            $slugArq = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['arquivo'] = $slugArq->nomeSlug($this->File['name']);

            $uploadArq = new \App\adms\Models\helper\AdmsUpload();
            $uploadArq->upload($this->File, 'assets/files/remanejo/' . $this->Dados['id'] . '/', $this->Dados['arquivo']);
            if ($uploadArq->getResultado()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/files/remanejo/' . $this->Dados['id'] . '/' . $this->FileAntigo);
                $this->updateEditRemanejo();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditRemanejo() {
        $this->Dados['nf'] = $this->Nf;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltArq = new \App\adms\Models\helper\AdmsUpdate();
        $upAltArq->exeUpdate("adms_remanejos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltArq->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Remanejo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O remanejo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id mar_id, nome marca FROM adms_marcas");
        $registro['mar_id'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id id_loja, nome loja_origem FROM tb_lojas ORDER BY id ASC");
        $registro['loja_ori'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id loja_des, nome loja_destino FROM tb_lojas ORDER BY id ASC");
        $registro['loja_des'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id tip_id, nome tipo FROM adms_tps_remanejos ORDER BY nome ASC");
        $registro['tip_id'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id prdd_id, nome prioridade FROM adms_prioridades ORDER BY nome ASC");
        $registro['prdd'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome situacao FROM adms_sits_remanejos ORDER BY nome ASC");
        $registro['sit_id'] = $listar->getResultado();

        $this->Resultado = ['mar_id' => $registro['mar_id'], 'loja_ori' => $registro['loja_ori'],
                            'loja_des' => $registro['loja_des'], 'tip_id' => $registro['tip_id'],
                            'prdd' => $registro['prdd'], 'sit_id' => $registro['sit_id']];

        return $this->Resultado;
    }

}
