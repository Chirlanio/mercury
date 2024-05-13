<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddRelocation
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddRelocation {

    private $Dados;
    private $DataFile;

    public function cadRemanejo() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['SendRelocation'])) {
            unset($this->Dados['SendRelocation']);
            
            $this->DataFile = ($_FILES['file_relocation'] ? $_FILES['file_relocation'] : null);
            
            $addRelocation = new \App\adms\Models\AdmsAddRelocation();
            $addRelocation->addRelocatio($this->Dados);
            
            if ($addRelocation->getResultado()) {
                $UrlDestino = URLADM . 'relocation/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadRemanejoViewPriv();
            }
        } else {
            $this->cadRemanejoViewPriv();
        }
    }

    private function cadRemanejoViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarRemanejo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_remanejo' => ['menu_controller' => 'remanejo', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/remanejo/cadRemanejo", $this->Dados);
        $carregarView->renderizar();
    }

}
