<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarNivAc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarNivAc {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarNivAc($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'nivel-acesso/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(nivac.id) AS num_result 
                FROM adms_niveis_acessos nivac
                WHERE nivac.ordem >=:ordem", "ordem=" . $_SESSION['ordem_nivac']);
        $this->ResultadoPg = $paginacao->getResultado();

        $listarNivAc = new \App\adms\Models\helper\AdmsRead();
        $listarNivAc->fullRead("SELECT nivac.id, nivac.nome, nivac.ordem, nivac.adms_cor_id, c.nome nome_cor, c.cor cor_cr
                FROM adms_niveis_acessos nivac
                INNER JOIN adms_cors c ON c.id=nivac.adms_cor_id
                WHERE nivac.ordem >=:ordem
                ORDER BY ordem ASC LIMIT :limit OFFSET :offset", "ordem=" . $_SESSION['ordem_nivac'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarNivAc->getResultado();
        return $this->Resultado;
    }

}
