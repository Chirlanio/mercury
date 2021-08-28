<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsCadastrarProdutos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class StsCadastrarProdutos {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadProduto(array $Dados) {

        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $this->inserir();
        }
    }

    private function validarDados() {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro: </strong>Preencha todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function inserir() {
        $listarCad = new \Sts\Models\helper\StsCreate();
        $listarCad->exeCreate('tb_cad_produtos', $this->Dados);
        if ($listarCad->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Solicitação enviada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro: </strong>Solicitação não enviada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
