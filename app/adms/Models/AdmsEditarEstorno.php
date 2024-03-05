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
    private $Bandeira;
    private $Parcelas;
    private $Nsu;
    private $Autorizacao;
    private $FileAntigo;
    private $Obs;

    function getResultado() {
        return $this->Resultado;
    }

    public function verEstorno($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verEstorno = new \App\adms\Models\helper\AdmsRead();
        $verEstorno->fullRead("SELECT es.id, es.loja_id, es.adms_func_id, es.nome_cliente, es.cpf_cliente, es.valor_lancado, es.valor_correto,
                es.valor_estorno, es.doc_nf, es.tb_forma_pag_id, es.adms_bandeira_id, es.qtd_parcelas, es.nsu, es.auto_cartao, es.adms_tps_est_id,
                es.adms_resp_aut_id, es.adms_mot_est_id, es.arquivo, es.obs, es.adms_sits_est_id, es.created,
                lj.nome loja, f.nome func, fp.nome pag, b.nome bandeira, rp.nome resp, se.nome sit FROM adms_estornos es INNER JOIN tb_lojas lj ON lj.id=es.loja_id INNER JOIN tb_funcionarios f ON f.id=es.adms_func_id LEFT JOIN tb_forma_pag fp ON fp.id=es.tb_forma_pag_id LEFT JOIN adms_bandeiras b ON b.id=es.adms_bandeira_id INNER JOIN adms_resp_autorizacao rp ON rp.id=es.adms_resp_aut_id INNER JOIN adms_sits_estornos se ON se.id=es.adms_sits_est_id WHERE es.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verEstorno->getResult();
        return $this->Resultado;
    }

    public function altEstorno(array $Dados) {
        $this->Dados = $Dados;

        if ($_SESSION['adms_niveis_acesso_id'] == 1 || $_SESSION['adms_niveis_acesso_id'] == 5) {
            $this->File = $this->Dados['file_novo'];
            $this->FileAntigo = $this->Dados['file_antigo'];
            $this->Nsu = $this->Dados['nsu'];
            $this->Autorizacao = $this->Dados['auto_cartao'];
            $this->Bandeira = $this->Dados['adms_bandeira_id'];
            $this->Parcelas = $this->Dados['qtd_parcelas'];
        } else {
            $this->File = $this->Dados['file_novo'];
            $this->FileAntigo = $this->Dados['file_antigo'];
        }
        $this->Obs = $this->Dados['obs'];

        if ((!empty($this->Dados['valor_lancado'])) and (!empty($this->Dados['valor_correto'])) and (!empty($this->Dados['valor_estorno']))) {
            $this->Dados['valor_lancado'] = str_replace('.', '', $this->Dados['valor_lancado']);
            $this->Dados['valor_lancado'] = str_replace(',', '.', $this->Dados['valor_lancado']);
            $this->Dados['valor_correto'] = str_replace('.', '', $this->Dados['valor_correto']);
            $this->Dados['valor_correto'] = str_replace(',', '.', $this->Dados['valor_correto']);
            $this->Dados['valor_estorno'] = str_replace('.', '', $this->Dados['valor_estorno']);
            $this->Dados['valor_estorno'] = str_replace(',', '.', $this->Dados['valor_estorno']);
            $this->Dados['cpf_cliente'] = str_replace(['.', '-'], '', $this->Dados['cpf_cliente']);
        }
        unset($this->Dados['file_novo'], $this->Dados['file_antigo'], $this->Dados['adms_bandeira_id'], $this->Dados['qtd_parcelas'], $this->Dados['nsu'], $this->Dados['auto_cartao'], $this->Dados['obs']);

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

        if ($_SESSION['adms_niveis_acesso_id'] == 1 || $_SESSION['adms_niveis_acesso_id'] == 5) {
            $this->Dados['adms_bandeira_id'] = $this->Bandeira;
            $this->Dados['qtd_parcelas'] = $this->Parcelas;
            $this->Dados['nsu'] = $this->Nsu;
            $this->Dados['auto_cartao'] = $this->Autorizacao;
        }
        $slugPg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['arquivo'] = $slugPg->nomeSlug($this->Dados['arquivo']);
        $this->Dados['obs'] = $this->Obs;

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltEstorno = new \App\adms\Models\helper\AdmsUpdate();
        $upAltEstorno->exeUpdate("adms_estornos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltEstorno->getResult()) {
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
        $registro['adms_bandeira_id'] = $listar->getResult();

        $listar->fullRead("SELECT id tb_forma_pag_id, nome forma_pag FROM tb_forma_pag ORDER BY nome ASC");
        $registro['tb_forma_pag_id'] = $listar->getResult();

        $listar->fullRead("SELECT r.id adms_resp_aut_id, r.nome, f.nome resp_aut FROM adms_resp_autorizacao r INNER JOIN adms_usuarios f ON f.id=r.adms_func_id ORDER BY nome ASC");
        $registro['adms_resp_aut_id'] = $listar->getResult();

        $listar->fullRead("SELECT id adms_sits_est_id, nome sit_est FROM adms_sits_estornos WHERE id <>:id ORDER BY id ASC", "id=3");
        $registro['adms_sits_est_id'] = $listar->getResult();

        $listar->fullRead("SELECT id adms_mot_est_id, nome motivo FROM adms_motivo_estorno ORDER BY nome ASC");
        $registro['id_mot'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] <= 3 or $_SESSION['adms_niveis_acesso_id'] == 10) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE status_id =:status_id ORDER BY id_loja ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id_loja ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja_id'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] <= 3 or $_SESSION['adms_niveis_acesso_id'] == 10) {
            $listar->fullRead("SELECT id adms_func_id, nome func FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id adms_func_id, nome func FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['adms_func_id'] = $listar->getResult();

        $this->Resultado = ['adms_bandeira_id' => $registro['adms_bandeira_id'], 'tb_forma_pag_id' => $registro['tb_forma_pag_id'],
            'adms_resp_aut_id' => $registro['adms_resp_aut_id'], 'adms_sits_est_id' => $registro['adms_sits_est_id'], 'id_mot' => $registro['id_mot'],
            'loja_id' => $registro['loja_id'], 'adms_func_id' => $registro['adms_func_id']];

        return $this->Resultado;
    }

}
