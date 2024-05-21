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
                <h2 class="display-4 titulo">Políticas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['add_policies']) {
                echo "<a href='" . URLADM . "add-policies/add-policie' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a>";
            }
            ?>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listPolicies'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma política encontrada!
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
        <div class="accordion" id="accordionExample">
            <div class="table-responsive">
                <?php
                foreach ($this->Dados['listPolicies'] as $key => $policie) {
                    extract($policie);
                    //var_dump($this->Dados['areas']);
                    ?>
                    <div class="card mb-2">
                        <div class="card-header" id="heading<?php echo $id; ?>">
                            <div class="row justify-content-between">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $id; ?>">
                                        <strong><?php echo $title; ?></strong> - <span class="btn-link text-decoration-none">Clique aqui</span> para ver a descrição da política!
                                    </button>
                                </h2>

                                <div class="d-flex align-items-center">
                                    <?php
                                    $Path = "assets/files/policies/$id/$link";
                                    if (file_exists($Path)) {
                                        echo "<div class='d-flex align-items-center mr-1'>";
                                        echo "<a href='" . URLADM . "assets/files/policies/$id/$link' target='_blank' class='btn btn-outline-dark btn-sm' title='Baixar arquivo' download><i class='fa-solid fa-download'></i></a> ";
                                        echo "</div>";
                                    } else {
                                        echo "<div class='d-flex align-items-center mr-1'>";
                                        echo "<button type='button' class='btn btn-secondary btn-sm' disabled><i class='fa-solid fa-download'></i></button> ";
                                        echo "</div>";
                                    }
                                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
                                        ?>
                                        <span class="d-none d-md-block">
                                            <?php
                                            if ($this->Dados['botao']['view_policies']) {
                                                echo "<a href='" . URLADM . "view-policies/view-policie/$id' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['edit_policies']) {
                                                echo "<a href='" . URLADM . "edit-policies/edit-policie/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['del_policies']) {
                                                echo "<a href='" . URLADM . "delete-policies/del-policie/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i></a> ";
                                            }
                                            ?>
                                        </span>
                                        <div class="dropdown d-block d-md-none">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                <?php
                                                if ($this->Dados['botao']['view_policies']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "view-policies/view-policie/$id'>Visualizar</a>";
                                                }
                                                if ($this->Dados['botao']['edit_policies']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "edit-policies/edit-policie/$id'>Editar</a>";
                                                }
                                                if ($this->Dados['botao']['del_policies']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "delete-policies/del-policie/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div id="collapse<?php echo $id; ?>" class="collapse" aria-labelledby="heading<?php echo $id; ?>" data-parent="#accordionExample">

                            <div class="text-justify p-4">
                                <?php echo $content; ?>
                                <?php echo "<span class='blockquote-footer text-center'><strong>Validade: </strong>" . date("d/m/Y", strtotime($dataInicial)); ?>
                                <?php echo "até " . date("d/m/Y", strtotime($dataFinal)) . "</span>"; ?>
                            </div>

                        </div>

                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>
</div>