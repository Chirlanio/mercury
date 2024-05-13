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

    public function addRelocation() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['SendRelocation'])) {
            unset($this->Dados['SendRelocation']);

            $this->DataFile['data_file'] = ($_FILES['file_relocation'] ? $_FILES['file_relocation'] : null);
            $this->DataFile['data'] = $this->Dados;

            $addRelocation = new \App\adms\Models\AdmsAddRelocation();
            $addRelocation->addRelocation($this->DataFile);

            if ($addRelocation->getResultado()) {
                $UrlDestino = URLADM . 'relocation/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addRelocationViewPriv();
            }
        } else {
            $this->addRelocationViewPriv();
        }
    }

    private function addRelocationViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsAddRelocation();
        $this->Dados['select'] = $listarSelect->listAdd();

        $botao = ['list_relocation' => ['menu_controller' => 'relocation', 'menu_metodo' => 'list']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/relocation/addRelocation", $this->Dados);
        $carregarView->renderizar();
    }
}
