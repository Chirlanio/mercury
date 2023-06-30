<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Ajuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Ajuste
{

    private $Dados;
    private $PageId;

    public function listarAjuste($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = [
            'cad_ajuste' => ['menu_controller' => 'cadastrar-ajuste', 'menu_metodo' => 'cad-ajuste'],
            'vis_ajuste' => ['menu_controller' => 'ver-ajuste', 'menu_metodo' => 'ver-ajuste'],
            'edit_ajuste' => ['menu_controller' => 'editar-ajuste', 'menu_metodo' => 'edit-ajuste'],
            'del_ajuste' => ['menu_controller' => 'apagar-ajuste', 'menu_metodo' => 'apagar-ajuste']
        ];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarAjuste();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarAjuste = new \App\adms\Models\AdmsListarAjuste();
        $this->Dados['listAjuste'] = $listarAjuste->listarAjuste($this->PageId);
        $this->Dados['paginacao'] = $listarAjuste->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/ajuste/listarAjuste", $this->Dados);
        $carregarView->renderizar();
    }
}
