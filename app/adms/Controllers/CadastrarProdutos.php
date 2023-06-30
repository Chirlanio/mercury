<?php

namespace App\sts\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AjusteEstoque
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarProdutos {

    private $Dados;

    public function index() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //echo "<br><br><br>";
        //var_dump($this->Dados);        
        $listarMenu = new \Sts\Models\StsMenu();
        $this->Dados['menu']=$listarMenu->listarMenu();
        
        $listarSeo = new \Sts\Models\StsSeo();
        $this->Dados['seo']=$listarSeo->listarSeo();
        
        if (!empty($this->Dados['CadProduto'])) {
            unset($this->Dados['CadProduto']);
            $cadProduto = new \Sts\Models\StsCadastrarProdutos();
            $cadProduto->cadProduto($this->Dados);
            if ($cadProduto->getResultado()) {
                $this->Dados['form'] = null;
            } else {
                $this->Dados['form'] = $this->Dados;
            }  
        }
        
        $carregarView = new \Core\ConfigView('sts/Views/cadastrar_produtos/cadastrar_produtos', $this->Dados);
        $carregarView->renderizar();
    }

}
