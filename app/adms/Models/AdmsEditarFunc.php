<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarFunc {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Cupom;

    function getResultado() {
        return $this->Resultado;
    }

    public function verFunc($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verFunc = new \App\adms\Models\helper\AdmsRead();
        $verFunc->fullRead("SELECT f.id, f.nome, f.usuario, f.cpf, f.cupom_site, f.loja_id, f.cargo_id, f.adms_area_id, f.status_id, s.id sit_id, s.nome sit, c.nome loja
                FROM tb_funcionarios f
                INNER JOIN tb_lojas lj ON lj.id=f.loja_id
                INNER JOIN tb_status s ON s.id=f.status_id
                INNER JOIN tb_cargos c ON c.id=f.cargo_id
                LEFT JOIN adms_areas a ON a.id=f.adms_area_id
                WHERE f.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verFunc->getResult();
        return $this->Resultado;
    }

    public function altFunc(array $Dados) {

        $this->Dados = $Dados;
        
        $this->Cupom = $this->Dados['cupom_site'];
        unset($this->Dados['cupom_site']);
        
        $this->Dados['cpf'] = str_replace('.', '', str_replace('-', '', $this->Dados['cpf']));

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditFunc();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditFunc() {
        
        $this->Dados['cupom_site'] = strtoupper($this->Cupom);
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        
        $upAltFunc = new \App\adms\Models\helper\AdmsUpdate();
        $upAltFunc->exeUpdate("tb_funcionarios", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltFunc->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O cadsatro não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarFunc() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResult();

        $listar->fullRead("SELECT id cargo_id, nome cargo FROM tb_cargos ORDER BY nome ASC");
        $registro['cargo_id'] = $listar->getResult();
        
        $listar->fullRead("SELECT id area_id, name name_area FROM adms_areas WHERE status_id =:sits", "sits=1");
        $registro['areas'] = $listar->getResult();

    $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'cargo_id' => $registro['cargo_id'], 'areas' => $registro['areas']];

        return $this->Resultado;
    }

}
