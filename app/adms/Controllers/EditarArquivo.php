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
class EditarArquivo {

    private $Dados;
    private $DadosId;

    public function editArquivo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editArquivoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'arquivo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editArquivoPriv() {
        
        if (!empty($this->Dados['EditArq'])) {
            unset($this->Dados['EditArq']);
            
            $this->Dados['slug'] = ($_FILES['slug'] ? $_FILES['slug'] : null);
            
            $editarArq = new \App\adms\Models\AdmsEditarArquivo();
            $editarArq->altArquivo($this->Dados);
            if ($editarArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Registro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'arquivo/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editArquivoViewPriv();
            }
        } else {
            $verArq = new \App\adms\Models\AdmsEditarArquivo();
            $this->Dados['form'] = $verArq->verArquivo($this->DadosId);
            $this->editArquivoViewPriv();
        }
    }

    private function editArquivoViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarArquivo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_arq' => ['menu_controller' => 'arquivo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/upload/editArquivo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum registo encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'arquivo/listar';
            header("Location: $UrlDestino");
        }
    }

}
