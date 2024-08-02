<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteCheckList {

    private string|null $DadosId;

    public function checkList(string|null $DadosId = null) {

        $this->DadosId = $DadosId;

        if (!empty($this->DadosId)) {
            $delCheckList = new \App\adms\Models\AdmsDeleteCheckList();
            $delCheckList->deleteCheckList($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um check list!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'check-list/list';
        header("Location: $UrlDestino");
    }
}
