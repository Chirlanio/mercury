<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarBalanco {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarBalanco($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'auditoria/listar-balanco');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_aud_balancos");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_aud_balancos WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarBalanco = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarBalanco->fullRead("SELECT ba.*, lj.nome nome_loja, f.nome responsavel, r.nome aud_resp, st.nome status
                    FROM adms_aud_balancos ba
                    INNER JOIN tb_lojas lj ON lj.id=ba.loja_id
                    INNER JOIN tb_funcionarios f ON f.id=ba.resp_loja_id
                    INNER JOIN adms_aud_resp r ON r.id=ba.resp_auditor_id
                    INNER JOIN tb_status st ON st.id=ba.status_id
                    ORDER BY ba.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarBalanco->fullRead("SELECT ba.*, lj.nome nome_loja, f.nome responsavel, r.nome aud_resp, st.nome status
                    FROM adms_aud_balancos ba
                    INNER JOIN tb_lojas lj ON lj.id=ba.loja_id
                    INNER JOIN tb_funcionarios f ON f.id=ba.resp_loja_id
                    INNER JOIN adms_aud_resp r ON r.id=ba.resp_auditor_id
                    INNER JOIN tb_status st ON st.id=ba.status_id
                    WHERE ba.loja_id =:loja_id ORDER BY ba.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarBalanco->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
