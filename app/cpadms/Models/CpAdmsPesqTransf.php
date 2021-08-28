<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqTransf {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqTransf($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $_SESSION['pesqOrigem'] = $this->Dados['loja_origem_id'];
        $_SESSION['pesqDestino'] = $this->Dados['loja_destino_id'];
        $_SESSION['pesqStatus'] = $this->Dados['status_id'];

        if ((!empty($this->Dados['loja_origem_id'])) AND (!empty($this->Dados['loja_destino_id'])) AND (!empty($this->Dados['status_id']))) {
            $this->pesqComp();
        } elseif ((!empty($this->Dados['loja_origem_id'])) AND (!empty($this->Dados['status_id']))) {
            $this->pesqLojaOriSit();
        } elseif ((!empty($this->Dados['loja_destino_id'])) AND (!empty($this->Dados['status_id']))) {
            $this->pesqLojaDesSit();
        } elseif ((!empty($this->Dados['loja_origem_id'])) AND (!empty($this->Dados['loja_destino_id']))) {
            $this->pesqLojaOriDes();
        } elseif (!empty($this->Dados['loja_origem_id'])) {
            $this->pesqLojaOrigem();
        } elseif (!empty($this->Dados['loja_destino_id'])) {
            $this->pesqLojaDestino();
        } elseif (!empty($this->Dados['status_id'])) {
            $this->pesqStatus();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&destino=' . $this->Dados['loja_destino_id'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias t WHERE t.loja_origem_id =:loja_origem_id AND t.loja_destino_id =:loja_destino_id AND t.status_id =:status_id", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id AND t.loja_destino_id =:loja_destino_id AND t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id AND t.loja_origem_id =:loja_origem_id AND t.loja_destino_id =:loja_destino_id AND t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    private function pesqLojaOriSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias t WHERE t.loja_origem_id =:loja_origem_id AND t.status_id =:status_id", "loja_origem_id={$this->Dados['loja_origem_id']}&status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id AND t.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id
                    AND t.loja_origem_id =:loja_origem_id
                    AND t.status_id =:status_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    private function pesqLojaDesSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&destino=' . $this->Dados['loja_destino_id'] . '&situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias t
                WHERE t.loja_destino_id =:loja_destino_id AND t.status_id =:status_id",
                "loja_destino_id={$this->Dados['loja_destino_id']}&status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_destino_id =:loja_destino_id
                    AND t.status_id =:status_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset",
                    "loja_destino_id={$this->Dados['loja_destino_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id
                    AND t.loja_destino_id =:loja_destino_id
                    AND t.status_id =:status_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset",
                    "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id={$this->Dados['loja_destino_id']}&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    private function pesqLojaOriDes() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&destino=' . $this->Dados['loja_destino_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias t WHERE t.loja_origem_id LIKE '%' :loja_origem_id '%' AND t.loja_destino_id LIKE '%' :loja_destino_id '%'", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id LIKE '%' :loja_origem_id '%' AND t.loja_destino_id LIKE '%' :loja_destino_id '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id
                    AND (t.loja_origem_id LIKE :loja_origem_id AND t.loja_destino_id LIKE :loja_destino_id)
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    private function pesqLojaOrigem() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?origem=' . $this->Dados['loja_origem_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias t WHERE t.loja_origem_id LIKE '%' :loja_origem_id '%'", "loja_origem_id={$this->Dados['loja_origem_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id LIKE '%' :loja_origem_id '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_origem_id =:loja_origem_id
                    AND t.loja_origem_id LIKE '%' :loja_origem_id '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    private function pesqLojaDestino() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?destino=' . $this->Dados['loja_destino_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias t WHERE t.loja_destino_id LIKE '%' :loja_destino_id '%'", "loja_destino_id={$this->Dados['loja_destino_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_destino_id =:loja_destino_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.loja_destino_id =:loja_destino_id
                    AND t.loja_destino_id LIKE '%' :loja_destino_id '%'
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_destino_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-transf/listar', '?situacao=' . $this->Dados['status_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_transferencias WHERE status_id =:status_id", "status_id={$this->Dados['status_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarTransf = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE t.status_id =:status_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarTransf->fullRead("SELECT t.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor cor_cr
                    FROM tb_transferencias t
                    INNER JOIN tb_lojas l ON l.id=t.loja_origem_id 
                    INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id 
                    INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id 
                    INNER JOIN tb_status_transf s ON s.id=t.status_id
                    INNER JOIN adms_cors c on c.id=s.adms_cor_id AND s.id=t.status_id
                    WHERE (t.loja_origem_id =:loja_origem_id OR t.loja_destino_id =:loja_destino_id)
                    AND t.status_id =:status_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['status_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarTransf->getResultado();
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] >= 4) {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_origem_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas ORDER BY id ASC");
        $registro['loja_destino_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tipo, nome tipo FROM tb_tipo_transf ORDER BY id ASC");
        $registro['tipo_transf_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_transf ORDER BY id ASC");
        $registro['status_id'] = $listar->getResultado();

        $this->Resultado = ['loja_origem_id' => $registro['loja_origem_id'], 'loja_destino_id' => $registro['loja_destino_id'], 'status_id' => $registro['status_id']];

        return $this->Resultado;
    }

}
