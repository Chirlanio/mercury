<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarTransf {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verTransf($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verTransf = new \App\adms\Models\helper\AdmsRead();
        if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $verTransf->fullRead("SELECT t.id, t.loja_origem_id, t.loja_destino_id, t.nf, t.qtd_vol, t.qtd_prod, t.tipo_transf_id, t.status_id, t.recebido, t.confirma_receb, l.nome loja_ori, ld.nome loja_dest, tt.id tipo_id, st.id sit_id FROM tb_transferencias t INNER JOIN tb_lojas l ON l.id=t.loja_origem_id INNER JOIN tb_lojas ld ON ld.id=t.loja_destino_id INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id INNER JOIN tb_status_transf st ON st.id=t.status_id WHERE t.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        } else {
            $verTransf->fullRead("SELECT t.id, t.loja_origem_id, t.loja_destino_id, t.nf, t.qtd_vol, t.qtd_prod, t.tipo_transf_id, t.status_id, t.recebido, t.confirma_receb, l.nome loja_ori, tt.id tipo_id, st.id sit_id FROM tb_transferencias t INNER JOIN tb_lojas l ON l.id=t.loja_origem_id INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id INNER JOIN tb_status_transf st ON st.id=t.status_id WHERE t.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        }

        $this->Resultado = $verTransf->getResultado();
        return $this->Resultado;
    }

    public function altTransf(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTransf();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTransf() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTransf = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTransf->exeUpdate("tb_transferencias", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTransf->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>solicitação atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] >= 4) {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_origem_id'] = $listar->getResultado();

        if ($_SESSION['ordem_nivac'] >= 4) {
            $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas WHERE id !=:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_destino_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tipo, nome tipo FROM tb_tipo_transf ORDER BY id ASC");
        $registro['tipo_transf_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sit, nome sit FROM tb_status_transf ORDER BY id ASC");
        $registro['status_id'] = $listar->getResultado();

        $this->Resultado = ['loja_origem_id' => $registro['loja_origem_id'], 'loja_destino_id' => $registro['loja_destino_id'], 'tipo_transf_id' => $registro['tipo_transf_id'], 'status_id' => $registro['status_id']];

        return $this->Resultado;
    }

}
