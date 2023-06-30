<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarMarca {

    private $Dados;
    private $DadosId;

    public function editMarca($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editMarcaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Marca não encontrada!</div>";
            $UrlDestino = URLADM . 'marcas/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editMarcaPriv() {
        if (!empty($this->Dados['EditMarca'])) {
            unset($this->Dados['EditMarca']);
            $editarMarca = new \App\adms\Models\AdmsEditarMarca();
            $editarMarca->altMarca($this->Dados);
            if ($editarMarca->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Marca editada com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-marca/ver-marca/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMarcaViewPriv();
            }
        } else {
            $verMarca = new \App\adms\Models\AdmsEditarMarca();
            $this->Dados['form'] = $verMarca->verMarca($this->DadosId);
            $this->editMarcaViewPriv();
        }
    }

    private function editMarcaViewPriv() {
        if ($this->Dados['form']) {
            
            $listarSelect = new \App\adms\Models\AdmsEditarMarca();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['vis_marca' => ['menu_controller' => 'ver-marca', 'menu_metodo' => 'ver-marca']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/marca/editarMarca", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Marca não encontrada!</div>";
            $UrlDestino = URLADM . 'marcas/listar';
            header("Location: $UrlDestino");
        }
    }

}
