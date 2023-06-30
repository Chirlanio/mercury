<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Defeitos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Defeitos {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_defeitos' => ['menu_controller' => 'cadastrar-defeitos', 'menu_metodo' => 'cad-defeitos'],
            'vis_defeitos' => ['menu_controller' => 'ver-defeitos', 'menu_metodo' => 'ver-defeitos'],
            'edit_defeitos' => ['menu_controller' => 'editar-defeitos', 'menu_metodo' => 'edit-defeitos'],
            'del_defeitos' => ['menu_controller' => 'apagar-defeitos', 'menu_metodo' => 'apagar-defeitos']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarDefeitos = new \App\adms\Models\AdmsListarDefeitos();
        $this->Dados['listDefeitos'] = $listarDefeitos->listarDefeitos($this->PageId);
        $this->Dados['paginacao'] = $listarDefeitos->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/defeitos/listarDefeitos", $this->Dados);
        $carregarView->renderizar();
    }

}
