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
    </head>
    <body>
        <?php
        $arquivo = 'ordens-pagamentos.xls';

        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="1" class="table table-striped table-hover table-bordered">';
        $html .= '<tr>';
        $html .= '<th colspan="26">Ordens de Pagamentos</th>';
        $html .= '</tr>';

        $html .= "<tr>";
        $html .= "<th class='d-none d-sm-table-cell'>ID</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Área</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Centro de Custo</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Marca</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Pagamento</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Gerência</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Fornecedor</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Descrição</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Valor total</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Forma de Pagamento</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Adiantamento</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Valor Adiantamento</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Diferença</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Nota fiscal</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Banco</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Agência</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Conta Corrente</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Titular</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Tipo de Chave - PIX</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Chave PIX</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Comprovante</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cadastrado Por</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Atualizado Por</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Situaçao</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cadastro</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Atualizado</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        foreach ($this->Dados['listOrder'] as $c) {
            extract($c);
            $html .= "<tr>";
            $html .= "<th class='d-none d-sm-table-cell'>" . $op_id . "</th>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $area . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $costCenter . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $brand . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . date("d/m/Y", strtotime($date_payment)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $manager . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $supplier . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $description . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>R$ " . number_format($total_value, 2, ',', '.') . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $typePayment . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . ($advance == 1 ? "Sim" : "Não") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>R$ " . number_format($advance_amount, 2, ',', '.') . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>R$ " . number_format($diff_payment_advance, 2, ',', '.') . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($number_nf) ? $number_nf : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($bank) ? $bank : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($agency) ? $agency : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($checking) ? $checking : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $name_supplier . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $typeKey . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $key_pix . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $file_name . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $create_user . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $update_user . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $sit . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . date('d/m/Y H:i:s', strtotime($created)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($modified) ? date('d/m/Y H:i:s', strtotime($modified)) : "") . "</td>";
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

