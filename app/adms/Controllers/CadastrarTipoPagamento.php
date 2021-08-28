<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarTipoPagamento {

    private $Dados;

    public function cadTipo() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadTipo'])) {
            unset($this->Dados['CadTipo']);
            $cadTipo = new \App\adms\Models\AdmsCadastrarTipoPagamento();
            $cadTipo->cadTipo($this->Dados);
            if ($cadTipo->getResultado()) {
                $UrlDestino = URLADM . 'tipo-pagamento/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTipoPagViewPriv();
            }
        } else {
            $this->cadTipoPagViewPriv();
        }
    }

    private function cadTipoPagViewPriv() {
        
        $botao = ['list_pag' => ['menu_controller' => 'tipo-pagamento', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/tipoPag/cadTipoPagamento", $this->Dados);
        $carregarView->renderizar();
    }

}
