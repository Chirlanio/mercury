<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarTransferencia
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarTransferencia {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarTransf($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'transferencia/listar-transf');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id", "loja_origem_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= STOREPERMITION) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr FROM tb_transferencias t INNER JOIN tb_lojas l ON l.id=t.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id INNER JOIN tb_status_transf s ON s.id=t.status_id INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr FROM tb_transferencias t INNER JOIN tb_lojas l ON l.id=t.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id INNER JOIN tb_status_transf s ON s.id=t.status_id INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id WHERE loja_origem_id =:loja_origem_id OR loja_destino_id =:loja_destino_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResult();
        return $this->Resultado;
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_transf ORDER BY id ASC");
        $registro['status'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_origem'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas WHERE id !=:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_destino'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT COUNT(id) AS total_transf FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id", "loja_origem_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_transf FROM tb_transferencias");
        }
        $registro['transf'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT COUNT(id) AS total_aguardo FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id AND status_id =:status_id", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_aguardo FROM tb_transferencias WHERE status_id =:status_id", "status_id=1");
        }
        $registro['aguardo'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT COUNT(id) AS total_recolhido FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id AND status_id =:status_id", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&status_id=2");
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_recolhido FROM tb_transferencias WHERE status_id =:status_id", "status_id=2");
        }
        $registro['recolhido'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT COUNT(id) AS total_entregue FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id AND status_id =:status_id", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&status_id=3");
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_entregue FROM tb_transferencias WHERE status_id =:status_id", "status_id=3");
        }
        $registro['entregue'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT COUNT(id) AS total_cancelado FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id AND status_id =:status_id", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&status_id=4");
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_cancelado FROM tb_transferencias WHERE status_id =:status_id", "status_id=4");
        }
        $registro['cancelado'] = $listar->getResult();

        $this->Resultado = ['loja_origem' => $registro['loja_origem'], 'loja_destino' => $registro['loja_destino'], 'status' => $registro['status'],
            'transf' => $registro['transf'], 'recolhido' => $registro['recolhido'], 'entregue' => $registro['entregue'], 'cancelado' => $registro['cancelado'], 'aguardo' => $registro['aguardo']];

        return $this->Resultado;
    }

}
