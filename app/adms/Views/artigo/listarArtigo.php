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
                <h2 class="display-4 titulo">Campanhas & Novidades</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_artigo']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-artigo/cad-artigo'; ?>">
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
        if (empty($this->Dados['listArtigo'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum artigo encontrado!
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
                        <th class="d-none d-sm-table-cell">Titulo</th>
                        <th class="d-none d-sm-table-cell">Data Inicial</th>
                        <th class="d-none d-sm-table-cell">Data Final</th>
                        <th class="d-none d-sm-table-cell">Tipo</th>
                        <th class="d-none d-sm-table-cell">Categoria</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listArtigo'] as $Ajuste) {
                        extract($Ajuste);
                        ?>
                            <th><?php echo $id; ?></th>
                            <td><?php echo $titulo; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($dataInicial)); ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($dataFinal)); ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $tipo; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $cat; ?></td>
                            <td class="d-none d-sm-table-cell text-center"><span class="badge badge-<?php echo $color;?>"><?php echo $status; ?></span></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_artigo']) {
                                        echo "<a href='" . URLADM . "ver-artigo/ver-artigo/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->Dados['botao']['edit_artigo']) {
                                        echo "<a href='" . URLADM . "editar-artigo/edit-artigo/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_artigo']) {
                                        echo "<a href='" . URLADM . "apagar-artigo/apagar-artigo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_artigo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-artigo/ver-artigo/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_artigo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-artigo/edit-artigo/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_artigo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-artigo/apagar-artigo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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