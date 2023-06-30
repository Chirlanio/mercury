<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of HomeTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class HomeTreinamento {

    private $Dados;

    public function index() {

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $contVideo = new \App\adms\Models\AdmsHomeTreinamento();
        $this->Dados['select'] = $contVideo->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/homeTreinamento/home", $this->Dados);
        $carregarView->renderizar();
    }

}
