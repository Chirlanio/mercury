<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Ordem de Serviço</h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_ordem_servico']) {
                        echo "<a href='" . URLADM . "ordem-servico/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                    }
                    if ($this->Dados['botao']['vis_ordem_servico']) {
                        echo "<a href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i> Visualizar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_ordem_servico']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "ordem-servico/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['vis_ordem_servico']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/" . $valorForm['id'] . "'>Cadastrar</a>";
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
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $lj) {
                            extract($lj);
                            if ($valorForm['loja_id'] == $l_id) {
                                echo "<option value='$l_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$l_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Ordem Serviço</label>
                    <input name="ordem_servico" type="text" class="form-control is-invalid text-center" placeholder="Ordem de serviço do CIGAM" value="<?php
                    if (isset($valorForm['ordem_servico'])) {
                        echo $valorForm['ordem_servico'];
                    }
                    ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label>Prenota</label>
                    <input name="num_prenota" type="text" class="form-control is-invalid text-center" placeholder="Número da prenota" value="<?php
                    if (isset($valorForm['num_prenota'])) {
                        echo $valorForm['num_prenota'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="tipo_ordem_id" id="tipo_ordem_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tips'] as $tips) {
                            extract($tips);
                            if ($valorForm['tipo_ordem_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$tipo</option>";
                            } else {
                                echo "<option value='$t_id'>$tipo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> NF Transferência</label>
                    <input name="num_nota_transf" type="number" id="num_nota_transf" class="form-control is-invalid text-center" required value="<?php
                    if (isset($valorForm['num_nota_transf'])) {
                        echo $valorForm['num_nota_transf'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Data de Emissão</label>
                    <input name="data_emissao_nota_transf" type="date" id="data_emissao_nota_transf" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['data_emissao_nota_transf'])) {
                        echo $valorForm['data_emissao_nota_transf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Data de Confirmação</label>
                    <input name="data_confir_nota_transf" type="date" id="data_confir_nota_transf" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['data_confir_nota_transf'])) {
                        echo $valorForm['data_confir_nota_transf'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" type="text" class="form-control is-invalid text-center" required value="<?php
                    if (isset($valorForm['referencia'])) {
                        echo strtoupper($valorForm['referencia']);
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tamanho</label>
                    <select name="tam_id" id="tam_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tam'] as $sit) {
                            extract($sit);
                            if ($valorForm['tam_id'] == $ta_id) {
                                echo "<option value='$ta_id' selected>$tam</option>";
                            } else {
                                echo "<option value='$ta_id'>$tam</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> RefTam</label>
                    <input name="reftam" type="text" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['reftam'])) {
                        echo strtoupper($valorForm['reftam']);
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label> Código de Barras</label>
                    <input name="cod_barras" type="text" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['cod_barras'])) {
                        echo $valorForm['cod_barras'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Marca</label>
                    <select name="marca_id" id="marca_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['marc'] as $m) {
                            extract($m);
                            if ($valorForm['marca_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$marca</option>";
                            } else {
                                echo "<option value='$m_id'>$marca</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Quantidade</label>
                    <input name="qtde" type="number" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['qtde'])) {
                        echo $valorForm['qtde'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Loja - Conserto</label>
                    <select name="loja_id_conserto" id="loja_id_conserto" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $lj) {
                            extract($lj);
                            if ($valorForm['loja_id_conserto'] == $l_id) {
                                echo "<option value='$l_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$l_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Nota - Devolução</label>
                    <input name="nf_conserto_devolucao" type="number" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['nf_conserto_devolucao'])) {
                        echo $valorForm['nf_conserto_devolucao'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Data de Confirmação</label>
                    <input name="data_emissao_conserto" type="date" id="data_emissao_conserto" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['data_emissao_conserto'])) {
                        echo $valorForm['data_emissao_conserto'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Nota - Retorno</label>
                    <input name="nf_retorno_conserto" type="number" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['nf_retorno_conserto'])) {
                        echo $valorForm['nf_retorno_conserto'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Data de Confirmação</label>
                    <input name="data_confir_retorno_conserto" type="date" id="data_confir_retorno_conserto" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['data_confir_retorno_conserto'])) {
                        echo $valorForm['data_confir_retorno_conserto'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['stis'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações - Loja</label>
                    <textarea name="obs_loja" id="obs_loja" class="form-control editorCK is-invalid" rows="4" required>
                        <?php
                        if (isset($valorForm['obs_loja'])) {
                            echo $valorForm['obs_loja'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações - Qualidade</label>
                    <textarea name="obs_qualidade" id="obs_qualidade" class="form-control editorCKQl is-invalid" rows="4" required>
                        <?php
                        if (isset($valorForm['obs_qualidade'])) {
                            echo $valorForm['obs_qualidade'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditOrdem" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
