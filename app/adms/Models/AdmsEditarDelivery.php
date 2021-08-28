<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarDelivery {

    private $Resultado;
    private $Dados;
    private $VazioObs;
    private $VazioRec;
    private $VazioPed;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verDelivery($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verDelivery = new \App\adms\Models\helper\AdmsRead();
        $verDelivery->fullRead("SELECT aj.id, aj.loja_id, aj.func_id, aj.cliente, aj.endereco, aj.bairro_id, aj.rota_id, aj.contato, aj.valor_venda, aj.troca,
                aj.forma_pag_id, aj.parcelas, aj.nf, aj.maq, aj.obs, aj.recebido, aj.ped_id, aj.ponto_saida, aj.presente, aj.status_id s_id, aj.created, aj.modified
                FROM tb_delivery aj
                WHERE aj.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verDelivery->getResultado();
        return $this->Resultado;
    }

    public function altDelivery(array $Dados) {

        $this->Dados = $Dados;
        $this->VazioObs = $this->Dados['obs'];
        $this->VazioRec = $this->Dados['recebido'];
        $this->VazioPed = $this->Dados['ped_id'];
        unset($this->Dados['obs'], $this->Dados['recebido'], $this->Dados['ped_id']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditDelivery();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditDelivery() {

        $this->Dados['obs'] = $this->VazioObs;
        $this->Dados['recebido'] = $this->VazioRec;
        $this->Dados['ped_id'] = $this->VazioPed;
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltAjuste = new \App\adms\Models\helper\AdmsUpdate();
        $upAltAjuste->exeUpdate("tb_delivery", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);

        if ($upAltAjuste->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY nome ASC");

        $registro['loja'] = $listar->getResultado();

        $listar->fullRead("SELECT id func_id, nome func FROM tb_funcionarios WHERE cargo_id =:cargo_id AND status_id =:status_id ORDER BY nome ASC", "cargo_id=2&status_id=1");
        $registro['func'] = $listar->getResultado();

        $listar->fullRead("SELECT id bairro_id, nome bairro, rota_id FROM tb_bairros ORDER BY nome ASC");
        $registro['bairro'] = $listar->getResultado();

        $listar->fullRead("SELECT id f_id, nome forma FROM tb_forma_pag ORDER BY nome ASC");
        $registro['pag'] = $listar->getResultado();

        $listar->fullRead("SELECT id s_id, nome sit FROM tb_status_delivery ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id rota_id, nome rota FROM tb_rotas ORDER BY id ASC");
        $registro['rota'] = $listar->getResultado();

        $listar->fullRead("SELECT id ped_id, loja_id loja_ped FROM tb_prateleira_infinita ORDER BY id DESC");
        $registro['prat'] = $listar->getResultado();

        $this->Resultado = ['loja' => $registro['loja'], 'func' => $registro['func'], 'bairro' => $registro['bairro'], 'pag' => $registro['pag'], 'sit' => $registro['sit'], 'rota' => $registro['rota'], 'prat' => $registro['prat']];

        return $this->Resultado;
    }

}
