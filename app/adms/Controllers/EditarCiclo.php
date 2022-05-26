<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarCiclo {

    private $Dados;
    private $DadosId;

    public function editCiclo($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editCicloPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ciclos/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCicloPriv() {
        if (!empty($this->Dados['EditCiclo'])) {
            unset($this->Dados['EditCiclo']);
            $editarCiclo = new \App\adms\Models\AdmsEditarCiclo();
            $editarCiclo->altCiclo($this->Dados);
            if ($editarCiclo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-ciclo/ver-ciclo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCicloViewPriv();
            }
        } else {
            $verCiclo = new \App\adms\Models\AdmsEditarCiclo();
            $this->Dados['form'] = $verCiclo->verCiclo($this->DadosId);
            $this->editCicloViewPriv();
        }
    }

    private function editCicloViewPriv() {
        if ($this->Dados['form']) {
            
            $botao = ['vis_ciclo' => ['menu_controller' => 'ver-ciclo', 'menu_metodo' => 'ver-ciclo']];
            
            $listar = new \App\adms\Models\AdmsEditarCiclo();
            $this->Dados['select'] = $listar->listarCadastrar();
            
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/ciclo/editarCiclo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ciclos/listar';
            header("Location: $UrlDestino");
        }
    }

}
