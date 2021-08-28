<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarDelivery {

    private $Resultado;
    private $Dados;

    /**
     * <b>Obter Resultado:</b> Retorna TRUE caso tenha cadastrado com sucesso e FALSE quando não conseguiu editar
     * @return BOOL true ou false
     */
    function getResultado() {
        return $this->Resultado;
    }

    /**
     * <b>Cadastrar Página:</b> Receber array de Dados com as informações da página
     * @param ARRAY $Dados
     */
    public function cadDelivery(array $Dados) {
        $this->Dados = $Dados;

        if ($this->Dados) {
            $this->inserirDelivery();
        } else {
            $this->Resultado = false;
        }
    }

    /**
     * <b>Cadastrar Página no banco de dados:</b> Inserir no banco de dados as informações página
     */
    private function inserirDelivery() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadDelivery = new \App\adms\Models\helper\AdmsCreate;
        $cadDelivery->exeCreate("tb_delivery", $this->Dados);
        if ($cadDelivery->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A Entrega não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações nas tabelas "adms_grps_pgs, adms_tps_pgs, adms_sits_pgs" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios WHERE cargo_id =:cargo_id AND status_id =:status_id ORDER BY nome ASC", "cargo_id=2&status_id=1");
        $registro['func'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_rota, nome rota FROM tb_rotas ORDER BY id ASC");
        $registro['rota'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_bairro, nome bairro, rota_id FROM tb_bairros ORDER BY nome ASC");
        $registro['bairro'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_pag, nome forma FROM tb_forma_pag ORDER BY nome ASC");
        $registro['forma'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sit, nome sit FROM tb_status_delivery ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id ped_id, loja_id FROM tb_prateleira_infinita ORDER BY id DESC");
        $registro['ped'] = $listar->getResultado();

        $this->Resultado = ['loja' => $registro['loja'], 'func' => $registro['func'], 'rota' => $registro['rota'], 'bairro' => $registro['bairro'], 'forma' => $registro['forma'], 'sit' => $registro['sit'], 'ped' => $registro['ped']];

        return $this->Resultado;
    }

}
