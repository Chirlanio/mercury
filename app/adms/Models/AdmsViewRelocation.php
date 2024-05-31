<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewRelocation
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewRelocation {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;
    private $Dados;
    private $DadosId;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listRelocation($PageId = null, $Dados = null) {
        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'view-relocation/view-relocation', "?id={$this->Dados['id']}&origem=" . $this->Dados['origem'] . "&destino={$this->Dados['destino']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(ri.id) AS num_result FROM adms_relocation_items ri WHERE ri.adms_relocation_id =:id AND ri.source_store_id =:source AND ri.destination_store_id =:destination AND ( (SELECT adms_sit_relocation_id FROM adms_relocations WHERE id=ri.adms_relocation_id AND adms_sit_relocation_id = 1 ) = 1)", "id={$this->Dados['id']}&source={$this->Dados['origem']}&destination=" . $this->Dados['destino']);
        $this->ResultadoPg = $paginacao->getResultado();

        $listRelocation = new \App\adms\Models\helper\AdmsRead();
        $listRelocation->fullRead("SELECT ri.id ri_id, ri.adms_relocation_id, ri.source_store_id, ri.destination_store_id,
                ri.product_reference, ri.size ri_size, ri.quantity_requested, ri.amount_received, lj.nome loja_destino, st.name_sit, c.cor
                FROM adms_relocation_items ri
                LEFT JOIN tb_lojas lj ON lj.id = ri.destination_store_id
                LEFT JOIN adms_sit_relocations st ON st.id = ri.adms_sit_relocation_id
                LEFT JOIN adms_cors c ON c.id = st.adms_cor_id
                WHERE ri.adms_relocation_id =:id
                AND ri.source_store_id =:source
                AND ri.destination_store_id =:destination
                AND (
                        (SELECT adms_sit_relocation_id
                        FROM adms_relocations
                        WHERE id=ri.adms_relocation_id 
                        AND adms_sit_relocation_id = 1
                        ) = 1
                    )
                    GROUP BY ri.adms_relocation_id, ri.source_store_id, ri.destination_store_id, ri.product_reference
                    ORDER BY ri.source_store_id ASC, ri.destination_store_id ASC, ri.product_reference ASC, ri.size ASC
                    LIMIT :limit OFFSET :offset", "id={$this->Dados['id']}&source={$this->Dados['origem']}&destination={$this->Dados['destino']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listRelocation->getResult();
        return $this->Resultado;
    }

    public function viewQuantity($DadosId) {
        $this->DadosId = (int) $DadosId;

        $product = new \App\adms\Models\helper\AdmsRead();
        $product->fullRead("SELECT id, product_reference, size
                FROM adms_relocation_items 
                WHERE adms_relocation_id =:id
                AND source_store_id =:source
                AND destination_store_id =:destination", "id={$this->DadosId}&source={$this->Dados['origem']}&destination={$this->Dados['destino']}");
        $this->Dados['product_reference'] = $product->getResult();
        var_dump($this->Dados['product_reference']);
        foreach ($this->Dados['product_reference'] as $product) {
            extract($product);
            //var_dump($product);
            $quantity = new \App\adms\Models\helper\AdmsRead();
            $quantity->fullRead("SELECT id q_id, adms_relocation_id, destination_store_id, product_reference, size, quantity_requested
                FROM  adms_relocation_items
                WHERE adms_relocation_id =:id_p
                AND product_reference =:product
                AND source_store_id =:source
                AND destination_store_id =:destination
                GROUP BY id, adms_relocation_id, source_store_id, destination_store_id, product_reference", "id_p={$this->DadosId}&product={$product['product_reference']}&source={$this->Dados['origem']}&destination={$this->Dados['destino']}");
            $values = $quantity->getResult();
            //var_dump($this->Resultado);
            //return $this->Resultado;
            $this->Resultado = [];
            foreach ($values as $key => $value) {
                extract($value);
                $this->Resultado[] = [
                    'q_id' => $value['q_id'],
                    'adms_relocation_id' => $value['adms_relocation_id'],
                    'destination_store_id' => $value['destination_store_id'],
                    'product_reference' => $value['product_reference'],
                    'size' => $value['size'],
                    'quantity_requested' => $value['quantity_requested']
                ];
                
            }
            var_dump($this->Resultado);
        }
    }

    public function viewRelocation($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT id, product_reference, size FROM adms_relocation_items WHERE adms_relocation_id =:id GROUP BY size ORDER BY size ASC LIMIT :limit", "id=" . $this->DadosId . "&limit={$this->LimiteResultado}");
        $this->Resultado = $verNivAc->getResult();
        return $this->Resultado;
    }
}
