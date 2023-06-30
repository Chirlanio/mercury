<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqTroca {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function pesqTroca($PageId = null) {

        $botao = ['list_troca' => ['menu_controller' => 'listar-troca', 'menu_metodo' => 'listar-troca'],
            'cad_troca' => ['menu_controller' => 'cadastrar-troca', 'menu_metodo' => 'cad-troca'],
            'vis_troca' => ['menu_controller' => 'ver-troca', 'menu_metodo' => 'ver-troca'],
            'edit_troca' => ['menu_controller' => 'editar-troca', 'menu_metodo' => 'edit-troca'],
            'del_troca' => ['menu_controller' => 'apagar-troca', 'menu_metodo' => 'apagar-troca']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqTroca();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqTroca'])) {
            unset($this->DadosForm['PesqTroca']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja', FILTER_DEFAULT);
            $this->DadosForm['status_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
            $this->DadosForm['referencia'] = filter_input(INPUT_GET, 'referencia', FILTER_DEFAULT);
        }

        $listarTroca = new \App\cpadms\Models\CpAdmsPesqTroca();
        $this->Dados['listTroca'] = $listarTroca->pesqTroca($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarTroca->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/troca/pesqTroca", $this->Dados);
        $carregarView->renderizar();
    }

}
