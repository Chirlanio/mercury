<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarMenu
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarMenu
{

    private $DadosId;

    public function apagarMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarMenu = new \App\adms\Models\AdmsApagarMenu();
            $apagarMenu->apagarMenu($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um item de menu!</div>";
        }
        $UrlDestino = URLADM . 'menu/listar';
        header("Location: $UrlDestino");
    }
}
