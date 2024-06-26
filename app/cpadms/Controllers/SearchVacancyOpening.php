<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SearchVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SearchVacancyOpening {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $botao = ['list_vacancy' => ['menu_controller' => 'vacancy-opening', 'menu_metodo' => 'list'],
            'add_vacancy' => ['menu_controller' => 'add-vacancy-opening', 'menu_metodo' => 'add-vacancy'],
            'view_vacancy' => ['menu_controller' => 'view-vacancy-opening', 'menu_metodo' => 'view-vacancy'],
            'edit_vacancy' => ['menu_controller' => 'edit-vacancy-opening', 'menu_metodo' => 'edit-vacancy'],
            'del_vacancy' => ['menu_controller' => 'delete-vacancy-opening', 'menu_metodo' => 'delete-vacancy']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->DadosForm['SearchVacancy'])) {
            unset($this->DadosForm['SearchVacancy']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        }

        $list = new \App\cpadms\Models\CpAdmsSearchVacancyOpening();
        $this->Dados['list_vacancy'] = $list->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $list->getResultado();

        $carregarView = new \Core\ConfigView("cpadms/Views/vacancyOpening/searchVacancyOpening", $this->Dados);
        $carregarView->renderizar();
    }

}
