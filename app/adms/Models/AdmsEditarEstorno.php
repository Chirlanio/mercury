<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarEstorno
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditarEstorno {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $File;
    private $FileAntigo;

    function getResultado() {
        return $this->Resultado;
    }

    public function verEstorno($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verEstorno = new \App\adms\Models\helper\AdmsRead();
        $verEstorno->fullRead("SELECT es.*, lj.nome loja, f.nome func, fp.nome pag, b.nome bandeira, rp.nome resp,
                se.nome sit
                FROM adms_estornos es
                INNER JOIN tb_lojas lj ON lj.id=es.loja_id
                INNER JOIN tb_funcionarios f ON f.id=es.adms_func_id
                INNER JOIN tb_forma_pag fp ON fp.id=es.tb_forma_pag_id
                INNER JOIN adms_bandeiras b ON b.id=es.adms_bandeira_id
                INNER JOIN adms_resp_autorizacao rp ON rp.id=es.adms_resp_aut_id
                INNER JOIN adms_sits_estornos se ON se.id=es.adms_sits_est_id
                WHERE es.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verEstorno->getResultado();
        return $this->Resultado;
    }

    public function altEstorno(array $Dados) {
        $this->Dados = $Dados;
        $this->File = $this->Dados['file_novo'];
        $this->FileAntigo = $this->Dados['file_antigo'];
        $this->Dados['valor_lancado'] = str_replace(',', '.', $this->Dados['valor_lancado']);
        $this->Dados['valor_correto'] = str_replace(',', '.', $this->Dados['valor_correto']);
        $this->Dados['valor_estorno'] = str_replace(',', '.', $this->Dados['valor_estorno']);
        $this->Dados['cpf_cliente'] = str_replace(['.','-'], '', $this->Dados['cpf_cliente']);
        unset($this->Dados['file_novo'], $this->Dados['file_antigo']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valEstorno();
        } else {
            $this->Resultado = false;
        }
    }

    private function valEstorno() {
        if (empty($this->File['name'])) {
            $this->updateEditEstorno();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['arquivo'] = $slugImg->nomeSlug($this->File['name']);

            $upload = new \App\adms\Models\helper\AdmsUpload();
            $upload->upload($this->File, 'assets/files/estorno/' . $this->Dados['id'] . '/', $this->Dados['arquivo']);
            if ($upload->getResultado()) {
                $this->updateEditEstorno();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditEstorno() {
        
        $slugPg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['arquivo'] = $slugPg->nomeSlug($this->Dados['arquivo']);

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltEstorno = new \App\adms\Models\helper\AdmsUpdate();
        $upAltEstorno->exeUpdate("adms_estornos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltEstorno->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A olicitação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id adms_bandeira_id, nome bandeira FROM adms_bandeiras ORDER BY nome ASC");
        $registro['adms_bandeira_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id tb_forma_pag_id, nome forma_pag FROM tb_forma_pag ORDER BY nome ASC");
        $registro['tb_forma_pag_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id adms_resp_aut_id, nome resp_aut FROM adms_resp_autorizacao ORDER BY nome ASC");
        $registro['adms_resp_aut_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id adms_sits_est_id, nome sit_est FROM adms_sits_estornos WHERE id <>:id ORDER BY id ASC", "id=3");
        $registro['adms_sits_est_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE status_id =:status_id ORDER BY id_loja ASC", "status_id=1");
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id adms_func_id, nome func FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        $registro['adms_func_id'] = $listar->getResultado();

        $this->Resultado = ['adms_bandeira_id' => $registro['adms_bandeira_id'], 'tb_forma_pag_id' => $registro['tb_forma_pag_id'],
            'adms_resp_aut_id' => $registro['adms_resp_aut_id'], 'adms_sits_est_id' => $registro['adms_sits_est_id'],
            'loja_id' => $registro['loja_id'], 'adms_func_id' => $registro['adms_func_id']];

        return $this->Resultado;
    }

}
