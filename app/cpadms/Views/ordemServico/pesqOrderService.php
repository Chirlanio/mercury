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
                <h2 class="display-4 titulo">Ordens de Serviços</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_order_service']) {
                        echo "<a href='" . URLADM . "ordem-servico/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_order_service']) {
                        echo "<a href='" . URLADM . "cadastrar-ordem-servico/cad-ordem-servico' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['cad_order_service']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "estorno/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_estorno']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-estorno/cad-estorno'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'pesq-order-service/listar'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por Cliente, Loja, Referência ou ID" value="<?php
                        if (isset($_SESSION['search'])) {
                            echo $_SESSION['search'];
                        }
                        ?>" autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqOrderService" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['listOrderService'])) {
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
        ?><hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Loja</th>
                        <th class="text-center d-none d-sm-table-cell">O.S</th>
                        <th class="text-center d-none d-sm-table-cell">Referência</th>
                        <th class="text-center d-none d-sm-table-cell">Tamanho</th>
                        <th class="text-center d-none d-sm-table-cell">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listOrderService'])) {
                        foreach ($this->Dados['listOrderService'] as $orderService) {
                            extract($orderService);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $id; ?></th>
                                <td class="text-center align-middle"><?php echo $loja; ?></td>
                                <td class="text-center align-middle"><?php echo $order_service; ?></td>
                                <td class="text-center d-none d-sm-table-cell align-middle"><?php echo $referencia; ?></td>
                                <td class="text-center d-none d-sm-table-cell align-middle"><?php echo $tam; ?></td>
                                <td class="text-center d-none d-sm-table-cell align-middle text-center">
                                    <span class="badge badge-<?php echo $cor; ?>"><?php echo $status; ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_order_service']) {
                                            echo "<a href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['edit_order_service']) {
                                            echo "<a href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['del_order_service']) {
                                            echo "<a href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_order_service']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_order_service']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_order_service']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
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