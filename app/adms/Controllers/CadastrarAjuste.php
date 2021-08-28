<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarAjuste
{

    private $Dados;

    public function cadAjuste()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadAjuste'])) {
            unset($this->Dados['CadAjuste']);
            $cadAjuste = new \App\adms\Models\AdmsCadastrarAjuste();
            $cadAjuste->cadAjuste($this->Dados);
            if ($cadAjuste->getResultado()) {
                $UrlDestino = URLADM . 'ajuste/listarAjuste';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadAjusteViewPriv();
            }
        } else {
            $this->cadAjusteViewPriv();
        }
    }

    private function cadAjusteViewPriv()
    {
        $listarSelect = new \App\adms\Models\AdmsCadastrarAjuste();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_ajuste' => ['menu_controller' => 'ajuste', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/ajuste/cadAjuste", $this->Dados);
        $carregarView->renderizar();
    }

}
