<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Bandeiras</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_bandeira']) {
                    echo "<a href='" . URLADM . "cadastrar-bandeira/cad-bandeira' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                }
                ?>                
            </div>
        </div>
        <?php
        if (empty($this->Dados['listBandeira'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma Bandeira encontrada!
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
                        <th class="text-center">Nome</th>
                        <th class="text-center">Icone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listBandeira'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id_bai; ?></th>
                            <td class="align-middle"><?php echo $bairro; ?></td>
                            <td class="text-center align-middle"><?php echo "<i class='" . $icone . " fa-3x'></i>"; ?></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_bandeira']) {
                                        echo "<a href='" . URLADM . "ver-bandeira/ver-bandeira/$id_bai' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_bandeira']) {
                                        echo "<a href='" . URLADM . "editar-bandeira/edit-bandeira/$id_bai' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_bandeira']) {
                                        echo "<a href='" . URLADM . "apagar-bandeira/apagar-bandeira/$id_bai' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_bandeira']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-bandeira/ver-bandeira/$id_bai'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_bandeira']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-bandeira/edit-bandeira/$id_bai'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_bandeira']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-bandeira/apagar-bandeira/$id_bai' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
