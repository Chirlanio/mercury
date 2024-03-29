<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarOrdemServico
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditarOrdemServico {

    private $Resultado;
    private $Dados;
    private $DadosId;
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
    private $imageOneNew;
    private $imageTwo;
    private $imageTwoNew;
    private $imageThree;
    private $imageThreeNew;
    private $cupomFiscal;
    private $cupomFiscalNew;

    function getResultado() {
        return $this->Resultado;
    }

    public function verOrdemServico($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verOrderService = new \App\adms\Models\helper\AdmsRead();
        $verOrderService->fullRead("SELECT os.*, lj.nome loja, se.nome sit, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id LEFT JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto INNER JOIN adms_sits_ordem_servico se ON se.id=os.status_id INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.type_order_id INNER JOIN tb_tam t ON t.id=os.tam_id INNER JOIN adms_marcas m ON m.id=os.marca_id WHERE os.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verOrderService->getResult();
        return $this->Resultado;
    }

    public function altOrdemServico(array $Dados) {
        $this->Dados = $Dados;

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
        $this->imageOne = $this->Dados['image_one'];
        $this->imageOneNew = $this->Dados['image_one_new'];
        $this->imageTwo = $this->Dados['image_two'];
        $this->imageTwoNew = $this->Dados['image_two_new'];
        $this->imageThree = $this->Dados['image_three'];
        $this->imageThreeNew = $this->Dados['image_three_new'];
        $this->cupomFiscal = $this->Dados['cupom_fiscal'];
        $this->cupomFiscalNew = $this->Dados['cupom_fiscal_new'];

        unset($this->Dados['order_service_zznet'], $this->Dados['date_order_service_zznet'], $this->Dados['data_confir_nota_transf'], $this->Dados['loja_id_conserto'], $this->Dados['nf_conserto_devolucao'],
                $this->Dados['data_emissao_conserto'], $this->Dados['nf_retorno_conserto'], $this->Dados['data_emissao_retorno_conserto'], $this->Dados['data_confir_retorno_conserto'], $this->Dados['nf_transf_saldo_produto'],
                $this->Dados['data_nota_transf_saldo_produto'], $this->Dados['data_nota_transf_saldo_produto'], $this->Dados['obs_qualidade'], $this->Dados['obs_loja'], $this->Dados['image_one'], $this->Dados['image_two'], $this->Dados['image_three'],
                $this->Dados['image_one_new'], $this->Dados['image_two_new'], $this->Dados['image_three_new'], $this->Dados['cupom_fiscal_new'], $this->Dados['cupom_fiscal']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valImage();
        } else {
            $this->Resultado = false;
        }
    }

    private function valImage() {

        if ((empty($this->imageOneNew['name'])) and (empty($this->imageTwoNew['name'])) and (empty($this->imageThreeNew['name'])) and (empty($this->cupomFiscalNew['name']))) {
            $this->updateEditOrdemServico();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            if ((isset($this->imageOneNew)) and (!empty($this->imageOneNew))) {
                $this->Dados['image_one'] = $slugImg->nomeSlug($this->imageOneNew['name']);
            }

            if ((isset($this->imageTwoNew)) and (!empty($this->imageTwoNew))) {
                $this->Dados['image_two'] = $slugImg->nomeSlug($this->imageTwoNew['name']);
            }

            if ((isset($this->imageThreeNew)) and (!empty($this->imageThreeNew))) {
                $this->Dados['image_three'] = $slugImg->nomeSlug($this->imageThreeNew['name']);
            }

            if ((isset($this->cupomFiscalNew)) and (!empty($this->cupomFiscalNew))) {
                $this->Dados['cupom_fiscal'] = $slugImg->nomeSlug($this->cupomFiscalNew['name']);
            }

            $uploadImg = new \App\adms\Models\helper\AdmsUpload();
            if ((isset($this->imageOneNew['name'])) and (!empty($this->imageOneNew['name']))) {
                $uploadImg->upload($this->imageOneNew, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['image_one']);
            }

            if ((isset($this->imageTwoNew['name'])) and (!empty($this->imageTwoNew['name']))) {
                $uploadImg->upload($this->imageTwoNew, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['image_two']);
            }

            if ((isset($this->imageThreeNew['name'])) and (!empty($this->imageThreeNew['name']))) {
                $uploadImg->upload($this->imageThreeNew, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['image_three']);
            }

            if ((isset($this->cupomFiscalNew['name'])) and (!empty($this->cupomFiscalNew['name']))) {
                $uploadImg->upload($this->cupomFiscalNew, 'assets/imagens/order_service/' . $this->Dados['id'] . '/', $this->Dados['cupom_fiscal']);
            }
            $uploadImg->getResultado();
        }

        if (empty($this->imageOneNew['name']) and empty($this->imageTwoNew['name']) and empty($this->imageThreeNew['name']) and empty($this->cupomFiscalNew['name'])) {
            $this->Resultado = true;
        } else {
            //var_dump($this->imageOne);
            $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
            if ((isset($this->imageOneNew['name'])) and (!empty($this->imageOneNew['name']))) {
                $apagarImg->apagarImg('assets/imagens/order_service/' . $this->Dados['id'] . '/' . $this->imageOne);
            }

            if ((isset($this->imageTwoNew['name'])) and (!empty($this->imageTwoNew['name']))) {
                $apagarImg->apagarImg('assets/imagens/order_service/' . $this->Dados['id'] . '/' . $this->imageTwo);
            }

            if ((isset($this->imageTwoNew['name'])) and (!empty($this->imageTwoNew['name']))) {
                $apagarImg->apagarImg('assets/imagens/order_service/' . $this->Dados['id'] . '/' . $this->imageThree);
            }

            if ((isset($this->cupomFiscalNew['name'])) and (!empty($this->cupomFiscalNew['name']))) {
                $apagarImg->apagarImg('assets/imagens/order_service/' . $this->Dados['id'] . '/' . $this->cupomFiscal);
            }
            $this->updateEditOrdemServico();
        }
    }

    private function updateEditOrdemServico() {

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
        $this->Dados['image_one'] = !empty($this->imageOneNew['name']) ? $this->imageOneNew['name'] : $this->imageOne;
        $this->Dados['image_two'] = !empty($this->imageTwoNew['name']) ? $this->imageTwoNew['name'] : $this->imageTwo;
        $this->Dados['image_three'] = !empty($this->imageThreeNew['name']) ? $this->imageThreeNew['name'] : $this->imageThree;
        $this->Dados['cupom_fiscal'] = !empty($this->cupomFiscalNew['name']) ? $this->cupomFiscalNew['name'] : $this->cupomFiscal;
        $this->Dados['obs_qualidade'] = $this->obs_qualidade;

        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $fileName = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['image_one'] = !empty($this->imageOneNew['name']) ? $fileName->nomeSlug($this->imageOneNew['name']) : $this->imageOne;
        $this->Dados['image_two'] = !empty($this->imageTwoNew['name']) ? $fileName->nomeSlug($this->imageTwoNew['name']) : $this->imageTwo;
        $this->Dados['image_three'] = !empty($this->imageThreeNew['name']) ? $fileName->nomeSlug($this->imageThreeNew['name']) : $this->imageThree;
        $this->Dados['cupom_fiscal'] = !empty($this->cupomFiscalNew['name']) ? $fileName->nomeSlug($this->cupomFiscalNew['name']) : $this->cupomFiscal;

        $upAltOrderService = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrderService->exeUpdate("adms_qualidade_ordem_servico", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltOrderService->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de serviço</strong> atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A ordem de serviço não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id t_id, nome tipo FROM adms_tips_ordem_servico ORDER BY id ASC");
        $registro['tips'] = $listar->getResult();

        $listar->fullRead("SELECT id ta_id, nome tam FROM tb_tam ORDER BY id ASC");
        $registro['tam'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, nome marca FROM adms_marcas ORDER BY id ASC");
        $registro['marc'] = $listar->getResult();

        $listar->fullRead("SELECT id s_id, nome sit FROM adms_sits_ordem_servico ORDER BY id ASC");
        $registro['stis'] = $listar->getResult();

        $listar->fullRead("SELECT id d_id, descricao defeito, status_id FROM adms_defeitos_ordem_servico WHERE status_id =:status_id ORDER BY descricao ASC", "status_id=1");
        $registro['def'] = $listar->getResult();

        $listar->fullRead("SELECT id dt_id, descricao detalhe, status_id FROM adms_detalhes_ordem_servico WHERE status_id =:status_id ORDER BY descricao ASC", "status_id=1");
        $registro['det'] = $listar->getResult();

        $listar->fullRead("SELECT id l_id, descricao local, status_id FROM adms_def_local_ordem_servico WHERE status_id =:status_id", "status_id=1");
        $registro['loc'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'tips' => $registro['tips'], 'tam' => $registro['tam'],
            'marc' => $registro['marc'], 'stis' => $registro['stis'], 'def' => $registro['def'], 'det' => $registro['det'], 'loc' => $registro['loc']];

        return $this->Resultado;
    }
}
