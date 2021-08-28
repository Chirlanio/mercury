<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarArq
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarArq {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'listar-arquivo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_up_down WHERE status_id =:status_id", "status_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarArtigo = new \App\adms\Models\helper\AdmsRead();
        $listarArtigo->fullRead("SELECT a.*, st.nome status FROM adms_up_down a INNER JOIN tb_status st ON st.id=a.status_id WHERE a.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarArtigo->getResultado();
        return $this->Resultado;
    }

}
