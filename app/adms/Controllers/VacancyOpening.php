<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VacancyOpening {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_vacancy' => ['menu_controller' => 'add-vacancy-opening', 'menu_metodo' => 'add-vacancy'],
            'spreadsheet' => ['menu_controller' => 'generate-excel-spreadsheet', 'menu_metodo' => 'generate-excel'],
            'view_vacancy' => ['menu_controller' => 'view-vacancy-opening', 'menu_metodo' => 'view-vacancy'],
            'edit_vacancy' => ['menu_controller' => 'edit-vacancy-opening', 'menu_metodo' => 'edit-vacancy'],
            'del_vacancy' => ['menu_controller' => 'delete-vacancy-opening', 'menu_metodo' => 'delete-vacancy']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listVacancy = new \App\adms\Models\AdmsListVacancyOpening();
        $this->Dados['list_vacancy'] = $listVacancy->list($this->PageId);
        $this->Dados['paginacao'] = $listVacancy->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/vacancyOpening/listVacancyOpening", $this->Dados);
        $carregarView->renderizar();
    }

}
