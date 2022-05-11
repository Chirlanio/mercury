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
                <h2 class="display-4 titulo">Estoque</h2>
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'pesq-estoque/listar'; ?>" enctype="multipart/form-data">
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
                        <input name="refauxiliar" type="text" id="referencia" class="form-control" aria-describedby="refauxiliar" placeholder="Código de barras" value="<?php
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
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Loja</th>
                        <th scope="col" class="text-center" style="width: 120px !important;">Foto</th>
                        <th scope="col" class="text-center">Referência</th>
                        <th scope="col" class="text-center">Código de Barras</th>
                        <th scope="col" class="text-center">Tam</th>
                        <th scope="col" class="text-center">Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['pesqLoja']) OR isset($_SESSION['referencia']) OR isset($_SESSION['refauxiliar'])) {
                        if (!empty($this->Dados['listEstoque'])) {
                            foreach ($this->Dados['listEstoque'] as $Est) {
                                extract($Est);
                                ?>
                                <tr>
                                    <th scope="row" class="text-center align-middle"><?php echo $loja; ?></th>
                                    <td><img src="http://www.meiasola.com/powerbi/<?php echo $referencia; ?>.jpg" class="rounded" width="120px" height="120px" alt="<?php echo $referencia; ?>"></td>
                                    <td class="text-center align-middle"><?php echo $referencia; ?></td>
                                    <td class="text-center align-middle"><?php echo $refauxiliar; ?></td>
                                    <td class="text-center align-middle"><?php echo $tam; ?></td>
                                    <td class="text-center align-middle"><?php echo number_format($saldo); ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
            if (isset($_SESSION['pesqLoja']) OR isset($_SESSION['referencia']) OR isset($_SESSION['refauxiliar'])) {
                echo $this->Dados['paginacao'];
            }
            ?>
        </div>
    </div>
</div>