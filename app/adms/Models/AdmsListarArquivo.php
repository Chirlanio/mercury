<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarArquivo {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'arquivo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_up_down WHERE status_id =:status_id", "status_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarArq = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
            $listarArq->fullRead("SELECT a.*, st.nome status, lj.nome loja FROM adms_up_down a INNER JOIN tb_status st ON st.id=a.status_id INNER JOIN tb_lojas lj ON lj.id=a.loja_id WHERE a.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarArq->fullRead("SELECT a.*, st.nome status, lj.nome loja FROM adms_up_down a INNER JOIN tb_status st ON st.id=a.status_id INNER JOIN tb_lojas lj ON lj.id=a.loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarArq->getResult();
        return $this->Resultado;
    }

}
