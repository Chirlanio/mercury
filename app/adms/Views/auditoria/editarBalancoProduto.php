<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($_FILES());
//var_dump($this->Dados['select']['balanco']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Produto</h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_balanco_produto']) {
                        echo "<a href='" . URLADM . "balanco-produto/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                    }
                    if ($this->Dados['botao']['vis_balanco_produto']) {
                        echo "<a href='" . URLADM . "ver-balanco-produto/ver-balanco/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i> Visualizar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_balanco_produto']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "balanco-produto/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['vis_balanco_produto']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "ver-balanco-produto/ver-balanco/" . $valorForm['id'] . "'>Cadastrar</a>";
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
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Referência</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="referencia" type="text" class="form-control is-invalid" placeholder="A0376267230880" value="';
                        if (isset($valorForm['referencia'])) {
                            echo $valorForm['referencia'];
                        }
                    } else {
                        echo '<input name="referencia" type="text" class="form-control is-valid" aria-label="Disabled input" disabled placeholder="Nome completo do Cliente" value ="';
                        if (isset($valorForm['referencia'])) {
                            echo $valorForm['referencia'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Código de Barras</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="cod_barras" type="text" class="form-control is-invalid" placeholder="790964230202" value="';
                        if (isset($valorForm['cod_barras'])) {
                            echo $valorForm['cod_barras'];
                        }
                    } else {
                        echo '<input name="referencia" type="text" class="form-control is-valid" aria-label="Disabled input" disabled placeholder="Nome completo do Cliente" value ="';
                        if (isset($valorForm['referencia'])) {
                            echo $valorForm['referencia'];
                        }
                    }
                    ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tamanho</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="tam" type="text" class="form-control is-invalid" placeholder="33" value="';
                        if (isset($valorForm['tam'])) {
                            echo $valorForm['tam'];
                        }
                    } else {
                        echo '<input name="tam" type="text" class="form-control is-valid" aria-label="Disabled input" disabled placeholder="33" value ="';
                        if (isset($valorForm['tam'])) {
                            echo $valorForm['tam'];
                        }
                    }
                    ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="tipo" type="text" class="form-control is-invalid" placeholder="Sobra" value="';
                        if (isset($valorForm['tipo'])) {
                            echo $valorForm['tipo'];
                        }
                    } else {
                        echo '<input name="tipo" type="text" class="form-control is-valid" aria-label="Disabled input" disabled placeholder="Sobra" value ="';
                        if (isset($valorForm['tipo'])) {
                            echo $valorForm['tipo'];
                        }
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Estoque</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="qtde_estoque" id="qtde_estoque" type="number" class="form-control is-invalid text-center" value="';
                        if (isset($valorForm['qtde_estoque'])) {
                            echo $valorForm['qtde_estoque'];
                        }
                    } else {
                        echo '<input name="qtde_estoque" id="qtde_estoque" type="number" class="form-control is-valid text-center" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['qtde_estoque'])) {
                            echo $valorForm['qtde_estoque'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Contagem</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="qtde_contagem" id="qtde_contagem" type="number" class="form-control is-invalid text-center" value="';
                        if (isset($valorForm['qtde_contagem'])) {
                            echo $valorForm['qtde_contagem'];
                        }
                    } else {
                        echo '<input name="qtde_contagem" id="qtde_contagem" type="number" class="form-control is-valid text-center" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['qtde_contagem'])) {
                            echo $valorForm['qtde_contagem'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Divergência</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="qtde_divergencia" id="qtde_divergencia" type="number" class="form-control is-invalid text-center" value="';
                        if (isset($valorForm['qtde_divergencia'])) {
                            echo $valorForm['qtde_divergencia'];
                        }
                    } else {
                        echo '<input name="valor_estorno" id="valor_estorno" type="text" class="form-control is-valid text-center" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['valor_estorno'])) {
                            echo $valorForm['valor_estorno'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="situacao" id="situacao" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['situacao'])) {
                            echo $valorForm['situacao'];
                        }
                    } else {
                        echo '<input name="situacao" id="doc_nf" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['situacao'])) {
                            echo $valorForm['situacao'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Solução</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="solucao" id="solucao" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['solucao'])) {
                            echo $valorForm['solucao'];
                        }
                    } else {
                        echo '<input name="doc_nf" id="doc_nf" type="number" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['doc_nf'])) {
                            echo $valorForm['doc_nf'];
                        }
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observações</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<textarea name="obs_justificativa" id="obs_justificativa" type="text" class="form-control is-invalid editorCK">';
                        if (isset($valorForm['obs_justificativa'])) {
                            echo $valorForm['obs_justificativa'];
                        }
                        echo "</textarea>";
                    } else {
                        echo '<input name="doc_nf" id="doc_nf" type="number" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['doc_nf'])) {
                            echo $valorForm['doc_nf'];
                        }
                    }
                    ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Documentos</h6>
                                    <small class="text-muted">
                                        <span class="m-auto lead">
                                            <?php
                                            if (isset($valorForm['img_um'])) {
                                                echo $valorForm['img_um'] . " - ";
                                            }
                                            ?>
                                        </span>
                                        <a href="<?php echo URLADM . 'assets/imagens/balanco/' . $valorForm['id'] . '/' . $valorForm['img_um']; ?>" class="btn btn-outline-primary btn-sm lead m-auto" download>Baixar</a>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <input name="img_um" type="hidden" value="<?php
                    if (isset($valorForm['img_um'])) {
                        echo $valorForm['img_um'];
                    } elseif (isset($valorForm['file_novo'])) {
                        echo $valorForm['file_novo'];
                    }
                    ?>">

                    <label>Imagem 1:</label>
                    <input name="img_um" type="file" class="custom-file">

                    <label>Imagem 2:</label>
                    <input name="img_dois" type="file" class="custom-file">

                    <label>Imagem 3:</label>
                    <input name="img_tres" type="file" class="custom-file">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sits'] as $st) {
                            extract($st);
                            if ($valorForm['status_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observações</label>
                    <textarea name="obs_resposta" id="editor" class="form-control editorCKQl" rows="3">
                        <?php
                        if (isset($valorForm['obs_resposta'])) {
                            echo $valorForm['obs_resposta'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditEstorno" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
