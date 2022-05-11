<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarDefeitos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarDefeitos {

    private $Dados;

    public function cadDefeitos() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadDefeitos'])) {
            unset($this->Dados['CadDefeitos']);
            $cadDefeitos = new \App\adms\Models\AdmsCadastrarDefeitos();
            $cadDefeitos->cadDefeitos($this->Dados);
            if ($cadDefeitos->getResultado()) {
                $UrlDestino = URLADM . 'defeitos/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadDefeitosViewPriv();
            }
        } else {
            $this->cadDefeitosViewPriv();
        }
    }

    private function cadDefeitosViewPriv() {
        
        $botao = ['list_defeitos' => ['menu_controller' => 'defeitos', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSit = new \App\adms\Models\AdmsCadastrarDefeitos();
        $this->Dados['select'] = $listarSit->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/defeitos/cadDefeitos", $this->Dados);
        $carregarView->renderizar();
    }

}
