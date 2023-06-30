<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarBairro {

    private $Dados;
    private $DadosId;

    public function editBairro($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editBairroPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bairro não encontrado!</div>";
            $UrlDestino = URLADM . 'bairro/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editBairroPriv() {
        if (!empty($this->Dados['EditBairro'])) {
            unset($this->Dados['EditBairro']);
            $editarBairro = new \App\adms\Models\AdmsEditarBairro();
            $editarBairro->altBairro($this->Dados);
            if ($editarBairro->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Bairro editado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-bairro/ver-bairro/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCargoViewPriv();
            }
        } else {
            $verBairro = new \App\adms\Models\AdmsEditarBairro();
            $this->Dados['form'] = $verBairro->verBairro($this->DadosId);
            $this->editBairroViewPriv();
        }
    }

    private function editBairroViewPriv() {
        if ($this->Dados['form']) {
            
            $listarSelect = new \App\adms\Models\AdmsEditarBairro();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['vis_bairro' => ['menu_controller' => 'ver-bairro', 'menu_metodo' => 'ver-bairro']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/bairro/editarBairro", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bairro não encontrado!</div>";
            $UrlDestino = URLADM . 'bairro/listar';
            header("Location: $UrlDestino");
        }
    }

}
