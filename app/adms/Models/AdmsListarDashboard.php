<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarDashboard {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarDashboard($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'dashboard/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_dashboards");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_dashboards WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarCor->fullRead("SELECT *
                    FROM tb_dashboards
                    ORDER BY id ASC LIMIT :limit OFFSET :offset",
                    "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarCor->fullRead("SELECT *
                    FROM tb_dashboards
                    WHERE loja_id =:loja_id
                    ORDER BY id ASC LIMIT :limit OFFSET :offset",
                    "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarCor->getResultado();
        return $this->Resultado;
    }

}
