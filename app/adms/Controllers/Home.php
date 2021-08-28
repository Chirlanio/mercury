<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Home
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Home {

    private $Dados;

    public function index() {

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $contAjuste = new \App\adms\Models\AdmsHome();
        $this->Dados['select'] = $contAjuste->listarCadastrar();
        
        //var_dump($this->Dados['contAjuste']);
        $carregarView = new \Core\ConfigView("adms/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}
