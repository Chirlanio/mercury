<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarDefeitoLocal {

    private $Dados;

    public function cadDefeitoLocal() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadDefLocal'])) {
            unset($this->Dados['CadDefLocal']);
            $cadDefLocal = new \App\adms\Models\AdmsCadastrarDefeitoLocal();
            $cadDefLocal->cadDefeitoLocal($this->Dados);
            if ($cadDefLocal->getResultado()) {
                $UrlDestino = URLADM . 'defeito-local/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadDefeitoLocalViewPriv();
            }
        } else {
            $this->cadDefeitoLocalViewPriv();
        }
    }

    private function cadDefeitoLocalViewPriv() {
        
        $botao = ['list_def_local' => ['menu_controller' => 'defeito-local', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSit = new \App\adms\Models\AdmsCadastrarDefeitoLocal();
        $this->Dados['select'] = $listarSit->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/defeitoLocal/cadDefLocal", $this->Dados);
        $carregarView->renderizar();
    }

}
