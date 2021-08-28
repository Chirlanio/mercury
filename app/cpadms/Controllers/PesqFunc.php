<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PescFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqFunc {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_func' => ['menu_controller' => 'funcionarios', 'menu_metodo' => 'listar-func'],
            'cad_func' => ['menu_controller' => 'cadastrar-func', 'menu_metodo' => 'cad-func'],
            'vis_func' => ['menu_controller' => 'ver-func', 'menu_metodo' => 'ver-func'],
            'edit_func' => ['menu_controller' => 'editar-func', 'menu_metodo' => 'edit-func'],
            'del_func' => ['menu_controller' => 'apagar-func', 'menu_metodo' => 'apagar-func']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqFunc();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqFunc'])) {
            unset($this->DadosForm['PesqFunc']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['nome'] = filter_input(INPUT_GET, 'nome', FILTER_DEFAULT);
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja', FILTER_DEFAULT);
        }

        $listarFunc = new \App\cpadms\Models\CpAdmsPesqFunc();
        $this->Dados['listFunc'] = $listarFunc->listar($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarFunc->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/funcionarios/pesqFunc", $this->Dados);
        $carregarView->renderizar();
    }

}
