<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarLoja: 
 * Classe para editar as informações do cadastro das lojas no banco de dados
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarLoja {

    private $Resultado;
    private $Dados;
    private $DadosId;

    /**
     * <b>Obter Resultado:</b> Retorna TRUE caso tenha editado com sucesso e FALSE quando não conseguiu editar
     * @return BOOL true ou false
     */
    function getResultado() {
        return $this->Resultado;
    }

    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verLoja($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verLoja = new \App\adms\Models\helper\AdmsRead();
        $verLoja->fullRead("SELECT lj.*, r.nome rede, s.nome sit FROM tb_lojas lj INNER JOIN tb_redes r ON r.id=lj.rede_id INNER JOIN tb_status_loja s ON s.id=lj.status_id INNER JOIN tb_funcionarios f ON f.id=lj.func_id WHERE lj.id_loja =:id_loja LIMIT :limit", "id_loja=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verLoja->getResultado();
        return $this->Resultado;
    }

    /**
     * <b>Editar Página:</b> Receber array de Dados com as informações da página
     * @param ARRAY $Dados
     */
    public function altLoja(array $Dados) {
        $this->Dados = $Dados;

        $this->Dados['cnpj'] = str_replace("-", "", str_replace("/", "", str_replace(".", "", $this->Dados['cnpj'])));
        $this->Dados['ins_estadual'] = str_replace(".", "", str_replace("-", "", $this->Dados['ins_estadual']));

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditLojas();
        } else {
            $this->Resultado = false;
        }
    }

    /**
     * <b>Editar Página no Banco de Dados:</b> Instanciar a classe responsável em editar no banco de dados
     * Verificar o status da ação, true ou false
     */
    private function updateEditLojas() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltLoja = new \App\adms\Models\helper\AdmsUpdate();
        $upAltLoja->exeUpdate("tb_lojas", $this->Dados, "WHERE id_loja =:id_loja", "id_loja=" . $this->Dados['id_loja']);
        if ($upAltLoja->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro da Loja atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro da Loja não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações nas tabelas "adms_grps_pgs, adms_tps_pgs, adms_sits_pgs" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_sit, nome sit FROM tb_status_loja ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_rede, nome rede FROM tb_redes ORDER BY nome ASC");
        $registro['rede'] = $listar->getResultado();

        $listar->fullRead("SELECT id func_id, nome func FROM tb_funcionarios WHERE cargo_id =:cargo_id AND status_id =:status_id ORDER BY nome ASC", "cargo_id=2&status_id=1");
        $registro['func_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id super_id, nome super FROM adms_usuarios WHERE adms_niveis_acesso_id IN (1, 2, 8, 9) ORDER BY nome ASC");
        $registro['super_id'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit'], 'rede' => $registro['rede'], 'func_id' => $registro['func_id'], 'super_id' => $registro['super_id']];

        return $this->Resultado;
    }

}
