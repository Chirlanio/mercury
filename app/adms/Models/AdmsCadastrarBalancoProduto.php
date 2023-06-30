<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarBalancoProduto {

    private $Resultado;
    private $Dados;
    private $Solucao;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadProduto(array $Dados) {
        $this->Dados = $Dados;
        $this->Solucao = $this->Dados['solucao'];
        var_dump($this->Dados);

        if (isset($this->Dados['solucao']) and empty($this->Dados['solucao'])) {
            unset($this->Dados['solucao']);
        }

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirBalancoProduto();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirBalancoProduto() {
        $this->Dados['solucao'] = $this->Solucao;
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadProduto = new \App\adms\Models\helper\AdmsCreate;
        $cadProduto->exeCreate("adms_balanco_produtos", $this->Dados);
        if ($cadProduto->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Cadastro realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro: </strong>Cadastro não realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] > 3) {
            $listar->fullRead("SELECT id_loja, id lj_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY nome ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id_loja, id lj_id, nome loja FROM tb_lojas ORDER BY nome ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id s_id, nome sit FROM tb_status_aj ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tam, nome tam FROM tb_tam ORDER BY nome ASC");
        $registro['tam_id'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
            $listar->fullRead("SELECT b.id b_id, c.nome ciclo, c.ano, l.nome loja FROM adms_balancos b INNER JOIN adms_ciclos c ON c.id = b.ciclo_id INNER JOIN tb_lojas l ON l.id = b.loja_id WHERE b.loja_id =:loja_id AND b.status_id <=:status_id ORDER BY b.id DESC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=2");
        } else {
            $listar->fullRead("SELECT b.id b_id, c.nome ciclo, c.ano, l.nome loja FROM adms_balancos b INNER JOIN adms_ciclos c ON c.id = b.ciclo_id INNER JOIN tb_lojas l ON l.id = b.loja_id ORDER BY b.id DESC");
        }
        $registro['b_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id j_id, nome situacao from adms_justs_balanco_prod");
        $registro['sit_prod'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'tam_id' => $registro['tam_id'], 'b_id' => $registro['b_id'], 'sit_prod' => $registro['sit_prod']];

        return $this->Resultado;
    }

}
