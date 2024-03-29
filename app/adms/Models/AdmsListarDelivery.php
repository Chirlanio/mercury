<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarPagina
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarDelivery {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 50;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarDelivery($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'delivery/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();
        
        $listarPagina = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarPagina->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=t.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarPagina->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=t.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarPagina->getResult();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id rota_id, nome rota FROM tb_rotas ORDER BY id ASC");
        $registro['rota_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_delivery ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResult();

        //Pedidos Delivery
        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deli FROM tb_delivery WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deli FROM tb_delivery");
        }
        $registro['deli'] = $listar->getResult();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliSol FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliSol FROM tb_delivery WHERE status_id =:status_id", "status_id=1");
        }
        $registro['deliSol'] = $listar->getResult();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliCol FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliCol FROM tb_delivery WHERE status_id =:status_id", "status_id=2");
        }
        $registro['deliCol'] = $listar->getResult();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliAg FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliAg FROM tb_delivery WHERE status_id =:status_id", "status_id=3");
        }
        $registro['deliAg'] = $listar->getResult();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliRota FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=4&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliRota FROM tb_delivery WHERE status_id =:status_id", "status_id=4");
        }
        $registro['deliRota'] = $listar->getResult();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliEnt FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=5&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliEnt FROM tb_delivery WHERE status_id =:status_id", "status_id=5");
        }
        $registro['deliEnt'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'rota_id' => $registro['rota_id'], 'sit_id' => $registro['sit_id'],
            'deli' => $registro['deli'], 'deliSol' => $registro['deliSol'], 'deliCol' => $registro['deliCol'], 'deliAg' => $registro['deliAg'], 'deliRota' => $registro['deliRota'], 'deliEnt' => $registro['deliEnt']
        ];
        return $this->Resultado;
    }

}
