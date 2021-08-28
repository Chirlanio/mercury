<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Cadastro de Lojas</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_loja']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-loja/ver-loja/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                </div>
                <?php
            }
            ?>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Código da Loja</label>
                    <input name="id" type="text" class="form-control" placeholder="Código da loja" value="<?php
                    if (isset($valorForm['id'])) {
                        echo $valorForm['id'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">*</span> Nome da Loja</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome da Loja a ser apresentado no menu" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> CNPJ</label>
                    <input name="cnpj" type="text" class="form-control" placeholder="CNPJ da loja, digite somente números." value="<?php
                    if (isset($valorForm['cnpj'])) {
                        echo $valorForm['cnpj'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-9">
                    <label><span class="text-danger">*</span> Razão Social</label>
                    <input name="razao_social" type="text" class="form-control" placeholder="Ex: MEIA SOLA ACESSORIOS DE MODA" value="<?php
                    if (isset($valorForm['razao_social'])) {
                        echo $valorForm['razao_social'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Inscrição Estadual</label>
                    <input name="ins_estadual" type="text" class="form-control" placeholder="Digite somente números" value="<?php
                    if (isset($valorForm['ins_estadual'])) {
                        echo $valorForm['ins_estadual'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">*</span> Endereço</label>
                    <input name="endereco" type="text" class="form-control" placeholder="Avenida Dom Manuel, 621 Centro Fortaleza - CE" value="<?php
                    if (isset($valorForm['endereco'])) {
                        echo $valorForm['endereco'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Rede</label>
                    <select name="rede_id" id="adms_sits_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['rede'] as $re) {
                            extract($re);
                            if ($valorForm['rede'] == $rede) {
                                echo "<option value='$id_rede' selected>$rede</option>";
                            } else {
                                echo "<option value='$id_rede'>$rede</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Gerente</label>
                    <select name="func_id" id="func_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $re) {
                            extract($re);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$func_id'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="adms_sits_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $s) {
                            extract($s);
                            if ($valorForm['sit'] == $sit) {
                                echo "<option value='$id_sit' selected>$sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditLoja" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
