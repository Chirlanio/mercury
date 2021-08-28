<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of LibMenu
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class LibMenu
{

    private $DadosId;
    private $NivId;
    private $PageId;

    public function libMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->NivId = filter_input(INPUT_GET, "niv", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId) AND ! empty($this->NivId) AND ! empty($this->PageId)) {
            $libMenu = new \App\adms\Models\AdmsLibMenu();
            $libMenu->libMenu($this->DadosId);
            $UrlDestino = URLADM . "permissoes/listar/{$this->PageId}?niv={$this->NivId}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}
