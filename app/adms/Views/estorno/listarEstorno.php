<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Solicitações de Estornos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_estorno']) {
                echo "<a href='" . URLADM . "cadastrar-estorno/cad-estorno' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
            }
            ?>
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
        if (empty($this->Dados['list_estorno'])) {
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
                        <th>ID</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Cliente</th>
                        <th class="d-none d-sm-table-cell">Tipo</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['list_estorno'] as $estorno) {
                        extract($estorno);
                        ?>
                    <th><?php echo $id; ?></th>
                    <td><?php echo $loja; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo $nome_cliente; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo ($adms_tps_est_id == 1) ? "Total" : "Parcial"; ?></td>
                    <td class="d-none d-sm-table-cell align-middle text-center">
                        <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $tipo; ?></span>
                    </td>
                    <td class="text-center">
                        <span class="d-none d-md-block">
                            <?php
                            if ($this->Dados['botao']['vis_estorno']) {
                                echo "<a href='" . URLADM . "ver-estorno/ver-estorno/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                            }
                            if ($this->Dados['botao']['edit_estorno']) {
                                echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                            }
                            if ($this->Dados['botao']['del_estorno']) {
                                echo "<a href='" . URLADM . "apagar-estorno/apagar-estorno/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                ?>
                </tbody>
            </table>
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>