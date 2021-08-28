<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsListarCadProdutos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class StsListarCadProdutos {

    private $Resultado;

    public function listar() {
        
        $listar = new \Sts\Models\helper\StsRead();
        //$listar->exeRead('tb_dashboards', 'WHERE status_id =:status_id LIMIT :limit', 'status_id=1&limit=4');
        $listar->fullRead('SELECT c.id , c.nome as consultora, c.loja_id, c.referencia,
            c.marca, c.status_id,
            lj.nome as nomeLoja,
            s.nome as status
            FROM tb_cad_produtos c
            LEFT JOIN tb_lojas lj ON lj.id=c.loja_id
            LEFT JOIN tb_status s ON s.id=c.status_id
            ORDER BY c.id DESC');
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
