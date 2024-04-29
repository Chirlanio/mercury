<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddVacancyOpening {

    private $Dados;

    public function addVacancy() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['AddVacancy'])) {
            unset($this->Dados['AddVacancy']);
            $addVacancy = new \App\adms\Models\AdmsAddVacancyOpening();
            $addVacancy->addVacancy($this->Dados);
            if ($addVacancy->getResultado()) {
                $UrlDestino = URLADM . 'vacancy-opening/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addVacancyOpeningViewPriv();
            }
        } else {
            $this->addVacancyOpeningViewPriv();
        }
    }

    private function addVacancyOpeningViewPriv() {
        
        $botao = ['list_vacancy' => ['menu_controller' => 'vacancy-opening', 'menu_metodo' => 'list']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsAddVacancyOpening();
        $this->Dados['select']=$listarSelect->listAdd();
        
        $carregarView = new \Core\ConfigView("adms/Views/vacancyOpening/addVacancyOpening", $this->Dados);
        $carregarView->renderizar();
    }

}
