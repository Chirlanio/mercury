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
                <h2 class="display-4 titulo">Listar Bairros</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_bairro']) {
                    echo "<a href='" . URLADM . "cadastrar-bairro/cad-bairro' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>                
            </div>

        </div>
        <?php
        if (empty($this->Dados['listBairro'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum Bairro encontrado!
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
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nome</th>
                        <th>Rota</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listBairro'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id_bai; ?></th>
                            <td class="align-middle"><?php echo $bairro; ?></td>
                            <td class="align-middle"><?php echo $rota; ?></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_bairro']) {
                                        echo "<a href='" . URLADM . "ver-bairro/ver-bairro/$id_bai' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_bairro']) {
                                        echo "<a href='" . URLADM . "editar-bairro/edit-bairro/$id_bai' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_bairro']) {
                                        echo "<a href='" . URLADM . "apagar-bairro/apagar-bairro/$id_bai' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_bairro']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-bairro/ver-bairro/$id_bai'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_bairro']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-bairro/edit-bairro/$id_bai'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_bairro']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-bairro/apagar-bairro/$id_bai' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
