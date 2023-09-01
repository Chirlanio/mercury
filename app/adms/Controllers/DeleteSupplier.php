<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteSupplier
{

    private $DadosId;

    public function deleteSupplier($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $deleteSupplier = new \App\adms\Models\AdmsDeleteSupplier();
            $deleteSupplier->deleteSupplier($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um fornecedor!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'supplier/list';
        header("Location: $UrlDestino");
    }
}
