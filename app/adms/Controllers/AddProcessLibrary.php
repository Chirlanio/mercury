<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddProcessLibrary
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddProcessLibrary {

    private $Dados;

    public function addProcess() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddProcess'])) {
            unset($this->Dados['AddProcess']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $addProcess = new \App\adms\Models\AdmsAddProcessLibrary();
            $addProcess->addProcess($this->Dados);
            //var_dump($this->Dados);
            if ($addProcess->getResultado()) {
                $UrlDestino = URLADM . 'process-library/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addProcessViewPriv();
            }
        } else {
            $this->addProcessViewPriv();
        }
    }

    private function addProcessViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsAddProcessLibrary();
        $this->Dados['select'] = $listarSelect->listAdd();

        $botao = ['list_process' => ['menu_controller' => 'process-library', 'menu_metodo' => 'list'],
            'view_process' => ['menu_controller' => 'view-process', 'menu_metodo' => 'view-process']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/biblioteca/addProcessLibrary", $this->Dados);
        $carregarView->renderizar();
    }

}
