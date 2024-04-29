<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewVacancyOpening {

    private $Dados;
    private $DadosId;

    public function viewVacancy($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {

            $viewVacancy = new \App\adms\Models\AdmsViewVacancyOpening();
            $this->Dados['dados_vacancy'] = $viewVacancy->viewOrder($this->DadosId);

            $botao = ['list_vacancy' => ['menu_controller' => 'vacancy-opening', 'menu_metodo' => 'list'],
                'edit_vacancy' => ['menu_controller' => 'edit-vacancy-opening', 'menu_metodo' => 'edit-vacancy'],
                'del_vacancy' => ['menu_controller' => 'delete-vacancy-opening', 'menu_metodo' => 'delete-vacancy']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/vacancyOpening/viewVacancyOpening", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'vacancy-opening/list';
            header("Location: $UrlDestino");
        }
    }
}
