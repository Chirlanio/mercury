<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewProcessLibrary
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewProcessLibrary {

    private $Resultado;
    private $DadosId;
    private $ProcessId;

    /**
     * <b>View Order payment:</b> Receber o id do floxo de processo para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewProcess($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewProcess = new \App\adms\Models\helper\AdmsRead();
        $viewProcess->fullRead("SELECT p.id p_id, p.title, p.version_number, cp.name_category, ar.name area, ma.name manager_area, sec.sector_name, func.nome manager_sector, p.date_validation_start, p.date_validation_end, p.created, p.modified, sit.nome status, c.cor FROM adms_process_librarys p LEFT JOIN adms_cats_process_librarys cp ON cp.id = p.adms_cats_process_id LEFT JOIN adms_areas ar ON ar.id = p.adms_area_id LEFT JOIN adms_managers ma ON ma.id = p.adms_manager_area_id LEFT JOIN adms_sectors sec ON sec.id = p.adms_sector_id LEFT JOIN tb_funcionarios func ON func.id = p.adms_manager_sector_id LEFT JOIN adms_sits sit ON sit.id = p.adms_sit_id LEFT JOIN adms_cors c ON c.id = sit.adms_cor_id WHERE p.id =:id", "id=" . $this->DadosId);
        $this->Resultado = $viewProcess->getResult();
        return $this->Resultado;
    }

    public function listFiles($FileId) {
        $this->ProcessId = (int) $FileId;

        $fileProcess = new \App\adms\Models\helper\AdmsRead();
        $fileProcess->fullRead("SELECT id file_id, adms_process_library_id, exibition_name, file_name_slug, status_id FROM adms_process_library_files WHERE adms_process_library_id =:adms_process_library_id", "adms_process_library_id=" . $this->ProcessId);
        $this->Resultado = $fileProcess->getResult();
        return $this->Resultado;
    }
}
