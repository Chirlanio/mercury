<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarLojas
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class AdmsListarLojas {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoLj;

    function getResultadoLj() {
        return $this->ResultadoLj;
    }

    public function listarLojas($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'lojas/listar-lojas');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_lojas");
        $this->ResultadoLj = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        $listarAjuste->fullRead("SELECT lj.*, r.nome rede, st.nome status
                FROM tb_lojas lj
                INNER JOIN tb_status_loja st ON st.id=lj.status_id INNER JOIN tb_redes r ON r.id=lj.rede_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset", "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarAjuste->getResult();
        return $this->Resultado;
    }

}
