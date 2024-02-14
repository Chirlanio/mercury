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
    private $DadosId;

    /**
     * <b>View Order payment:</b> Receber o id da solicitação de movimentação de pessoal para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewMoviment($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewMoviment = new \App\adms\Models\helper\AdmsRead();
        $viewMoviment->fullRead("SELECT pm.*, l.nome store, fc.nome colaborador FROM adms_personnel_moviments pm
                LEFT JOIN tb_lojas l ON l.id = pm.adms_loja_id
                LEFT JOIN tb_funcionarios fc ON fc.id = pm.adms_employee_id
                WHERE pm.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewMoviment->getResultado();
        return $this->Resultado;
    }
}
