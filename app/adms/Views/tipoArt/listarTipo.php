<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Tipo - Artigo</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_tipo']) {
                    echo "<a href='" . URLADM . "cadastrar-tipo/cad-tipo' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>                
            </div>
        </div><hr>
        <?php
        if (empty($this->Dados['listTipo'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum tipo de artigo encontrado!
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
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cadastrado</th>
                        <th>Atualizado</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listTipo'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th><?php echo $id; ?></th>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></td>
                            <td><?php echo (!empty($modified) ? date('d/m/Y H:i:s', strtotime($modified)) : ""); ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_tipo']) {
                                        echo "<a href='" . URLADM . "ver-tipo/ver-tipo/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->Dados['botao']['edit_tipo']) {
                                        echo "<a href='" . URLADM . "editar-tipo/edit-tipo/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_tipo']) {
                                        echo "<a href='" . URLADM . "apagar-tipo/apagar-tipo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_tipo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-tipo/ver-tipo/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_tipo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-tipo/edit-tipo/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_tipo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-tipo/apagar-tipo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
