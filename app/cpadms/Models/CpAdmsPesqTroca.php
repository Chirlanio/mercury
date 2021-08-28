<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqTroca {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqTroca($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $_SESSION['pesqLoja'] = $this->Dados['loja_id'];
        $_SESSION['pesqSit'] = $this->Dados['status_id'];
        $_SESSION['pesqRef'] = $this->Dados['referencia'];

        $this->Dados['loja_id'] = trim($this->Dados['loja_id']);
        $this->Dados['status_id'] = trim($this->Dados['status_id']);
        $this->Dados['referencia'] = trim($this->Dados['referencia']);

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['status_id'])) AND (!empty($this->Dados['referencia']))) {
            $this->pesqComp();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['status_id']))) {
            $this->pesqLojaSit();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['referencia']))) {
            $this->pesqLojaRef();
        } elseif ((!empty($this->Dados['status_id'])) AND (!empty($this->Dados['referencia']))) {
            $this->pesqSitRef();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['status_id'])) {
            $this->pesqSit();
        } elseif (!empty($this->Dados['referencia'])) {
            $this->pesqRef();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['status_id'] . '&referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND status_id =:status_id AND referencia LIKE '%' :referencia '%'", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND status_id =:status_id AND referencia LIKE '%' :referencia '%'", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.status_id =:status_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.status_id =:status_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
    }

    private function pesqLojaSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
    }

    private function pesqLojaRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?loja=' . $this->Dados['loja_id'] . '&referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
    }

    private function pesqSitRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?situacao=' . $this->Dados['status_id'] . '&referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND status_id =:status_id AND referencia LIKE '%' :referencia '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE status_id =:status_id AND referencia LIKE '%' :referencia '%'", "status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.status_id =:status_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.status_id =:status_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['status_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
    }

    private function pesqSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND status_id =:status_id '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE status_id =:status_id", "status_id={$this->Dados['status_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
    }

    private function pesqRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-troca/pesq-troca', '?referencia=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_cad_produtos WHERE referencia LIKE '%' :referencia '%'", "referencia={$this->Dados['referencia']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= 5) {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.loja_id =:loja_id AND t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTroca->fullRead("SELECT t.*, lj.nome nome_loja, st.nome status, f.nome func, st.adms_cor_id, c.cor cor_cr FROM tb_cad_produtos t INNER JOIN tb_lojas lj ON lj.id=t.loja_id INNER JOIN tb_status_troca st ON st.id=t.status_id INNER JOIN tb_funcionarios f ON f.id=t.func_id INNER JOIN adms_cors c on c.id=st.adms_cor_id AND st.id=t.status_id WHERE t.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTroca->getResultado();
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

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'status_id' => $registro['status_id']];

        return $this->Resultado;
    }

}
