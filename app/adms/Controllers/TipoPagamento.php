<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of TipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class TipoPagamento {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_pag' => ['menu_controller' => 'cadastrar-tipo-pagamento', 'menu_metodo' => 'cad-tipo'],
            'vis_pag' => ['menu_controller' => 'ver-tipo-pagamento', 'menu_metodo' => 'ver-tipo'],
            'edit_pag' => ['menu_controller' => 'editar-tipo-pagamento', 'menu_metodo' => 'edit-tipo'],
            'del_pag' => ['menu_controller' => 'apagar-tipo-pagamento', 'menu_metodo' => 'apagar-tipo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarTipo = new \App\adms\Models\AdmsListarTipoPagamento();
        $this->Dados['listTipo'] = $listarTipo->listarTipo($this->PageId);
        $this->Dados['paginacao'] = $listarTipo->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/tipoPag/listarTipoPagamento", $this->Dados);
        $carregarView->renderizar();
    }

}
