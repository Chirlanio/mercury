<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarBalancoProduto {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Tipo;
    private $Situacao;
    private $Solucao;
    private $Justificativa;
    private $ImagemUm;
    private $ImagemDois;
    private $ImagemTres;
    private $Resposta;
    private $DirId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verBalanco($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
            $verAjuste->fullRead("SELECT aj.*, sit.id sit_id, sit.nome sit FROM adms_balanco_produtos aj INNER JOIN tb_status sit ON sit.id=aj.status_id WHERE aj.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        } else {
            $verAjuste->fullRead("SELECT aj.*, sit.id sit_id, sit.nome sit FROM adms_balanco_produtos aj INNER JOIN tb_status sit ON sit.id=aj.status_id WHERE aj.id =:id AND (aj.status_id =:status_id OR aj.status_id =:status_id2) LIMIT :limit", "id=" . $this->DadosId . "&status_id=2&status_id2=5&limit=1");
        }
        $this->Resultado = $verAjuste->getResult();
        return $this->Resultado;
    }

    public function altBalanco(array $Dados) {

        $this->Dados = $Dados;
        $this->DirId = $this->Dados['id'];
        $this->Tipo = $this->Dados['tipo'];
        $this->Situacao = $this->Dados['situacao'];
        $this->Solucao = $this->Dados['solucao'];
        $this->Justificativa = $this->Dados['obs_justificativa'];
        $this->ImagemUm = $this->Dados['img_um'];
        $this->ImagemDois = $this->Dados['img_dois'];
        $this->ImagemTres = $this->Dados['img_tres'];
        $this->Resposta = $this->Dados['obs_resposta'];

        if (!empty($this->Dados['status_id']) and $this->Dados['status_id'] == 1) {
            unset($this->Dados['tipo'], $this->Dados['situacao'], $this->Dados['solucao'], $this->Dados['obs_justificativa'], $this->Dados['img_um'], $this->Dados['img_dois'], $this->Dados['img_tres'], $this->Dados['obs_resposta']);
        }

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBalancoProduto();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBalancoProduto() {

        $this->Dados['tipo'] = $this->Tipo;
        $this->Dados['situacao'] = $this->Situacao;
        $this->Dados['solucao'] = $this->Solucao;
        $this->Dados['obs_justificativa'] = $this->Justificativa;
        $this->Dados['img_um'] = $this->ImagemUm;
        $this->Dados['img_dois'] = $this->ImagemDois;
        $this->Dados['img_tres'] = $this->ImagemTres;
        $this->Dados['obs_resposta'] = $this->Resposta;

        if (!empty($this->Dados['img_um'])) {
            $slugImgUm = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['img_um'] = $slugImgUm->nomeSlug($this->ImagemUm['name']);
            $this->Dados['img_um'] = ucfirst($this->Dados['img_um']);
        }

        if (!empty($this->Dados['img_dois'])) {
            $slugImgDois = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['img_dois'] = $slugImgDois->nomeSlug($this->ImagemDois['name']);
            $this->Dados['img_dois'] = ucfirst($this->Dados['img_dois']);
        }

        if (!empty($this->Dados['img_tres'])) {
            $slugImgTres = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['img_tres'] = $slugImgTres->nomeSlug($this->ImagemTres['name']);
            $this->Dados['img_tres'] = ucfirst($this->Dados['img_tres']);
        }

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBalanco = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBalanco->exeUpdate("adms_balanco_produtos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBalanco->getResult()) {
            if (empty($this->ImagemUm['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $upAltBalanco->getResultado();
                $this->ImgUm();
                $this->ImgDois();
                $this->ImgTres();
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    private function ImgUm() {

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->ImagemUm, 'assets/imagens/balanco/' . $this->DirId . '/', $this->Dados['img_um']);

        if ($uploadArq->getResultado()) {
            if ($uploadArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Arquivos</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Arquivo cadastrado, porém não foi enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Arquivo </strong> cadastrado com sucesso, arquivo não enviado, excede o tamanho máximo de 4M!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function ImgDois() {

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->ImagemDois, 'assets/imagens/balanco/' . $this->DirId . '/', $this->Dados['img_dois']);

        if ($uploadArq->getResultado()) {
            if ($uploadArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Arquivos</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Arquivo cadastrado, porém não foi enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Arquivo </strong> cadastrado com sucesso, arquivo não enviado, excede o tamanho máximo de 4M!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function ImgTres() {

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->ImagemTres, 'assets/imagens/balanco/' . $this->DirId . '/', $this->Dados['img_tres']);

        if ($uploadArq->getResultado()) {
            if ($uploadArq->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Arquivos</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Arquivo cadastrado, porém não foi enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Arquivo </strong> cadastrado com sucesso, arquivo não enviado, excede o tamanho máximo de 4M!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id b_id, loja_id, ciclo_id FROM adms_balancos ORDER BY id DESC");
        $registro['balanco'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_status_balancos ORDER BY id ASC");
        $registro['sits'] = $listar->getResult();

        $listar->fullRead("SELECT id tam_id, nome tam FROM tb_tam ORDER BY nome ASC");
        $registro['tam_id'] = $listar->getResult();

        $listar->fullRead("SELECT id situ_id, nome situacao FROM adms_sits_balanco_produto");
        $registro['situ_id'] = $listar->getResult();

        $listar->fullRead("SELECT id c_id, nome ciclo FROM adms_ciclos WHERE status_id <=:status_id ORDER BY id DESC", "status_id=4");
        $registro['ciclo'] = $listar->getResult();

        $this->Resultado = ['balanco' => $registro['balanco'], 'situ_id' => $registro['situ_id'], 'tam_id' => $registro['tam_id'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }

}
