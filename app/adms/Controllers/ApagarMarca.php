<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarMarca
{

    private $DadosId;

    public function apagarMarca($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarMarca = new \App\adms\Models\AdmsApagarMarca();
            $apagarMarca->apagarMarca($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma marca!</div>";
        }
        $UrlDestino = URLADM . 'marcas/listar';
        header("Location: $UrlDestino");
    }
}
