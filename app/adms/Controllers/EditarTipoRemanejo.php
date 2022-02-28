<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarTipoRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarTipoRemanejo {

    private $Dados;
    private $DadosId;

    public function editTipoRemanejo($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editTipoRemPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de Remanejo não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-remanejo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTipoRemPriv() {
        if (!empty($this->Dados['EditTipoRemanejo'])) {
            unset($this->Dados['EditTipoRemanejo']);
            $editarTipoRemanejo = new \App\adms\Models\AdmsEditarTipoRemanejo();
            $editarTipoRemanejo->altTipoRemanejo($this->Dados);
            if ($editarTipoRemanejo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de Remanejo editado com sucesso!</div>";
                $UrlDestino = URLADM . 'tipo-remanejo/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTipoPagViewPriv();
            }
        } else {
            $verTipoRemanejo = new \App\adms\Models\AdmsEditarTipoRemanejo();
            $this->Dados['form'] = $verTipoRemanejo->verTipoRemanejo($this->DadosId);
            $this->editTipoRemViewPriv();
        }
    }

    private function editTipoRemViewPriv() {
        if ($this->Dados['form']) {
            
            $botao = ['list_tipo_remanejo' => ['menu_controller' => 'tipo-remanejo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/tipoRemanejo/editarTipoRemanejo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de remanejo não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-remanejo/listar/';
            header("Location: $UrlDestino");
        }
    }

}
