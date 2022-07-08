<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarArq {

    private $Dados;
    private $DadosId;

    public function editArq($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editUsuarioPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'listar-arquivo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editUsuarioPriv() {
        
        if (!empty($this->Dados['EditArq'])) {
            unset($this->Dados['EditArq']);
            
            $this->Dados['slug'] = ($_FILES['slug'] ? $_FILES['slug'] : null);
            
            $editarArq = new \App\adms\Models\AdmsEditarArq();
            $editarArq->altArq($this->Dados);
            if ($editarArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro do arquivo editado com sucesso!</div>";
                $UrlDestino = URLADM . 'listar-arquivo/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editArqViewPriv();
            }
        } else {
            $verArq = new \App\adms\Models\AdmsEditarArq();
            $this->Dados['form'] = $verArq->verArq($this->DadosId);
            $this->editArqViewPriv();
        }
    }

    private function editArqViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarArq();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_arq' => ['menu_controller' => 'listar-arquivo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/upload/editArquivo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cadastro do arquivo não foi encontrado!</div>";
            $UrlDestino = URLADM . 'listar-arquivo/listar';
            header("Location: $UrlDestino");
        }
    }

}
