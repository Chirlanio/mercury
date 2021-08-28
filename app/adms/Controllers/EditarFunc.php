<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarFunc {

    private $Dados;
    private $DadosId;

    public function editFunc($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editFuncPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Funcioário não encontrado!</div>";
            $UrlDestino = URLADM . 'funcionarios/listar-func';
            header("Location: $UrlDestino");
        }
    }

    private function editFuncPriv() {
        if (!empty($this->Dados['EditFunc'])) {
            unset($this->Dados['EditFunc'], $this->Dados['sit_id'], $this->Dados['sit'], $this->Dados['loja']);
            $editarFunc = new \App\adms\Models\AdmsEditarFunc();
            $editarFunc->altFunc($this->Dados);
            if ($editarFunc->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-func/ver-func/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editFuncViewPriv();
            }
        } else {
            $verFunc = new \App\adms\Models\AdmsEditarFunc();
            $this->Dados['form'] = $verFunc->verFunc($this->DadosId);
            $this->editFuncViewPriv();
        }
    }

    private function editFuncViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarFunc();
            $this->Dados['select'] = $listarSelect->listarFunc();

            $botao = ['vis_func' => ['menu_controller' => 'ver-func', 'menu_metodo' => 'ver-func']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/funcionarios/editarFunc", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Funcionário não encontrado!</div>";
            $UrlDestino = URLADM . 'funcionarios/listar-func';
            header("Location: $UrlDestino");
        }
    }

}
