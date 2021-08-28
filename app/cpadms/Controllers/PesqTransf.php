<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqTransf {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_transf' => ['menu_controller' => 'transferencia', 'menu_metodo' => 'listar-transf'],
            'cad_transf' => ['menu_controller' => 'cadastrar-transf', 'menu_metodo' => 'cad-transf'],
            'vis_transf' => ['menu_controller' => 'ver-transf', 'menu_metodo' => 'ver-transf'],
            'edit_transf' => ['menu_controller' => 'editar-transf', 'menu_metodo' => 'edit-transf'],
            'del_transf' => ['menu_controller' => 'apagar-transf', 'menu_metodo' => 'apagar-transf']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqTransf();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqTransf'])) {
            unset($this->DadosForm['PesqTransf']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_origem_id'] = filter_input(INPUT_GET, 'origem', FILTER_DEFAULT);
            $this->DadosForm['loja_destino_id'] = filter_input(INPUT_GET, 'destino', FILTER_DEFAULT);
            $this->DadosForm['status_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
        }

        $listarTransf = new \App\cpadms\Models\CpAdmsPesqTransf();
        $this->Dados['listTransf'] = $listarTransf->pesqTransf($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarTransf->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/transferencia/pesqTransf", $this->Dados);
        $carregarView->renderizar();
    }

}
