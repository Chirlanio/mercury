<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarEstorno {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 2;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'estorno/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarEstorno = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarEstorno->fullRead("SELECT a.*, lj.nome loja, est.nome tipo, c.cor cor_cr FROM adms_estornos a INNER JOIN tb_lojas lj ON lj.id=a.loja_id INNER JOIN adms_sits_estornos est ON est.id=a.adms_sits_est_id INNER JOIN adms_cors c on c.id=est.adms_cor_id WHERE a.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarEstorno->fullRead("SELECT a.*, lj.nome loja, est.nome tipo, c.cor cor_cr FROM adms_estornos a INNER JOIN tb_lojas lj ON lj.id=a.loja_id INNER JOIN adms_sits_estornos est ON est.id=a.adms_sits_est_id INNER JOIN adms_cors c on c.id=est.adms_cor_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }

        $this->Resultado = $listarEstorno->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE rede_id <=:rede_id AND status_id =:status_id ORDER BY id ASC", "rede_id=6&status_id=1");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_estornos ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
