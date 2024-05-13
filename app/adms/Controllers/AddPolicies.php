<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarArtigo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddPolicies {

    private $Dados;

    public function addPolicie() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddPolicies'])) {
            unset($this->Dados['AddPolicies']);
            
            $this->Dados['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $this->Dados['file_name'] = ($_FILES['file_name'] ? $_FILES['file_name'] : null);
            $addPolicies = new \App\adms\Models\AdmsAddPolicies();
            $addPolicies->addPolicie($this->Dados);
            if ($addPolicies->getResultado()) {
                $UrlDestino = URLADM . 'policies/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addPolicieViewPriv();
            }
        } else {
            $this->addPolicieViewPriv();
        }
    }

    private function addPolicieViewPriv() {

        $listSelect = new \App\adms\Models\AdmsAddPolicies();
        $this->Dados['select'] = $listSelect->listAdd();

        $botao = ['list_policies' => ['menu_controller' => 'policies', 'menu_metodo' => 'list'],
            'view_policies' => ['menu_controller' => 'view-policies', 'menu_metodo' => 'view-policie']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/policies/addPolicies", $this->Dados);
        $carregarView->renderizar();
    }

}
