<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of TipoRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class TipoRemanejo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_tipo_remanejo' => ['menu_controller' => 'cadastrar-tipo-remanejo', 'menu_metodo' => 'cad-tipo-remanejo'],
            'vis_tipo_remanejo' => ['menu_controller' => 'ver-tipo-remanejo', 'menu_metodo' => 'ver-tipo-remanejo'],
            'edit_tipo_remanejo' => ['menu_controller' => 'editar-tipo-remanejo', 'menu_metodo' => 'edit-tipo-remanejo'],
            'del_tipo_remanejo' => ['menu_controller' => 'apagar-tipo-remanejo', 'menu_metodo' => 'apagar-tipo-remanejo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarTipoRemanejo = new \App\adms\Models\AdmsListarTipoRemanejo();
        $this->Dados['listTipoRemanejo'] = $listarTipoRemanejo->listar($this->PageId);
        $this->Dados['paginacao'] = $listarTipoRemanejo->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/tipoRemanejo/tipoRemanejo", $this->Dados);
        $carregarView->renderizar();
    }

}
