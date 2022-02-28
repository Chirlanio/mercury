<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarTipoRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarTipoRemanejo {

    private $Dados;

    public function cadTipoRemanejo() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadTipoRemanejo'])) {
            unset($this->Dados['CadTipoRemanejo']);
            $cadTipoRemanejo = new \App\adms\Models\AdmsCadastrarTipoRemanejo();
            $cadTipoRemanejo->cadTipoRemanejo($this->Dados);
            if ($cadTipoRemanejo->getResultado()) {
                $UrlDestino = URLADM . 'tipo-remanejo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTipoRemViewPriv();
            }
        } else {
            $this->cadTipoRemViewPriv();
        }
    }

    private function cadTipoRemViewPriv() {
        
        $botao = ['list_tipo_remanejo' => ['menu_controller' => 'tipo-remanejo', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/tipoRemanejo/cadTipoRemanejo", $this->Dados);
        $carregarView->renderizar();
    }

}
