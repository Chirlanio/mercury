<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_ped'][0])) {
    extract($this->Dados['dados_ped'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo d-print-none">Detalhes da Entrega</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_ped']) {
                            echo "<a href='" . URLADM . "delivery/listar' class='btn btn-outline-info btn-sm d-print-none'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_ped']) {
                            echo "<a href='" . URLADM . "editar-delivery/edit-delivery/$id' class='btn btn-outline-warning btn-sm d-print-none'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_ped']) {
                            echo "<a href='" . URLADM . "apagar-delivery/apagar-delivery/$id' class='btn btn-outline-danger btn-sm d-print-none' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_ped']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delivery/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_ped']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-delivery/edit-delivery/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_ped']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-delivery/apagar-delivery/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr class="d-print-none">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'] . "<div class='alert alert-" . ($status_id == 5 ? 'success' : 'warning') . "'>Situação do Pedido: <span>$sit</span></div>";
                unset($_SESSION['msg']);
            }
            ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="4"><img src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Grupo Meia Sola" width="200" height="90"></th>
                        <th colspan="8" class="table-active text-center display-4">Formulário de Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Loja:</th>
                        <td colspan="3" class="text-center"><?php echo $loja; ?></td>
                        <th colspan="1" class="text-center">Gerente: </th>
                        <td colspan="8" class="text-center"><?php echo $func; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Cliente:</th>
                        <td colspan="3"><?php echo $cliente; ?></td>
                        <th colspan="1" class="text-center">Contato: </th>
                        <td colspan="8" class="text-center"><?php echo $contato; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Endereço:</th>
                        <td colspan="10"><?php echo $endereco; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Bairro:</th>
                        <td colspan="10"><?php echo $bairro; ?></td>
                    </tr>
                    <tr>
                        <th colspan="12" scope="row" class="table-active text-center">PAGAMENTO NA ROTA</th>
                    </tr>
                    <tr>
                        <th scope="row">Valor da Venda:</th>
                        <td colspan="2" class="text-center<?php echo ($presente == 1 ? ' d-print-none' : ''); ?>"><?php echo 'R$ ' . $valor_venda; ?></td>
                        <th colspan="1" scope="row">Troca: </th>
                        <td colspan="9"><?php
                            if ($troca == 1) {
                                echo "Sim";
                            } else {
                                echo "Não";
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tipo de Pagamento:</th>
                        <td colspan="6"><?php echo $forma; ?></td>
                        <th scope="row">Parcelas:</th>
                        <td colspan="6"><?php echo $parcelas . "X"; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Maquineta:</th>
                        <td colspan="12"><?php
                            if ($maq == 1) {
                                echo "Sim";
                            } else {
                                echo "Não";
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Observações:</th>
                        <td colspan="12"><?php echo $obs; ?></td>
                    </tr>
                    <tr>
                        <th colspan="12" scope="row" class="table-active text-center">UM PASSO A FRENTE FAZENDO SEMPRE MAIS</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Entrega não encontrada!</div>";
    $UrlDestino = URLADM . 'delivery/listar';
    header("Location: $UrlDestino");
}
