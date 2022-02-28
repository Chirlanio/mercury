<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqRemanejo {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_remanejo' => ['menu_controller' => 'remanejo', 'menu_metodo' => 'listar'],
            'cad_remanejo' => ['menu_controller' => 'cadastrar-remanejo', 'menu_metodo' => 'cad-remanejo'],
            'vis_remanejo' => ['menu_controller' => 'ver-remanejo', 'menu_metodo' => 'ver-remanejo'],
            'edit_remanejo' => ['menu_controller' => 'editar-remanejo', 'menu_metodo' => 'edit-remanejo'],
            'del_remanejo' => ['menu_controller' => 'apagar-remanejo', 'menu_metodo' => 'apagar-remanejo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqRemanejo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqRemanejo'])) {
            unset($this->DadosForm['PesqRemanejo']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_origem_id'] = filter_input(INPUT_GET, 'origem', FILTER_DEFAULT);
            $this->DadosForm['loja_destino_id'] = filter_input(INPUT_GET, 'destino', FILTER_DEFAULT);
            $this->DadosForm['adms_sit_rem_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
        }

        $listarRemanejo = new \App\cpadms\Models\CpAdmsPesqRemanejo();
        $this->Dados['listRemanejo'] = $listarRemanejo->pesqRemanejo($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarRemanejo->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/remanejo/pesqRemanejo", $this->Dados);
        $carregarView->renderizar();
    }

}
