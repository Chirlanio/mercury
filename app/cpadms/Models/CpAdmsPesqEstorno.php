<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqEstorno
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsPesqEstorno {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoAj() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['nome_cliente'] = trim($this->Dados['nome_cliente']);

        $_SESSION['pesqLoja'] = $this->Dados['loja_id'];
        $_SESSION['pesqCliente'] = $this->Dados['nome_cliente'];
        $_SESSION['pesqSit'] = $this->Dados['adms_sits_est_id'];

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['nome_cliente'])) AND (!empty($this->Dados['adms_sits_est_id']))) {
            $this->pesqComp();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['nome_cliente']))) {
            $this->pesqLojaRef();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['adms_sits_est_id']))) {
            $this->pesqLojaStatus();
        } elseif ((!empty($this->Dados['nome_cliente'])) AND (!empty($this->Dados['adms_sits_est_id']))) {
            $this->pesqRefStatus();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['nome_cliente'])) {
            $this->pesqReferencia();
        } elseif (!empty($this->Dados['adms_sits_est_id'])) {
            $this->pesqStatus();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?loja=' . $this->Dados['loja_id'] . '&cliente=' . $this->Dados['nome_cliente'] . '&situacao=' . $this->Dados['adms_sits_est_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result "
                    . "FROM adms_estornos "
                    . "WHERE loja_id =:loja_id "
                    . "AND nome_cliente LIKE '%' :nome_cliente '%' "
                    . "AND adms_sits_est_id =:adms_sits_est_id",
                    "loja_id={$this->Dados['loja_id']}&nome_cliente={$this->Dados['nome_cliente']}&adms_sits_est_id={$this->Dados['adms_sits_est_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result "
                    . "FROM adms_estornos "
                    . "WHERE loja_id =:loja_id "
                    . "AND nome_cliente LIKE '%' :nome_cliente '%' "
                    . "AND adms_sits_est_id =:adms_sits_est_id",
                    "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}&adms_sits_est_id={$this->Dados['adms_sits_est_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    WHERE aj.loja_id =:loja_id
                    AND aj.nome_cliente LIKE '%' :nome_cliente '%'
                    AND adms_sits_est_id =:adms_sits_est_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset",
                    "loja_id={$this->Dados['loja_id']}&nome_cliente={$this->Dados['nome_cliente']}&adms_sits_est_id={$this->Dados['adms_sits_est_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id
                    WHERE aj.loja_id =:loja_id
                    AND aj.nome_cliente LIKE '%' :nome_cliente '%'
                    AND aj.adms_sits_est_id =:adms_sits_est_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}&adms_sits_est_id={$this->Dados['adms_sits_est_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqLojaRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?loja=' . $this->Dados['loja_id'] . '&cliente=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result
                    FROM adms_estornos
                    WHERE loja_id =:loja_id
                    AND nome_cliente LIKE '%' :nome_cliente '%'", "loja_id={$this->Dados['loja_id']}&nome_cliente={$this->Dados['nome_cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result
                    FROM adms_estornos
                    WHERE loja_id =:loja_id
                    AND nome_cliente LIKE '%' :nome_cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    WHERE loja_id =:loja_id
                    AND aj.nome_cliente LIKE '%' :nome_cliente '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset",
                    "loja_id={$this->Dados['loja_id']}&nome_cliente={$this->Dados['nome_cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id
                    WHERE aj.loja_id =:loja_id
                    AND aj.nome_cliente LIKE '%' :nome_cliente '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", 
                    "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqLojaStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['status_aj_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id", "loja_id={$this->Dados['loja_id']}&status_aj_id={$this->Dados['status_aj_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id", "loja_id=" . $_SESSION['usuario_loja'] . "&status_aj_id={$this->Dados['status_aj_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM adms_estornos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM adms_estornos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqRefStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?referencia=' . $this->Dados['referencia'] . '&situacao=' . $this->Dados['status_aj_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id", "referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM adms_estornos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.nome_cliente LIKE '%' :nome_cliente '%' AND status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "nome_cliente={$this->Dados['nome_cliente']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM adms_estornos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.nome_cliente LIKE '%' :nome_cliente '%' AND aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja'] . "&loja_id={$this->Dados['loja_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    WHERE aj.loja_id =:loja_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", 
                    "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id
                    WHERE aj.loja_id =:loja_id
                    AND aj.nome_cliente LIKE '%' :nome_cliente '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", 
                    "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqReferencia() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?cliente=' . $this->Dados['nome_cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result "
                    . "FROM adms_estornos "
                    . "WHERE nome_cliente LIKE '%' :nome_cliente '%'", "nome_cliente={$this->Dados['nome_cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result "
                    . "FROM adms_estornos "
                    . "WHERE loja_id =:loja_id AND nome_cliente LIKE '%' :nome_cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    WHERE aj.nome_cliente LIKE '%' :nome_cliente '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", 
                    "nome_cliente={$this->Dados['nome_cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id
                    WHERE aj.loja_id =:loja_id AND aj.nome_cliente LIKE '%' :nome_cliente '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", 
                    "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['nome_cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-estorno/listar', '?situacao=' . $this->Dados['adms_sits_est_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE adms_sits_est_id =:adms_sits_est_id", "adms_sits_est_id={$this->Dados['adms_sits_est_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos WHERE loja_id =:loja_id AND adms_sits_est_id =:adms_sits_est_id", "loja_id=" . $_SESSION['usuario_loja'] . "&adms_sits_est_id={$this->Dados['adms_sits_est_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    INNER JOIN tb_tam tam ON tam.id=aj.tam_id
                    INNER JOIN adms_cors c on c.id=st.adms_cor_id
                    WHERE aj.adms_sits_est_id =:adms_sits_est_id 
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", 
                    "adms_sits_est_id={$this->Dados['adms_sits_est_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status
                    FROM adms_estornos aj
                    INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                    INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id
                    INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id
                    INNER JOIN tb_tam tam ON tam.id=aj.tam_id
                    WHERE aj.loja_id =:loja_id AND aj.adms_sits_est_id =:adms_sits_est_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset",
                    "loja_id=" . $_SESSION['usuario_loja'] . "&adms_sits_est_id={$this->Dados['adms_sits_est_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_estornos ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
