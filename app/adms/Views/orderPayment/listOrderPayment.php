<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
var_dump($this->Dados['list_backlog']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Solicitações de Estornos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['add_payment']) {
                ?>
                <a href="<?php echo URLADM . 'add-order-payments/order-payment'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            <span>
                                <i class="fas fa-plus d-block d-md-none fa-2x"></i>
                                <span class='d-none d-md-block'>Cadastrar</span>
                            </span>
                        </button>
                    </div>
                </a>
                <?php
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
        if (empty($this->Dados['list_backlog'])) {
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
        ?>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell text-center">Solicitações</th>
                        <th class="text-center"></th>
                        <th class="d-none d-sm-table-cell text-center">Fluxo Semanal</th>
                        <th class="text-center"></th>
                        <th class="d-none d-sm-table-cell text-center">Pagos</th>
                        <th class="text-center"></th>
                        <th class="d-none d-sm-table-cell text-center">Comprovante</th>
                    </tr>
                </thead>
                <tbody>
                <td>
                    <div name="backlog" class="list-group border p-2">
                        <?php
                        foreach ($this->Dados['list_backlog'] as $backlog) {
                            extract($backlog);
                            ?>
                            <div class="card bg-light m-1 w-auto">
                                <h5 class="card-header">ID: <?php echo $id; ?></h5>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $area; ?></h5>
                                    <p class="card-text"><?php echo date('d/m/Y', strtotime($created_date)); ?></p>
                                    <p class="card-text"><?php echo $fornecedor;?></p>
                                    <div class="text-right">
                                        <span class="d-none d-md-block">
                                            <a href='ver-estorno/ver-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a>
                                            <a href='editar-estorno/edit-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a>
                                            <a href='apagar-estorno/apagar-estorno/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a>
                                            <?php
                                            if ($this->Dados['botao']['view_payment']) {
                                                echo "<a href='" . URLADM . "ver-estorno/ver-estorno/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['edit_payment']) {
                                                echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['del_payment']) {
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
                                                if ($this->Dados['botao']['view_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "ver-estorno/ver-estorno/$id'>Visualizar</a>";
                                                }
                                                if ($this->Dados['botao']['edit_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                                                }
                                                if ($this->Dados['botao']['del_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </td>

                <td class="text-center order-payment">
                    <div>
                        <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
                            <button id="back-backlog" type="button" class="btn btn-outline-dark disabled"><<</button>
                            <button id="for-doing" type="button" class="btn btn-outline-secondary">>></button>
                        </div>
                    </div>
                </td>

                <td class="d-none d-sm-table-cell">
                    <div name="doing" class="list-group border p-2">
                        <?php
                        foreach ($this->Dados['list_doing'] as $doing) {
                            extract($doing);
                            ?>
                            <div class="card text-white bg-secondary m-1 w-auto">
                                <h5 class="card-header">ID: <?php echo $id; ?></h5>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $adms_area_id; ?></h5>
                                    <p class="card-text"><?php echo $created_date ?></p>
                                    <div class="text-right">
                                        <span class="d-none d-md-block">
                                            <a href='ver-estorno/ver-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a>
                                            <a href='editar-estorno/edit-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a>
                                            <a href='apagar-estorno/apagar-estorno/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a>

                                            <?php
                                            if ($this->Dados['botao']['view_payment']) {
                                                echo "<a href='" . URLADM . "ver-estorno/ver-estorno/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['edit_payment']) {
                                                echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['del_payment']) {
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
                                                if ($this->Dados['botao']['view_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "ver-estorno/ver-estorno/$id'>Visualizar</a>";
                                                }
                                                if ($this->Dados['botao']['edit_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                                                }
                                                if ($this->Dados['botao']['del_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </td>

                <td class="text-center order-payment">
                    <div>
                        <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
                            <button id="back-doing" type="button" class="btn btn-outline-secondary"><<</button>
                            <button id="for-waiting" type="button" class="btn btn-outline-info">>></button>
                        </div>
                    </div>
                </td>

                <td class="d-none d-sm-table-cell">
                    <div name="waiting" class="list-group border p-2">
                        <?php
                        foreach ($this->Dados['list_backlog'] as $waiting) {
                            extract($waiting);
                            ?>
                            <div class="card text-white bg-info border-info m-1 w-auto">
                                <h5 class="card-header">ID: <?php echo $id; ?></h5>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $adms_area_id; ?></h5>
                                    <p class="card-text"><?php echo $created_date ?></p>
                                    <div class="text-right">
                                        <span class="d-none d-md-block">
                                            <a href='ver-estorno/ver-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a>
                                            <a href='editar-estorno/edit-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a>
                                            <a href='apagar-estorno/apagar-estorno/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a>

                                            <?php
                                            if ($this->Dados['botao']['view_payment']) {
                                                echo "<a href='" . URLADM . "ver-estorno/ver-estorno/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['edit_payment']) {
                                                echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['del_payment']) {
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
                                                if ($this->Dados['botao']['view_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "ver-estorno/ver-estorno/$id'>Visualizar</a>";
                                                }
                                                if ($this->Dados['botao']['edit_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                                                }
                                                if ($this->Dados['botao']['del_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </td>

                <td class="text-center order-payment">
                    <div>
                        <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
                            <button id="back-waiting" type="button" class="btn btn-outline-info"><<</button>
                            <button id="for-done" type="button" class="btn btn-outline-success">>></button>
                        </div>
                    </div>
                </td>

                <td class="d-none d-sm-table-cell">
                    <div name="done" class="list-group border p-2">
                        <?php
                        foreach ($this->Dados['list_doing'] as $done) {
                            extract($done);
                            ?>
                            <div class="card text-white bg-success m-1 w-auto">
                                <h5 class="card-header">ID: <?php echo $id; ?></h5>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $area; ?></h5>
                                    <p class="card-text"><?php echo $description ?></p>
                                    <div class="text-right">
                                        <span class="d-none d-md-block">
                                            <a href='ver-estorno/ver-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a>
                                            <a href='editar-estorno/edit-estorno/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a>
                                            <a href='apagar-estorno/apagar-estorno/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a>

                                            <?php
                                            if ($this->Dados['botao']['view_payment']) {
                                                echo "<a href='" . URLADM . "ver-estorno/ver-estorno/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['edit_payment']) {
                                                echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                            }
                                            if ($this->Dados['botao']['del_payment']) {
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
                                                if ($this->Dados['botao']['view_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "ver-estorno/ver-estorno/$id'>Visualizar</a>";
                                                }
                                                if ($this->Dados['botao']['edit_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                                                }
                                                if ($this->Dados['botao']['del_payment']) {
                                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </td>
                </tbody>
            </table>
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>