<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewPersonnelMoviments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewPersonnelMoviments {

    private $Resultado;
    private int $DadosId;

    /**
     * <b>View Order payment:</b> Receber o id da solicitação de movimentação de pessoal para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewMoviment(int $DadosId) {
        $this->DadosId = $DadosId;
        $viewMoviment = new \App\adms\Models\helper\AdmsRead();
        $viewMoviment->fullRead("SELECT pm.*, l.nome store, fc.nome colaborador, ar.id a_id, ar.name area, fm.nome manager_sector, mg.board_name, sm.name status, cr.cor, user.nome updated_by, df.uniform, df.phone_chip, df.original_card, df.signature_date_trct, df.aso, df.aso_resigns, df.send_aso_guide, car.nome office_name FROM adms_personnel_moviments pm LEFT JOIN tb_lojas l ON l.id = pm.adms_loja_id LEFT JOIN tb_funcionarios fc ON fc.id = pm.adms_employee_id LEFT JOIN adms_areas ar ON ar.id = pm.request_area_id LEFT JOIN tb_funcionarios fm ON fm.id = pm.requester_id LEFT JOIN adms_boards mg ON mg.id = pm.board_id LEFT JOIN adms_sits_personnel_moviments sm ON sm.id = pm.adms_sits_personnel_mov_id LEFT JOIN adms_cors cr ON cr.id = sm.adms_cor_id LEFT JOIN adms_usuarios user ON user.id = pm.updated_by LEFT JOIN adms_dismissal_follow_up df ON df.adms_person_mov_id = pm.id LEFT JOIN tb_cargos car ON car.id = fc.cargo_id WHERE pm.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Resultado = $viewMoviment->getResult();
        return $this->Resultado;
    }
    
    public function addList(int $DataId) {
        $this->DadosId = $DataId;
        
        $reasons = new \App\adms\Models\helper\AdmsRead();
        $reasons->fullRead("SELECT rpm.id rp_id, rpm.adms_personnel_mov_id, rpm.adms_reason_dism_id, rfd.reason question_reason, rfd.order_reason FROM adms_reasons_personnel_moviments rpm LEFT JOIN adms_reasons_for_dismissals rfd ON rfd.id = rpm.adms_reason_dism_id WHERE adms_personnel_mov_id =:mov", "mov={$this->DadosId}");
        $this->Resultado = $reasons->getResult();
        
        return $this->Resultado;
    }
}
