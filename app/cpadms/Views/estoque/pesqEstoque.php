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
                <h2 class="display-4 titulo">Pesquisar Estoque</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_estoque']) {
                        echo "<a href='" . URLADM . "estoque/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_estoque']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "estoque/listar'>Listar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="loja_id">Loja</label>
                        </div>
                        <?php
                        echo "<select name='loja_id' id='loja_id' class='custom-select'>";
                        echo "<option value = ''>Selecione...</option>";
                        foreach ($this->Dados['select']['loja_id'] as $lo) {
                            extract($lo);
                            if (isset($_SESSION['pesqLoja']) === $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="referencia">Referência</label>
                        </div>
                        <input name="referencia" type="text" id="referencia" class="form-control" aria-describedby="referencia" placeholder="Digite a referência" value="<?php
                        if (isset($_SESSION['referencia'])) {
                            echo $_SESSION['referencia'];
                        }
                        ?>" autofocus>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="refauxiliar">Código de Barras</label>
                        </div>
                        <input name="refauxiliar" type="text" id="refauxiliar" class="form-control" aria-describedby="refauxiliar" placeholder="Código de barras" value="<?php
                        if (isset($_SESSION['refauxiliar'])) {
                            echo $_SESSION['refauxiliar'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqEst" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listEstoque'])) {
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
                        <th scope="col" class="text-center">Loja</th>
                        <th scope="col" class="text-center">Referência</th>
                        <th scope="col" class="text-center">Código de Barras</th>
                        <th scope="col" class="text-center">Tam</th>
                        <th scope="col" class="text-center">Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listEstoque'])) {
                        foreach ($this->Dados['listEstoque'] as $Est) {
                            extract($Est);
                            ?>
                            <tr>
                                <th scope="row" class="text-center align-middle"><?php echo $nome_loja; ?></th>
                                <td class="text-center align-middle"><?php echo $referencia; ?></td>
                                <td class="text-center align-middle"><?php echo $refauxiliar; ?></td>
                                <td class="text-center align-middle"><?php echo $tam; ?></td>
                                <td class="text-center align-middle" id="estoque"><?php echo number_format($saldo); ?></td>
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