<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteBrands
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteBrands {

    private $DadosId;

    public function deleteBrand($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $deleteBrand = new \App\adms\Models\AdmsDeleteBrand();
            $deleteBrand->deleteBrand($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um fornecedor!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'brands/list';
        header("Location: $UrlDestino");
    }
}
