<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarArtigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarArtigo {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'artigo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_sit_id =:adms_sit_id", "adms_sit_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarArtigo = new \App\adms\Models\helper\AdmsRead();
        $listarArtigo->fullRead("SELECT a.*, st.nome status, co.cor color, ta.nome tipo, c.nome cat FROM adms_artigos a INNER JOIN adms_sits st ON st.id=a.adms_sit_id INNER JOIN adms_cors co ON co.id=st.adms_cor_id INNER JOIN adms_tps_artigos ta ON ta.id=a.adms_tps_artigo_id INNER JOIN adms_cats_artigos c ON c.id=a.adms_cats_artigo_id WHERE a.adms_sit_id =:adms_sit_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "adms_sit_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarArtigo->getResultado();
        return $this->Resultado;
    }

}
