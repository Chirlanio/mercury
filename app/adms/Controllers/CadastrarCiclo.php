<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarCiclo {

    private $Dados;

    public function cadCiclo() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadCiclo'])) {
            unset($this->Dados['CadCiclo']);
            $cadCiclo = new \App\adms\Models\AdmsCadastrarCiclo();
            $cadCiclo->cadCiclo($this->Dados);
            if ($cadCiclo->getResultado()) {
                $UrlDestino = URLADM . 'ciclos/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCicloViewPriv();
            }
        } else {
            $this->cadCicloViewPriv();
        }
    }

    private function cadCicloViewPriv() {
        
        $botao = ['list_ciclo' => ['menu_controller' => 'ciclos', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/ciclo/cadCiclo", $this->Dados);
        $carregarView->renderizar();
    }

}
