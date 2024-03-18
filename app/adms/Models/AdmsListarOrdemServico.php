<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarOrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarOrdemServico {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'ordem-servico/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarOrdemService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listarOrdemService->fullRead("SELECT os.*, lj.nome nome_loja, st.nome status, tam.nome tam, c.cor FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id INNER JOIN adms_sits_ordem_servico st ON st.id=os.status_id INNER JOIN adms_cors c ON c.id=st.cor_id INNER JOIN tb_tam tam ON tam.id=os.tam_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarOrdemService->fullRead("SELECT os.*, lj.nome nome_loja, st.nome status, tam.nome tam, c.cor FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id INNER JOIN adms_sits_ordem_servico st ON st.id=os.status_id INNER JOIN adms_cors c ON c.id=st.cor_id INNER JOIN tb_tam tam ON tam.id=os.tam_id INNER JOIN adms_usuarios user ON user.loja_id=os.loja_id WHERE os.loja_id =:loja_id ORDER BY os.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarOrdemService->getResult();
        return $this->Resultado;
    }
    
    public function listCad() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['lojas'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, nome brand FROM adms_marcas ORDER BY nome ASC");
        $registro['marcas'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_ordem_servico ORDER BY id ASC");
        $registro['sits'] = $listar->getResult();

        //Pedidos Delivery
        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS total_order FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_order FROM adms_qualidade_ordem_servico");
        }
        $registro['sitTotal'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitPend FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitPend FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=1");
        }
        $registro['sitPend'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitAgCons FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitAgCons FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=2");
        }
        $registro['sitAgCons'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitEmConst FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitEmConst FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=3");
        }
        $registro['sitEmConst'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitConcl FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=4&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitConcl FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=4");
        }
        $registro['sitConcl'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitAgRet FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=5&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitAgRet FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=5");
        }
        $registro['sitAgRet'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitEmProcess FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=6&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitEmProcess FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=6");
        }
        $registro['sitEmProcess'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitFinal FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=7&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitFinal FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=7");
        }
        $registro['sitFinal'] = $listar->getResult();

        if (($_SESSION['ordem_nivac'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitCancel FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=8&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitCancel FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=8");
        }
        $registro['sitCancel'] = $listar->getResult();

        $this->Resultado = ['lojas' => $registro['lojas'], 'sits' => $registro['sits'], 'marcas' => $registro['marcas'],
            'sitTotal' => $registro['sitTotal'], 'sitPend' => $registro['sitPend'], 'sitAgCons' => $registro['sitAgCons'],
            'sitEmConst' => $registro['sitEmConst'], 'sitConcl' => $registro['sitConcl'], 'sitAgRet' => $registro['sitAgRet'],
            'sitEmProcess' => $registro['sitEmProcess'], 'sitFinal' => $registro['sitFinal'], 'sitCancel' => $registro['sitCancel']
        ];
        return $this->Resultado;
    }

}
