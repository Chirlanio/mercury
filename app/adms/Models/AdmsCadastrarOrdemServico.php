<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarOrdemServico
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsCadastrarOrdemServico {

    private $Resultado;
    private $Dados;
    private $order_service_zznet;
    private $date_order_service_zznet;
    private $num_nota_transf;
    private $loja_id_conserto;
    private $nf_conserto_devolucao;
    private $data_emissao_conserto;
    private $nf_retorno_conserto;
    private $data_emissao_retorno_conserto;
    private $data_confir_retorno_conserto;
    private $nf_transf_saldo_produto;
    private $data_nota_transf_saldo_produto;
    private $obs_loja;
    private $obs_qualidade;
    private $imageOne;
    private $imageTwo;
    private $imageThree;
    private $cupomFiscal;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadOrdemServico(array $Dados) {

        $this->Dados = $Dados;
        
        $this->Dados['referencia'] = strtoupper($this->Dados['referencia']);
        $this->order_service_zznet = !empty($this->Dados['order_service_zznet']) ? str_replace('-', '', $this->Dados['order_service_zznet']) : null;
        $this->date_order_service_zznet = !empty($this->Dados['date_order_service_zznet']) ? $this->Dados['date_order_service_zznet'] : null;
        $this->num_nota_transf = !empty($this->Dados['data_confir_nota_transf']) ? $this->Dados['data_confir_nota_transf'] : null;
        $this->loja_id_conserto = !empty($this->Dados['loja_id_conserto']) ? $this->Dados['loja_id_conserto'] : null;
        $this->nf_conserto_devolucao = !empty($this->Dados['nf_conserto_devolucao']) ? $this->Dados['nf_conserto_devolucao'] : null;
        $this->data_emissao_conserto = !empty($this->Dados['data_emissao_conserto']) ? $this->Dados['data_emissao_conserto'] : null;
        $this->nf_retorno_conserto = !empty($this->Dados['nf_retorno_conserto']) ? $this->Dados['nf_retorno_conserto'] : null;
        $this->data_emissao_retorno_conserto = !empty($this->Dados['data_emissao_retorno_conserto']) ? $this->Dados['data_emissao_retorno_conserto'] : null;
        $this->data_confir_retorno_conserto = !empty($this->Dados['data_confir_retorno_conserto']) ? $this->Dados['data_confir_retorno_conserto'] : null;
        $this->nf_transf_saldo_produto = !empty($this->Dados['nf_transf_saldo_produto']) ? $this->Dados['nf_transf_saldo_produto'] : null;
        $this->data_nota_transf_saldo_produto = !empty($this->Dados['data_nota_transf_saldo_produto']) ? $this->Dados['data_nota_transf_saldo_produto'] : null;
        $this->obs_loja = !empty($this->Dados['obs_loja']) ? $this->Dados['obs_loja'] : null;
        $this->obs_qualidade = !empty($this->Dados['obs_qualidade']) ? $this->Dados['obs_qualidade'] : null;
        $this->imageOne = !empty($this->Dados['image_one']) ? $this->Dados['image_one'] : null;
        $this->imageTwo = !empty($this->Dados['image_two']) ? $this->Dados['image_two'] : null;
        $this->imageThree = !empty($this->Dados['image_three']) ? $this->Dados['image_three'] : null;
        $this->cupomFiscal = !empty($this->Dados['cupom_fiscal']) ? $this->Dados['cupom_fiscal'] : null;

        unset($this->Dados['order_service_zznet'], $this->Dados['date_order_service_zznet'], $this->Dados['data_confir_nota_transf'], $this->Dados['loja_id_conserto'], $this->Dados['nf_conserto_devolucao'],
                $this->Dados['data_emissao_conserto'], $this->Dados['nf_retorno_conserto'], $this->Dados['data_emissao_retorno_conserto'], $this->Dados['data_confir_retorno_conserto'], $this->Dados['nf_transf_saldo_produto'],
                $this->Dados['data_nota_transf_saldo_produto'], $this->Dados['data_nota_transf_saldo_produto'], $this->Dados['obs_qualidade'], $this->Dados['obs_loja'], $this->Dados['image_one'], $this->Dados['image_two'], $this->Dados['image_three'], $this->Dados['cupom_fiscal']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirOrdem();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirOrdem() {

        $this->Dados['order_service_zznet'] = $this->order_service_zznet;
        $this->Dados['date_order_service_zznet'] = $this->date_order_service_zznet;
        $this->Dados['data_confir_nota_transf'] = $this->num_nota_transf;
        $this->Dados['loja_id_conserto'] = $this->loja_id_conserto;
        $this->Dados['nf_conserto_devolucao'] = $this->nf_conserto_devolucao;
        $this->Dados['data_emissao_conserto'] = $this->data_emissao_conserto;
        $this->Dados['nf_retorno_conserto'] = $this->nf_retorno_conserto;
        $this->Dados['data_emissao_retorno_conserto'] = $this->data_emissao_retorno_conserto;
        $this->Dados['data_confir_retorno_conserto'] = $this->data_confir_retorno_conserto;
        $this->Dados['nf_transf_saldo_produto'] = $this->nf_transf_saldo_produto;
        $this->Dados['data_nota_transf_saldo_produto'] = $this->data_nota_transf_saldo_produto;
        $this->Dados['obs_loja'] = $this->obs_loja;
        $this->Dados['obs_qualidade'] = $this->obs_qualidade;
        $this->Dados['image_one'] = $this->imageOne;
        $this->Dados['image_two'] = $this->imageTwo;
        $this->Dados['image_three'] = $this->imageThree;
        $this->Dados['cupom_fiscal'] = $this->imageThree;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['image_one'] = $slugImg->nomeSlug($this->imageOne['name']);
        $this->Dados['image_two'] = $slugImg->nomeSlug($this->imageTwo['name']);
        $this->Dados['image_three'] = $slugImg->nomeSlug($this->imageThree['name']);
        $this->Dados['cupom_fiscal'] = $slugImg->nomeSlug($this->cupomFiscal['name']);

        $cadOrdem = new \App\adms\Models\helper\AdmsCreate;
        $cadOrdem->exeCreate("adms_qualidade_ordem_servico", $this->Dados);
        //var_dump($this->Dados);

        if ($cadOrdem->getResult()) {
            if ((empty($this->imageOne['name'])) and (empty($this->imageTwo['name'])) and (empty($this->imageThree['name'])) and (empty($this->cupomFiscal['name']))) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de serviço</strong> cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadOrdem->getResult();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A solicitação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valFoto() {

        $uploadOne = new \App\adms\Models\helper\AdmsUpload();
        $uploadOne->upload($this->imageOne, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['image_one']);

        $uploadTwo = new \App\adms\Models\helper\AdmsUpload();
        $uploadTwo->upload($this->imageTwo, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['image_two']);

        $uploadThree = new \App\adms\Models\helper\AdmsUpload();
        $uploadThree->upload($this->imageThree, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['image_three']);

        $uploadImg = new \App\adms\Models\helper\AdmsUpload();
        $uploadImg->upload($this->cupomFiscal, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['cupom_fiscal']);

        if (($uploadImg->getResultado()) and ($uploadOne->getResultado()) and ($uploadTwo->getResultado()) and ($uploadThree->getResultado())) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de serviço</strong> cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A solicitação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id tip_id, nome tipo FROM adms_tips_ordem_servico ORDER BY id ASC");
        $registro['types'] = $listar->getResult();

        $listar->fullRead("SELECT id tam_id, nome tam FROM tb_tam ORDER BY id ASC");
        $registro['tams'] = $listar->getResult();
        
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas WHERE status_id =:status_id ORDER BY id_loja ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas WHERE id =:l_id AND status_id =:status_id ORDER BY id_loja ASC", "l_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['stores'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, nome marca FROM adms_marcas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['marc'] = $listar->getResult();

        $listar->fullRead("SELECT id d_id, descricao defeito, status_id FROM adms_defeitos_ordem_servico WHERE status_id =:status_id ORDER BY descricao ASC", "status_id=1");
        $registro['def'] = $listar->getResult();

        $listar->fullRead("SELECT id dt_id, descricao detalhe, status_id FROM adms_detalhes_ordem_servico WHERE status_id =:status_id ORDER BY descricao ASC", "status_id=1");
        $registro['det'] = $listar->getResult();

        $listar->fullRead("SELECT id l_id, descricao local, status_id FROM adms_def_local_ordem_servico WHERE status_id =:status_id", "status_id=1");
        $registro['loc'] = $listar->getResult();

        $this->Resultado = ['stores' => $registro['stores'], 'types' => $registro['types'], 'tams' => $registro['tams'], 'marc' => $registro['marc'], 'def' => $registro['def'],
            'det' => $registro['det'], 'loc' => $registro['loc']];

        return $this->Resultado;
    }

}
