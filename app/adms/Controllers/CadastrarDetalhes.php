<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarDetalhes {

    private $Dados;

    public function cadDetalhes() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadDetalhes'])) {
            unset($this->Dados['CadDetalhes']);
            $cadDetalhes = new \App\adms\Models\AdmsCadastrarDetalhes();
            $cadDetalhes->cadDetalhes($this->Dados);
            if ($cadDetalhes->getResultado()) {
                $UrlDestino = URLADM . 'detalhes/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadDetalhesViewPriv();
            }
        } else {
            $this->cadDetalhesViewPriv();
        }
    }

    private function cadDetalhesViewPriv() {
        
        $botao = ['list_detalhes' => ['menu_controller' => 'detalhes', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSit = new \App\adms\Models\AdmsCadastrarDetalhes();
        $this->Dados['select'] = $listarSit->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/detalhes/cadDetalhes", $this->Dados);
        $carregarView->renderizar();
    }

}
