<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarMarca {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarMarca($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'marca/listar-marca');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_marcas");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_marcas WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listarAjuste->fullRead("SELECT m.*, s.nome status FROM adms_marcas m INNER JOIN tb_status s ON s.id=m.status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT m.*, s.nome status FROM adms_marcas m INNER JOIN tb_status s ON s.id=m.status_id WHERE loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResult();
        return $this->Resultado;
    }

}
