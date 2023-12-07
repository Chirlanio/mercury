<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListProcessLibrary
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListProcessLibrary {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 100;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'process-library/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_process_librarys WHERE adms_sit_id =:adms_sit_id", "adms_sit_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listProcess = new \App\adms\Models\helper\AdmsRead();
        $listProcess->fullRead("SELECT a.id, a.title, a.adms_area_id, a.date_validation_start, a.date_validation_end, a.version_number, st.nome status, co.cor color, ar.name area, sec.sector_name FROM adms_process_librarys a INNER JOIN adms_sits st ON st.id=a.adms_sit_id INNER JOIN adms_cors co ON co.id=st.adms_cor_id INNER JOIN adms_areas ar ON ar.id=a.adms_area_id INNER JOIN adms_sectors sec ON sec.id=a.adms_sector_id WHERE a.adms_sit_id =:adms_sit_id ORDER BY a.id DESC LIMIT :limit OFFSET :offset", "adms_sit_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listProcess->getResultado();
        return $this->Resultado;
    }
    
    public function listAreas() {
        $listAreas = new \App\adms\Models\helper\AdmsRead();
        $listAreas->fullRead("SELECT * FROM adms_areas WHERE status_id =:status_id", "status_id=1");
        $register['areas'] = $listAreas->getResultado();
        
        $this->Resultado = $register['areas'];
        return $this->Resultado;
    }

}
