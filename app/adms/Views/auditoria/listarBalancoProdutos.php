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
                <h2 class="display-4 titulo">Divergências - Produtos</h2>
            </div>
            <div class="p-2 d-flex">
                <?php
                if ($this->Dados['botao']['list_balanco']) {
                    ?>
                    <a href="<?php echo URLADM . 'balanco/listar'; ?>">
                        <div class="mr-1">
                            <button class="btn btn-outline-info btn-sm"><span><i class="fas fa-search d-block d-md-none fa-2x"></i>
                                    <span class='d-none d-md-block'>Listar</span>
                                </span>
                            </button>
                        </div>
                    </a>
                    <?php
                }
                if ($this->Dados['botao']['cad_balanco']) {
                    ?>
                    <a href="<?php echo URLADM . 'cadastrar-balanco-produto/cad-produto/?id=' . $_SESSION['id']; ?>">
                        <div>
                            <button class="btn btn-outline-success btn-sm"><span><i class="fas fa-plus d-block d-md-none fa-2x"></i>
                                    <span class='d-none d-md-block'>Cadastrar</span>
                                </span>
                            </button>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>

        <hr>
        <?php
        if (empty($this->Dados['listBalanco'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma registro encontrado!
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
        <div class="content">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Foto</th>
                            <th>Referência</th>
                            <th class="d-none d-sm-table-cell text-center">Código de barras</th>
                            <th>Tam</th>
                            <th class="d-none d-sm-table-cell text-center">Estoque</th>
                            <th class="d-none d-sm-table-cell text-center">Contagem</th>
                            <th class="d-none d-sm-table-cell text-center">Divergência</th>
                            <th class="d-none d-sm-table-cell text-center">Tipo</th>
                            <th class="d-none d-sm-table-cell text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->Dados['listBalanco'] as $balanco) {
                            extract($balanco);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $id; ?></th>
                                <td class="align-middle text-center" ><?php echo "<img class='imagem img-thumbnail' src='http://www.meiasola.com/powerbi/$referencia.jpg' alt='$referencia' />"; ?></td>
                                <td class="align-middle text-center" ><?php echo $referencia; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $cod_barras; ?></td>
                                <td class="align-middle text-center"><?php echo $tam; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $qtde_estoque; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $qtde_contagem; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $qtde_divergencia; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $tipo == 1 ? "Sobra" : "Falta"; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $status; ?></td>
                                <td class="text-center align-middle">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_balanco_produto']) {
                                            echo "<a href='" . URLADM . "ver-balanco-produto/ver-balanco/$id?id=" . $_SESSION['id'] . "' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['edit_balanco_produto']) {
                                            echo "<a href='" . URLADM . "editar-balanco-produto/edit-balanco/$id?id=" . $_SESSION['id'] . "' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['del_balanco_produto']) {
                                            echo "<a href='" . URLADM . "apagar-balanco-produto/apagar-balanco/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_balanco_produto']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-balanco-produto/ver-balanco/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_balanco_produto']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-balanco-produto/edit-balanco/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_balanco_produto']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-balanco-produto/apagar-balanco/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
</div>