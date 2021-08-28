<?php

namespace App\sts\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ListarCadProdutos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ListarCadProdutos {

    private $Dados;

    public function index() {

        $listarMenu = new \Sts\Models\StsMenu();
        $this->Dados['menu']=$listarMenu->listarMenu();
        
        $listarSeo = new \Sts\Models\StsSeo();
        $this->Dados['seo']=$listarSeo->listarSeo();
        
        $listar_cad_prod = new \Sts\Models\StsListarCadProdutos();
        $this->Dados['tb_cad_produtos'] = $listar_cad_prod->listar();

        $carregarView = new \Core\ConfigView("sts/Views/listar_cad_produtos/listar_cad_produtos", $this->Dados);
        $carregarView->renderizar();
    }

}