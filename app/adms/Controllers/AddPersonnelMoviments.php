<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddPersonnelMoviments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddPersonnelMoviments {

    private $Dados;

    public function addMoviment() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddMoviment'])) {
            unset($this->Dados['AddMoviment']);

            $this->Dados['file_name'] = (isset($_FILES['file_name']) ? $_FILES['file_name'] : null);
            $addMoviment = new \App\adms\Models\AdmsAddPersonnelMoviments();
            $addMoviment->addMoviment($this->Dados);

            if ($addMoviment->getResultado()) {
                $UrlDestino = URLADM . 'personnel-moviments/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addPersonnelMovimentViewPriv();
            }
        } else {
            $this->addPersonnelMovimentViewPriv();
        }
    }

    private function addPersonnelMovimentViewPriv() {

        $listSelect = new \App\adms\Models\AdmsAddPersonnelMoviments();
        $this->Dados['select'] = $listSelect->listAdd();

        $botao = ['list_moviment' => ['menu_controller' => 'personnel-moviments', 'menu_metodo' => 'list'],
            'add_moviment' => ['menu_controller' => 'add-personnel-moviments', 'menu_metodo' => 'add-moviment'],
            'view_moviment' => ['menu_controller' => 'view-personnel-moviments', 'menu_metodo' => 'view-moviment'],
            'edit_moviment' => ['menu_controller' => 'edit-personnel-moviments', 'menu_metodo' => 'edit-moviment'],
            'del_moviment' => ['menu_controller' => 'delete-personnel-moviments', 'menu_metodo' => 'delete-moviment']];

        $listBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listBotao->valBotao($botao);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/personnelMoviment/addPersonnelMoviment", $this->Dados);
        $carregarView->renderizar();
    }
}
