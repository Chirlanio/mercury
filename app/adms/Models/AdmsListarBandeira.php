<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarBandeira {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarBandeira($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'bandeira/listar-bandeira');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_bandeiras");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarBandeira = new \App\adms\Models\helper\AdmsRead();
        $listarBandeira->fullRead("SELECT b.id id_bai, b.nome bairro, icone
                FROM adms_bandeiras b
                ORDER BY b.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarBandeira->getResult();
        return $this->Resultado;
    }

}
