<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of GenteGestao
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class GenteGestao {

    private $Dados;

    public function listar() {

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/gestao/genteGestao", $this->Dados);
        $carregarView->renderizar();
    }

}
