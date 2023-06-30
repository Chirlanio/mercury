<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarDelivery
{

    private $DadosId;

    public function apagarDelivery($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarDelivery = new \App\adms\Models\AdmsApagarDelivery();
            $apagarDelivery->apagarDelivery($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um Pedido de Entrega!</div>";
        }
        $UrlDestino = URLADM . 'delivery/listar';
        header("Location: $UrlDestino");
    }
}
