<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Gerar Planilha</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        $arquivo = 'Ordens Serviços.xls';

        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="1" class="table table-striped table-hover table-bordered">';
        $html .= '<tr>';
        $html .= '<th colspan="36" style="font-size: 20px;">Ordens de Serviços - WFA</th>';
        $html .= '</tr>';

        $html .= "<tr>";
        $html .= "<th>ID</th>";
        $html .= "<th>Loja</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Referência</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Tam</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Marca</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Tipo</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cliente</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Qtde</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Defeito</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Detalhe do defeito</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Local do defeito</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Ordem de Serviço (CIGAM)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Cadastro (CIGAM)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Ordem de Serviço (ZZNet)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Cadastro (ZZNet)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Nº Nota Transferência</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Emissão</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Confirmação</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Diferença</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Loja de Conserto</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Nota de Devolução</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Emissão</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Nota de Retorno</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Emissão</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Confirmação</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Nota de Transferência (Saldo)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data de Emissão</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Observações (Loja)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Indenizado</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Indenização</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Nota de Devolução (Fornecedor)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Emissão</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Observações (Qualidade)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Situação</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cadastrado</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Atualizado</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        foreach ($this->Dados['listPlanilha'] as $c) {
            extract($c);
            $html .= "<tr>";
            $html .= "<th>" . $id . "</th>";
            $html .= "<td>" . $loja . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $referencia . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $tam . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $marca . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $type_order . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>";
            $html .= "<span>" . $client_name . "</span>";
            $html .= "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $qtde . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . utf8_decode($defeito) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . utf8_decode($detalhe) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . utf8_decode($local) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $order_service . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($date_order_service) ? date('d/m/Y', strtotime($date_order_service)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $order_service_zznet . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($date_order_service_zznet) ? date('d/m/Y', strtotime($date_order_service_zznet)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $num_nota_transf . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_emissao_nota_transf) ? date('d/m/Y', strtotime($data_emissao_nota_transf)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_confir_nota_transf) ? date('d/m/Y', strtotime($data_confir_nota_transf)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $data_dif_emissao_confir . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $lj_conserto . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $nf_conserto_devolucao . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_emissao_conserto) ? date('d/m/Y', strtotime($data_emissao_conserto)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $nf_retorno_conserto . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_emissao_retorno_conserto) ? date('d/m/Y', strtotime($data_emissao_retorno_conserto)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_confir_retorno_conserto) ? date('d/m/Y', strtotime($data_confir_retorno_conserto)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $nf_transf_saldo_produto . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_nota_transf_saldo_produto) ? date('d/m/Y', strtotime($data_nota_transf_saldo_produto)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $obs_loja . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . ($indenizado == 1 ? "Não" : "Sim") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_indenizado) ? date('d/m/Y', strtotime($data_indenizado)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $nf_devolucao_fornecedor . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($data_emissao_nf_devolucao) ? date('d/m/Y', strtotime($data_emissao_nf_devolucao)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $obs_qualidade . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $status . "</td>";
            $html .= "<td class='d-none d-sm-table-cell d-print-none'>" . date('d/m/Y H:i:s', strtotime($created)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell d-print-none'>" . (!empty($modified) ? date('d/m/Y H:i:s', strtotime($modified)) : "") . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>";
        $html .= "</table>";
        // Configurações header para forçar o download
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header("Content-Description: PHP Generated Data");
        // Envia o conteúdo do arquivo
        echo $html;
        exit;
        ?>
    </body>
</html>

