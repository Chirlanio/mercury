<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqUsuariosTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqUsuariosTreinamento {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_usuario' => ['menu_controller' => 'usuarios-treinamento', 'menu_metodo' => 'listar'],
            'cad_usuario' => ['menu_controller' => 'cadastrar-usuario-treinamento', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario-treinamento', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario-treinamento', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario-treinamento', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqUsuario'])) {
            unset($this->DadosForm['PesqUsuario']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['nome'] = filter_input(INPUT_GET, 'nome', FILTER_DEFAULT);
        }

        $pesqUsario = new \App\cpadms\Models\CpAdmsPesqUsuarioTreinamento();
        $this->Dados['listUser'] = $pesqUsario->pesqUsuario($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $pesqUsario->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/usuarioTreinamento/pesqUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}
