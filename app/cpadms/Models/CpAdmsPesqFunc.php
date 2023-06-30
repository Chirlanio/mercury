<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqFunc {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['nome'] = trim($this->Dados['nome']);

        $_SESSION['nome'] = $this->Dados['nome'];
        $_SESSION['loja_id'] = $this->Dados['loja_id'];

        if ((!empty($this->Dados['nome'])) AND (!empty($this->Dados['loja_id']))) {
            $this->pesqFuncNomeLoja();
        } elseif (!empty($this->Dados['nome'])) {
            $this->pesqFuncNome();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqFuncLoja();
        }
        return $this->Resultado;
    }

    private function pesqFuncNomeLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-func/listar', '?nome=' . $this->Dados['nome'] . '&loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios WHERE nome LIKE '%' :nome '%' AND loja_id =:loja_id", "nome={$this->Dados['nome']}&loja_id={$this->Dados['loja_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarFunc = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['usuario_id'] == 1) {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit FROM tb_funcionarios f INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id WHERE f.nome LIKE '%' :nome '%' AND f.loja_id LIKE '%' :loja_id '%' ORDER BY id ASC LIMIT :limit OFFSET :offset", "nome={$this->Dados['nome']}&loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit FROM tb_funcionarios f INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id WHERE f.loja_id =:loja_id AND f.nome LIKE '%' :nome '%' ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&nome={$this->Dados['nome']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarFunc->getResultado();
    }

    private function pesqFuncNome() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-func/listar', '?nome=' . $this->Dados['nome']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios WHERE nome LIKE '%' :nome '%'", "nome={$this->Dados['nome']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios WHERE loja_id =:loja_id AND nome LIKE '%' :nome '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&nome={$this->Dados['nome']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarFunc = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['usuario_id'] == 1) {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit FROM tb_funcionarios f INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id WHERE f.nome LIKE '%' :nome '%' ORDER BY id ASC LIMIT :limit OFFSET :offset", "nome={$this->Dados['nome']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit FROM tb_funcionarios f INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id WHERE f.loja_id =:loja_id AND f.nome LIKE '%' :nome '%' ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&nome={$this->Dados['nome']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarFunc->getResultado();
    }

    private function pesqFuncLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-func/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios WHERE loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarFunc = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['usuario_id'] == 1) {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit FROM tb_funcionarios f INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id WHERE f.loja_id =:loja_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit FROM tb_funcionarios f INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id WHERE f.loja_id =:loja_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarFunc->getResultado();
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id']];

        return $this->Resultado;
    }

}
