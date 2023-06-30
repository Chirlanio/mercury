<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Faq
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Faq {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_faq' => ['menu_controller' => 'cadastrar-faq', 'menu_metodo' => 'cad-faq'],
            'vis_faq' => ['menu_controller' => 'ver-faq', 'menu_metodo' => 'ver-faq'],
            'edit_faq' => ['menu_controller' => 'editar-faq', 'menu_metodo' => 'edit-faq'],
            'del_faq' => ['menu_controller' => 'apagar-faq', 'menu_metodo' => 'apagar-faq']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarFac = new \App\adms\Models\AdmsListarFaq();
        $this->Dados['listFaq'] = $listarFac->listar($this->PageId);
        $this->Dados['paginacao'] = $listarFac->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/faq/listarFaq", $this->Dados);
        $carregarView->renderizar();
    }

}
