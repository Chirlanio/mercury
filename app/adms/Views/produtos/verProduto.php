<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_produto'][0])) {
    extract($this->Dados['dados_produto'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhar Produto</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_produtos']) {
                            echo "<a href='" . URLADM . "pesq-produtos/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_produtos']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "pesq-produtos/listar'>Listar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>

            <div style="width: 250px; height: 250px;"><?php echo "<img class='img-thumbnail' src='http://www.meiasola.com/powerbi/image/" . $referencia . ".jpg' width='250' height='250' alt='" . $referencia . "'>"; ?></div><br>

            <form class="row g-3">
                <div class="col-md-3">
                    <label for="referencia" class="form-label">Referência</label>
                    <input type="text" class="form-control" id="referencia" aria-label="Disabled input" disabled value="<?php echo $referencia; ?>">
                </div>
                <div class="col-md-9">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="descricao" class="form-control" id="descricao" aria-label="Disabled input" disabled value="<?php echo $descricao; ?>">
                </div>
                <div class="col-md-3">
                    <label for="colecao" class="form-label">Estação</label>
                    <input type="text" class="form-control" id="colecao" aria-label="Disabled input" disabled value="<?php echo $colecao; ?>">
                </div>
                <div class="col-md-3">
                    <label for="subcolecao" class="form-label">Coleção</label>
                    <input type="text" class="form-control" id="subcolecao" aria-label="Disabled input" disabled value="<?php echo $subcolecao; ?>">
                </div>
                <div class="col-md-3">
                    <label for="linha" class="form-label">Tipo</label>
                    <input type="text" class="form-control" id="linha" aria-label="Disabled input" disabled value="<?php echo $linha; ?>">
                </div>
                <div class="col-md-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" aria-label="Disabled input" disabled value="<?php echo $marca; ?>">
                </div>
                <div class="col-md-6">
                    <table class="table table-hover table-bordered table-sm border-top-0" style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Código de Barras</th>
                                <th scope="col" class="text-center">Ref Auxiliar</th>
                                <th scope="col" class="text-center">Tamanho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($this->Dados['dados_produto'] as $lo) {
                                extract($lo);
                                echo "<tr>";
                                echo "<td scope='row' class='text-center'>";
                                echo $refauxiliar . "<br>";
                                echo "</td>";
                                echo "<td scope='row' class='text-center'>";
                                echo $codbarra . "<br>";
                                echo "</td>";
                                echo "<td scope='row' class='text-center'>";
                                echo $tamanho . "<br>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <label for="artigo" class="form-label">Grupo</label>
                    <input type="text" class="form-control" id="artigo" aria-label="Disabled input" disabled value="<?php echo $artigo; ?>">
                    <label for="complartigo" class="form-label">Subgrupo</label>
                    <input type="text" class="form-control" id="complartigo" aria-label="Disabled input" disabled value="<?php echo $complartigo; ?>">
                    <label for="cor" class="form-label">Cor</label>
                    <input type="text" class="form-control" id="cor" aria-label="Disabled input" disabled value="<?php echo $cor; ?>">
                    <label for="material" class="form-label">Material</label>
                    <input type="text" class="form-control" id="material" aria-label="Disabled input" disabled value="<?php echo $material; ?>">
                </div>
                <div class="col-md-3">
                    <label for="min_vlrvenda" class="form-label">Preço de Venda</label>
                    <input type="text" class="form-control text-center" id="min_vlrvenda" aria-label="Disabled input" disabled value="<?php echo "R$ " . number_format($min_vlrvenda, '2', ',', '.'); ?>">
                    <label for="min_vlrcusto" class="form-label">Custo</label>
                    <input type="text" class="form-control text-center" id="min_vlrcusto" aria-label="Disabled input" disabled value="<?php echo "R$ " . number_format($min_vlrcusto, '2', ',', '.'); ?>">
                    <label for="datacadastro" class="form-label">Data Cadastro</label>
                    <input type="text" class="form-control text-center" id="datacadastro" aria-label="Disabled input" disabled value="<?php echo date('d/m/Y H:i:s', strtotime($datacadastro)); ?>">
                </div>
            </form>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Produto não encontrado!</div>";
    $UrlDestino = URLADM . 'produtos/listarProdutos';
    header("Location: $UrlDestino");
}
