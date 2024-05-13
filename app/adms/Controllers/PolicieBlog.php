<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Blog
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PolicieBlog {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_policies' => ['menu_controller' => 'add-policies', 'menu_metodo' => 'add-policie'],
            'view_policies' => ['menu_controller' => 'view-policies', 'menu_metodo' => 'view-policie'],
            'edit_policies' => ['menu_controller' => 'editar-policies', 'menu_metodo' => 'edit-policie'],
            'del_policies' => ['menu_controller' => 'delete-policies', 'menu_metodo' => 'del-policie']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listPolicies = new \App\adms\Models\AdmsListBlog();
        $this->Dados['listPolicies'] = $listPolicies->list($this->PageId);
        $this->Dados['paginacao'] = $listPolicies->getResultadoPg();

        $listPoliciesRecente = new \App\adms\Models\AdmsListBlog();
        $this->Dados['artRecente'] = $listPoliciesRecente->listPolicieRecente();
        
        $listPoliciesDestaque = new \App\adms\Models\AdmsListBlog();
        $this->Dados['artDestaque'] = $listPoliciesDestaque->listPolicieDestaque();

        $carregarView = new \Core\ConfigView("adms/Views/policies/policieBlog", $this->Dados);
        $carregarView->renderizar();
    }

}
