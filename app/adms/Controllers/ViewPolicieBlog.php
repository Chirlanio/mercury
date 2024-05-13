<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewPolicieBlog
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewPolicieBlog {

    private $Dados;
    private $Slug;

    public function index($Slug) {

        $this->Slug = (string) $Slug;

        if (!empty($this->Slug)) {

            $viewPolicie = new \App\adms\Models\AdmsViewPolicieBlog();
            $this->Dados['viewPolicie'] = $viewPolicie->viewPolicie($this->Slug);

            $recentes = new \App\adms\Models\AdmsPolicieBlogRecente();
            $this->Dados['artRecente'] = $recentes->listPolicieRecente();

            $destaques = new \App\adms\Models\AdmsPolicieDestaque();
            $this->Dados['artDestaque'] = $destaques->listPolicieDestaque();

            $botao = ['list_policies' => ['menu_controller' => 'policie-blog', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/policies/policies", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'policies-blog/list';
            header("Location: $UrlDestino");
        }
    }

}
