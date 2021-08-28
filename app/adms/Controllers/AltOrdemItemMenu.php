<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AltOrdemItemMenu
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AltOrdemItemMenu
{

    private $DadosId;

    public function altOrdemItemMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemMenu = new \App\adms\Models\AdmsAltOrdemItemMenu();
           $altOrdemMenu->altOrdemMenu($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um item de menu!</div>";
        }
        $UrlDestino = URLADM . 'menu/listar';
        header("Location: $UrlDestino");
    }

}
