<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteCostCenter {

    private $DadosId;

    public function costCenter($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $delCostCenter = new \App\adms\Models\AdmsDelCostCenter();
            $delCostCenter->delCostCenter($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Selecione um centro de custos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'cost-centers/list';
        header("Location: $UrlDestino");
    }
}
