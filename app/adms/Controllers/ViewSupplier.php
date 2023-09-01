<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewSupplier {

    private $Dados;
    private $DadosId;

    public function viewSupplier($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSupplier = new \App\adms\Models\AdmsViewSupplier();
            $this->Dados['data_supplier'] = $verSupplier->viewSupplier($this->DadosId);

            $botao = ['list_supplier' => ['menu_controller' => 'supplier', 'menu_metodo' => 'list'],
                'edit_supplier' => ['menu_controller' => 'edit-supplier', 'menu_metodo' => 'edit-supplier'],
                'del_supplier' => ['menu_controller' => 'delete-supplier', 'menu_metodo' => 'delete-supplier']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/supplier/viewSupplier", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Fornecedor não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'supplier/list';
            header("Location: $UrlDestino");
        }
    }

}
