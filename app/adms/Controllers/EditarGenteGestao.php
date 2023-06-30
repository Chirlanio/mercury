<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarGenteGestao
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditarGenteGestao {

    private $Dados;

    public function editGenteGestao() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['EditGenteGestao'])) {
            unset($this->Dados['EditGenteGestao']);
            
            $this->Dados['arquivo'] = ($_FILES['arquivo'] ? $_FILES['arquivo'] : null);
            var_dump($this->Dados);
            
            $editarGenteGestao = new \App\adms\Models\AdmsEditarGenteGestao();
            $editarGenteGestao->altGenteGestao($this->Dados);
            
            if ($editarGenteGestao->getResultado()) {
                $UrlDestino = URLADM . 'editar-gente-gestao/edit-gente-gestao';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editGenteGestaoViewPriv();
            }
        } else {
            $verGenteGestao = new \App\adms\Models\AdmsEditarGenteGestao();
            $this->Dados['form'] = $verGenteGestao->verGenteGestao();
            $this->editGenteGestaoViewPriv();
        }
    }

    private function editGenteGestaoViewPriv() {
        if ($this->Dados['form']) {
            
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("adms/Views/gestao/editarGenteGestao", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados não encontrado!</div>";
            $UrlDestino = URLADM . 'editar-gente-gestao/edit-gente-gestao';
            header("Location: $UrlDestino");
        }
    }

}
