<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarTipoPagamento {

    private $Dados;
    private $DadosId;

    public function editTipo($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editTipoPagPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de Pagamento não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pagamento/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTipoPagPriv() {
        if (!empty($this->Dados['EditTipo'])) {
            unset($this->Dados['EditTipo']);
            $editarTipo = new \App\adms\Models\AdmsEditarTipoPagamento();
            $editarTipo->altTipo($this->Dados);
            if ($editarTipo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de pagamento editado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-tipo-pagamento/ver-tipo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTipoPagViewPriv();
            }
        } else {
            $verTipo = new \App\adms\Models\AdmsEditarTipoPagamento();
            $this->Dados['form'] = $verTipo->verTipo($this->DadosId);
            $this->editTipoPagViewPriv();
        }
    }

    private function editTipoPagViewPriv() {
        if ($this->Dados['form']) {
            
            $botao = ['vis_pag' => ['menu_controller' => 'ver-tipo-pagamento', 'menu_metodo' => 'ver-tipo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/tipoPag/editarTipoPagamento", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de pagamento não encontrado!</div>";
            $UrlDestino = URLADM . 'ver-tipo-pagamtno/ver-tipo/';
            header("Location: $UrlDestino");
        }
    }

}
