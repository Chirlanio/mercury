<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarBalancoProduto {

    private $Resultado;
    private $PageId;
    private $Dados;
    private $LimiteResultado = 40;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarBalanco($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados['id'] = (int) $Dados;
        $_SESSION['id'] = $this->Dados['id'];

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'balanco-produto/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_balanco_produtos WHERE balanco_id =:balanco_id", "balanco_id={$this->Dados['id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_balanco_produtos WHERE balanco_id =:balanco_id AND loja_id =:loja_id", "balanco_id={$this->Dados['id']}&loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarBalanco = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarBalanco->fullRead("SELECT ba.*, b.nome status, t.nome tam FROM adms_balanco_produtos ba INNER JOIN adms_status_balancos b ON b.id=ba.status_id INNER JOIN tb_tam t ON t.id = ba.tam_id WHERE ba.balanco_id =:balanco_id ORDER BY ba.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}&balanco_id=" . $_SESSION['id']);
        } else {
            $listarBalanco->fullRead("SELECT ba.* FROM adms_balanco_produtos ba WHERE ba.balanco_id =:balanco_id AND ba.loja_id =:loja_id ORDER BY ba.id ASC LIMIT :limit OFFSET :offset", "balanco_id={$this->Dados['id']}&loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarBalanco->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id t_id, nome tam from tb_tam");
        $registro['tam'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'tam' => $registro['tam']];

        return $this->Resultado;
    }

}
