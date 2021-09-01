<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Estoque
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Estoque {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqEstoque();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
        
        $listarEstoque = new \App\adms\Models\AdmsListarEstoque();
        $this->Dados['listEstoque'] = $listarEstoque->listar($this->PageId);
        $this->Dados['paginacao'] = $listarEstoque->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/estoque/listar", $this->Dados);
        $carregarView->renderizar();
    }

}
