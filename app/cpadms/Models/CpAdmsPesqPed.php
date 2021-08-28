<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqPed
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqPed {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqPed($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $this->Dados['referencia'] = trim($this->Dados['referencia']);

        $_SESSION['pesqLoja'] = $this->Dados['loja_id'];
        $_SESSION['pesqRef'] = $this->Dados['referencia'];
        $_SESSION['pesqSit'] = $this->Dados['status_id'];

        if (!empty($this->Dados['loja_id']) AND!empty($this->Dados['referencia']) AND!empty($this->Dados['status_id'])) {
            $this->pesqComp();
        } elseif (!empty($this->Dados['loja_id']) AND!empty($this->Dados['referencia'])) {
            $this->pesqLojaRef();
        } elseif (!empty($this->Dados['loja_id']) AND!empty($this->Dados['status_id'])) {
            $this->pesqLojaSit();
        } elseif (!empty($this->Dados['referencia']) AND!empty($this->Dados['status_id'])) {
            $this->pesqRefSit();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['referencia'])) {
            $this->pesqRef();
        } elseif (!empty($this->Dados['status_id'])) {
            $this->pesqSit();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?loja=' . $this->Dados['loja_id'] . '&referencia=' . $this->Dados['referencia'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%' AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.loja_id =:loja_id AND p.referencia LIKE '%' :referencia '%' AND p.status_id =:status_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    private function pesqLojaRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?loja=' . $this->Dados['loja_id'] . '&referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.loja_id =:loja_id AND p.referencia LIKE '%' :referencia '%'
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    private function pesqLojaSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.loja_id =:loja_id AND p.status_id =:status_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    private function pesqRefSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?referencia=' . $this->Dados['referencia'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE referencia LIKE '%' :referencia '%' AND status_id =:status_id", "referencia={$this->Dados['referencia']}&status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.referencia LIKE '%' :referencia '%' AND p.status_id =:status_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "referencia={$this->Dados['referencia']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.loja_id =:loja_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    private function pesqRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE referencia LIKE '%' :referencia '%'", "referencia={$this->Dados['referencia']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.referencia LIKE '%' :referencia '%'
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    private function pesqSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-prateleira/listar', '?situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE status_id =:status_id", "status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT p.*,
                t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                INNER JOIN adms_cors c ON c.id=tr.cor_id
                WHERE p.status_id =:status_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset",
                "status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_prat ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja' => $registro['loja'], 'sit' => $registro['sit']];
        return $this->Resultado;
    }

}
