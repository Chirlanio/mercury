<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">
                    <?php
                    echo "Solicitações de Estoque de Vendas";
                    if (!empty($this->Dados['dados_auto'])) {
                        echo " - {$this->Dados['dados_auto'][0]['nome']}";
                    }
                    ?>
                </h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_resp']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'autorizacao-resp/listar'; ?>" class="btn btn-outline-info btn-sm">Voltar</a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if (empty($this->Dados['listResp'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma solicitação encontrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="align-middle">Loja</th>
                        <th class="align-middle">Cliente</th>
                        <th class="d-none d-sm-table-cell">Valor Lançado</th>
                        <th class="d-none d-sm-table-cell">Valor Correto</th>
                        <th class="align-middle">Tipo</th>
                        <th class="align-middle">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qnt_linhas_exe = 1;
                    foreach ($this->Dados['listResp'] as $pedido) {
                        extract($pedido);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $loja; ?></td>
                            <td class="align-middle"><?php echo $nome_cliente; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo "R$ " . str_replace('.', ',', $valor_lancado); ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo "R$ " . str_replace('.', ',', $valor_correto); ?></td>
                            <td class="align-middle"><?php echo ($adms_tps_est_id == 1) ? "Total" : "Parcial"; ?></td>
                            <td class="align-middle">
                                <?php
                                if ($this->Dados['botao']['lib_resp']) {
                                    if ($adms_sits_est_id == 1) {
                                        echo "<span class='badge badge-pill badge-warning'>Aguardando</span>";
                                    } elseif ($adms_sits_est_id == 2) {
                                        echo "<a href='" . URLADM . "lib-resp/lib-resp/$id?resp={$this->Dados['dados_auto'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-info'>Aguardando Autorização</span></a>";
                                    } elseif ($adms_sits_est_id == 3) {
                                        echo "<a href='" . URLADM . "lib-resp/lib-resp/$id?resp={$this->Dados['dados_auto'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-primary'>Autorizado</span></a>";
                                    } elseif ($adms_sits_est_id == 4) {
                                        echo "<span class='badge badge-pill badge-dark'>Aguardando Financeira</span>";
                                    } else {
                                        echo "<span class='badge badge-pill badge-success'>Estornado</span>";
                                    }
                                } else {
                                    if ($adms_sits_est_id == 1) {
                                        echo "<span class='badge badge-pill badge-warning'>Aguardando</span>";
                                    } elseif ($adms_sits_est_id == 2) {
                                        echo "<span class='badge badge-pill badge-info'>Agurdando Autorização</span>";
                                    } elseif ($adms_sits_est_id == 3) {
                                        echo "<span class='badge badge-pill badge-primary'>Autorizado</span>";
                                    } elseif ($adms_sits_est_id == 4) {
                                        echo "<span class='badge badge-pill badge-dark'>Aguardando Financeira</span>";
                                    } else {
                                        echo "<span class='badge badge-pill badge-success'>Estornado</span>";
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>
