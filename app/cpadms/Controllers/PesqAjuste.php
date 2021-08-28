<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqAjuste {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_ajuste' => ['menu_controller' => 'ajuste', 'menu_metodo' => 'listar-ajuste'],
            'cad_ajuste' => ['menu_controller' => 'cadastrar-ajuste', 'menu_metodo' => 'cad-ajuste'],
            'vis_ajuste' => ['menu_controller' => 'ver-ajuste', 'menu_metodo' => 'ver-ajuste'],
            'edit_ajuste' => ['menu_controller' => 'editar-ajuste', 'menu_metodo' => 'edit-ajuste'],
            'del_ajuste' => ['menu_controller' => 'apagar-ajuste', 'menu_metodo' => 'apagar-ajuste']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqAjuste();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqAjuste'])) {
            unset($this->DadosForm['PesqAjuste']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja', FILTER_DEFAULT);
            $this->DadosForm['referencia'] = filter_input(INPUT_GET, 'referencia', FILTER_DEFAULT);
            $this->DadosForm['status_aj_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
        }

        $listarPagina = new \App\cpadms\Models\CpAdmsPesqAjuste();
        $this->Dados['listAjuste'] = $listarPagina->listar($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarPagina->getResultadoAj();

        $carregarView = new \Core\ConfigView("cpadms/Views/ajuste/pesqAjuste", $this->Dados);
        $carregarView->renderizar();
    }

}
