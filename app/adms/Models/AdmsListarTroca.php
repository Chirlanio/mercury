<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarTroca {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarTroca($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'listar-troca/listar-troca');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] >= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_troca ORDER BY id ASC");
        $registro['status_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id ref_id, nome ref FROM tb_cad_produtos ORDER BY id ASC");
        $registro['ref_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'status_id' => $registro['status_id'], 'ref_id' => $registro['ref_id']];

        return $this->Resultado;
    }

}
