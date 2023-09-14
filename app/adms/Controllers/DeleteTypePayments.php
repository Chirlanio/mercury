<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteTypePayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteTypePayments {

    private $DadosId;

    public function typePayment($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $delType = new \App\adms\Models\AdmsDeleteTypePayment();
            $delType->delType($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum tipo de pagameto encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'type-payments/list';
        header("Location: $UrlDestino");
    }

}
