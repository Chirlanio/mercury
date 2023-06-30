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
                <h2 class="display-4 titulo">Lista de Arquivos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_arq']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-arquivo/cad-arquivo'; ?>">
                    <div class="p-2">
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
        <?php
        if (empty($this->Dados['listArq'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum arquivo encontrado!
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
                        <th class="d-none d-sm-table-cell">Nome</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Cadastrado</th>
                        <th class="d-none d-sm-table-cell">Atualizado</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listArq'] as $arquivo) {
                        extract($arquivo);
                        ?>
                <th class="text-center"><?php echo $id; ?></th>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $loja; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($created)); ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo (!empty($modified) ? date('d/m/Y', strtotime($modified)) : ''); ?></td>
                    <td class="d-none d-sm-table-cell text-center"><?php echo $status; ?></td>
                    <td class="text-center">
                        <span class="d-none d-md-block">
                            <?php
                            echo "<a href='" . URLADM . "assets/files/downloads/$id/$slug' class='btn btn-outline-success btn-sm' title='Baixar' download><i class='fa-solid fa-download'></i></a> ";
                            if ($this->Dados['botao']['edit_arq']) {
                                echo "<a href='" . URLADM . "editar-arquivo/edit-arquivo/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fa-solid fa-pen-nib'></i></a> ";
                            }
                            if ($this->Dados['botao']['del_arq']) {
                                echo "<a href='" . URLADM . "apagar-arquivo/apagar-arquivo/$id' class='btn btn-outline-danger btn-sm' title='Apagar' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i></a> ";
                            }
                            ?>
                        </span>
                        <div class="dropdown d-block d-md-none">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?php
                                echo "<a class='dropdown-item' href='" . URLADM . "assets/files/downloads/$id/$slug'>Baixar</a>";
                                if ($this->Dados['botao']['edit_arq']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-arquivo/edit-arquivo/$id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_arq']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-arquivo/apagar-arquivo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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