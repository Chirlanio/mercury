<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeletePolicies
 *
 * @copyright (c) year, Chirlanio Silvas - Grupo Meia Sola
 */
class DeletePolicies {

    private $DadosId;

    public function delPolicie($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $delPolicie = new \App\adms\Models\AdmsDeletePolicie();
            $delPolicie->delPolicie($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um registro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'policies/list';
        header("Location: $UrlDestino");
    }
}
