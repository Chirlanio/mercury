<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteEcommerceOrder
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteEcommerceOrder
{

    private $DadosId;

    public function deleteOrder($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $delOrder = new \App\adms\Models\AdmsDeleteEcommerceOrder();
            $delOrder->deleteOrder($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar uma ordem de fatuamento!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'ecommerce/list';
        header("Location: $UrlDestino");
    }
}
