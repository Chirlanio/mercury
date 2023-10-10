<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteBanks
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteBanks {

    private $DadosId;

    public function deleteBank($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $deleteBank = new \App\adms\Models\AdmsDeleteBank();
            $deleteBank->deleteBank($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um fornecedor!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'banks/list';
        header("Location: $UrlDestino");
    }
}
