<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListBlog
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListBlog {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'policie-blog/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_policies WHERE adms_sit_id =:adms_sit_id", "adms_sit_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listPolicie = new \App\adms\Models\helper\AdmsRead();
        $listPolicie->fullRead("SELECT pl.*, st.nome status, co.cor color
                FROM adms_policies pl
                INNER JOIN adms_sits st ON st.id=pl.adms_sit_id
                INNER JOIN adms_cors co ON co.id=st.adms_cor_id
                WHERE pl.adms_sit_id =:adms_sit_id
                ORDER BY pl.id DESC LIMIT :limit OFFSET :offset", "adms_sit_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listPolicie->getResult();
        return $this->Resultado;
    }

    public function listPolicieRecente() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT id, title, slug, DATEDIFF(CURRENT_DATE(), dataInicial) AS dias FROM adms_policies ORDER BY id DESC LIMIT :limit', "limit=3");
        $this->Resultado = $listar->getResult();
        return $this->Resultado;
    }    

    public function listPolicieDestaque() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT id, title, slug FROM adms_policies WHERE destaque =:destaque ORDER BY id DESC LIMIT :limit', "destaque=1&limit=3");
        $this->Resultado = $listar->getResult();
        return $this->Resultado;
    }

}
