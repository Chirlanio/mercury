<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarDetalhes {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarDetalhes($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'detalhes/listar-detalhes');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_detalhes_ordem_servico");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_detalhes_ordem_servico WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDefeitos = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarDefeitos->fullRead("SELECT d.*, st.nome status FROM adms_detalhes_ordem_servico d INNER JOIN adms_sits st ON st.id=d.status_id ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDefeitos->fullRead("SELECT d.*, st.nome status FROM adms_detalhes_ordem_servico d INNER JOIN adms_sits st ON st.id=d.status_id WHERE aj.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDefeitos->getResultado();
        return $this->Resultado;
    }

}
