<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewPolicies
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewPolicies {

    private $Dados;
    private $DadosId;

    public function viewPolicie($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $viewPolicie = new \App\adms\Models\AdmsViewPolicies();
            $this->Dados['dados_policies'] = $viewPolicie->viewPolicie($this->DadosId);

            $botao = ['list_policies' => ['menu_controller' => 'policies', 'menu_metodo' => 'list'],
                'edit_policies' => ['menu_controller' => 'edit-policies', 'menu_metodo' => 'edit-policie'],
                'del_policies' => ['menu_controller' => 'delete-policies', 'menu_metodo' => 'del-policie']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/policies/viewPolicies", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'policies/list';
            header("Location: $UrlDestino");
        }
    }

}
