<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarRota {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarRota($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'rota/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_rotas");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        $listarCor->fullRead("SELECT r.id, r.nome, r.adms_cor_id, c.nome n_cor, c.cor
                FROM tb_rotas r
                INNER JOIN adms_cors c ON c.id=r.adms_cor_id
                ORDER BY id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
        return $this->Resultado;
    }

}
