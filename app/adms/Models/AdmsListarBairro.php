<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarBairro {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarBairro($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'bairro/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_bairros");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCargo = new \App\adms\Models\helper\AdmsRead();
        $listarCargo->fullRead("SELECT b.id id_bai, b.nome bairro, r.nome rota
                FROM tb_bairros b
                INNER JOIN tb_rotas r ON r.id=b.rota_id
                ORDER BY b.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCargo->getResult();
        return $this->Resultado;
    }

}
