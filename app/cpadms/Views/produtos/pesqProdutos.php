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
                <h2 class="display-4 titulo">Pesquisar Produtos</h2>
            </div>
        </div>
        <form class="form" method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-6 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="referencia">Referência</label>
                        </div>
                        <input name="referencia" type="text" id="referencia" class="form-control" aria-describedby="referencia" placeholder="Digite a referência" value="<?php
                        if (isset($_SESSION['referencia'])) {
                            echo $_SESSION['referencia'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="refauxiliar">Código de Barras</label>
                        </div>
                        <input name="refauxiliar" type="text" id="referencia" class="form-control" aria-describedby="refauxiliar" placeholder="Digite o código de barras" value="<?php
                        if (isset($_SESSION['refauxiliar'])) {
                            echo $_SESSION['refauxiliar'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqProd" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listProdutos'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum produto encontrado!
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
                        <th scope="col">Foto</th>
                        <th scope="col">Referência</th>
                        <th scope="col" class="d-print-none">Descrição</th>
                        <th scope="col" class="d-print-none">Estação</th>
                        <th scope="col" class="d-print-none">Coleção</th>
                        <th scope="col" class="d-print-none">Tipo</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listProdutos'])) {
                        foreach ($this->Dados['listProdutos'] as $Prod) {
                            extract($Prod);
                            ?>
                            <tr>
                                <td><img src="http://www.meiasola.com/powerbi/<?php echo $referencia; ?>.jpg" class="rounded" width="120px" height="120px" alt="<?php echo $referencia; ?>"></td>
                                <th scope="row" class="align-middle"><?php echo $referencia; ?></th>
                                <td class="d-print-none align-middle"><?php echo $descricao; ?></td>            
                                <td class="d-print-none align-middle"><?php echo $colecao; ?></td>                    
                                <td class="d-print-none align-middle"><?php echo $subcolecao; ?></td>
                                <td class="d-print-none align-middle"><?php echo $linha; ?></td>
                                <td class="align-middle"><?php echo $marca; ?></td>
                                <td class="text-center align-middle">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_produtos']) {
                                            echo "<a href='" . URLADM . "ver-produto/ver-produto/$referencia' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_produtos']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-produto/ver-produto/$referencia'>Visualizar</a>";
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