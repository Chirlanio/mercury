<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarPed
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarPed {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarPed($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'prateleira-infinita/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_prateleira_infinita WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarCor->fullRead("SELECT p.*,
                    t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                    FROM tb_prateleira_infinita p
                    INNER JOIN tb_tam t ON t.id=p.tam_id
                    INNER JOIN tb_lojas l ON l.id=p.loja_id
                    INNER JOIN tb_funcionarios f ON f.id=p.func_id
                    INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                    INNER JOIN adms_cors c ON c.id=tr.cor_id
                    ORDER BY id ASC LIMIT :limit OFFSET :offset",
                    "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarCor->fullRead("SELECT p.*,
                    t.nome tam, l.nome loja, f.nome func, tr.nome sit, c.nome n_cor, c.cor
                    FROM tb_prateleira_infinita p
                    INNER JOIN tb_tam t ON t.id=p.tam_id
                    INNER JOIN tb_lojas l ON l.id=p.loja_id
                    INNER JOIN tb_funcionarios f ON f.id=p.func_id
                    INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                    INNER JOIN adms_cors c ON c.id=tr.cor_id
                    WHERE p.loja_id =:loja_id
                    ORDER BY id ASC LIMIT :limit OFFSET :offset",
                    "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarCor->getResultado();
        return $this->Resultado;
    }
    
    public function listarCadastrar() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_prat ORDER BY id ASC");
        $registro['sit']=$listar->getResultado();
        
        $this->Resultado = ['loja' => $registro['loja'], 'sit' => $registro['sit']];
        return $this->Resultado;
    }

}
