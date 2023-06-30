<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarBalancoProduto {

    private $Dados;
    private $DadosId;

    public function editBalanco($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editBalancoProdutoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Registro não encontrado!</div>";
            $UrlDestino = URLADM . 'balanco-produto/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editBalancoProdutoPriv() {
        if (!empty($this->Dados['EditBalanco'])) {
            unset($this->Dados['EditBalanco']);
            
            
            $this->Dados['img_um'] = ($_FILES['file_um'] ? $_FILES['file_um'] : $this->Dados['img_um']);
            $this->Dados['img_dois'] = ($_FILES['file_dois'] ? $_FILES['file_dois'] : $this->Dados['img_dois']);
            $this->Dados['img_tres'] = ($_FILES['file_tres'] ? $_FILES['file_tres'] : $this->Dados['img_tres']);
            
            $editarBalanco = new \App\adms\Models\AdmsEditarBalancoProduto();
            $editarBalanco->altBalanco($this->Dados);
            
            if ($editarBalanco->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Registro atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'balanco-produto/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editBalancoProdutoViewPriv();
            }
        } else {
            $verBalanco = new \App\adms\Models\AdmsEditarBalancoProduto();
            $this->Dados['form'] = $verBalanco->verBalanco($this->DadosId);
            $this->editBalancoProdutoViewPriv();
        }
    }

    private function editBalancoProdutoViewPriv() {
        if ($this->Dados['form'][0]) {
            var_dump($this->Dados['form'][0]);
            $listarSelect = new \App\adms\Models\AdmsEditarBalancoProduto();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_balanco_produto' => ['menu_controller' => 'ver-balanco-produto', 'menu_metodo' => 'ver-balanco'],
                    'list_balanco_produto' => ['menu_controller' => 'balanco-produto', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/auditoria/editarBalancoProduto", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitido editar produto com o status \"Pendente\" ou \"Em Analise\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'balanco-produto/listar';
            header("Location: $UrlDestino");
        }
    }

}
