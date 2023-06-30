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
                <h2 class="display-4 titulo">Pesquisar Solicitações de Estornos</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_estorno']) {
                        echo "<a href='" . URLADM . "estorno/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_estorno']) {
                        echo "<a href='" . URLADM . "cadastrar-estorno/cad-estorno' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_estorno']) {
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
        <form class="form" method="POST" action="<?php echo URLADM . 'pesq-estorno/listar'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por cliente, loja, situação ou ID" value="<?php
                        if (isset($_SESSION['search'])) {
                            echo $_SESSION['search'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqEstorno" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['listEstorno'])) {
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
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Cliente</th>
                        <th class="d-none d-sm-table-cell">Tipo</th>
                        <th class="d-none d-sm-table-cell text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listEstorno'])) {
                        foreach ($this->Dados['listEstorno'] as $estorno) {
                            extract($estorno);
                            ?>
                            <tr>
                                <th class="align-middle text-center"><?php echo $id; ?></th>
                                <td class="align-middle"><?php echo $nome_loja; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $nome_cliente; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo ($adms_tps_est_id == 1) ? "Total" : "Parcial"; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center">
                                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $status; ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_estorno']) {
                                            echo "<a href='" . URLADM . "ver-estorno/ver-estorno/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['edit_estorno']) {
                                            echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['del_estorno']) {
                                            echo "<a href='" . URLADM . "apagar-estorno/apagar-estorno/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_estorno']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-estorno/ver-estorno/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_estorno']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_estorno']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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