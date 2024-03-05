<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerOrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerOrdemServico {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Estorno:</b> Receber o id da solicitação de ordem de servoço para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verOrdemServico($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $verOrdemServico = new \App\adms\Models\helper\AdmsRead();
        $verOrdemServico->fullRead("SELECT os.*, lj.nome loja, se.nome sit, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto, dl.descricao defeito, do.descricao detalhe, ld.descricao local FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id LEFT JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto INNER JOIN adms_sits_ordem_servico se ON se.id=os.status_id INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.type_order_id INNER JOIN tb_tam t ON t.id=os.tam_id INNER JOIN adms_marcas m ON m.id=os.marca_id INNER JOIN adms_defeitos_ordem_servico dl ON dl.id=os.def_id INNER JOIN adms_detalhes_ordem_servico do ON do.id=os.det_id INNER JOIN adms_def_local_ordem_servico ld ON ld.id=os.loc_id WHERE os.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verOrdemServico->getResult();
        return $this->Resultado;
    }

}
