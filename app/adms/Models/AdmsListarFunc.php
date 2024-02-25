<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarFunc {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarFunc($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'funcionarios/listarFunc');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= ADMPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios");
        } else if ($_SESSION['ordem_nivac'] == FINANCIALPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios WHERE status_id =:status_id", "status_id=1");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_funcionarios WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarFunc = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= ADMPERMITION) {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit
                    FROM tb_funcionarios f
                    INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id
                    ORDER BY id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else if ($_SESSION['adms_niveis_acesso_id'] == FINANCIALPERMITION) {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit
                    FROM tb_funcionarios f
                    INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id
                    WHERE f.status_id =:status_id
                    ORDER BY id ASC LIMIT :limit OFFSET :offset", "status_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarFunc->fullRead("SELECT f.*, l.nome loja, c.nome cargo, s.nome sit
                    FROM tb_funcionarios f
                    INNER JOIN tb_lojas l ON l.id=f.loja_id INNER JOIN tb_status s ON s.id=f.status_id INNER JOIN tb_cargos c ON c.id=f.cargo_id
                    WHERE loja_id =:loja_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarFunc->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja'] = $listar->getResultado();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResultado();

        $this->Resultado = ['loja' => $registro['loja'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }
}
