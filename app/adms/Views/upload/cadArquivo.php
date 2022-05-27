<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($_FILES);
//var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Arquivo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_arq']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'arquivo/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome do arquivo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" autofocus required>
                </div>
                
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja'] as $loja) {
                            extract($loja);
                            if (isset($valorForm['loja_id'])) {
                                echo "<option value='$l_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$l_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if (isset($valorForm['status_id']) AND $valorForm['status_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$nome_sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$nome_sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Selecione um arquivo</label>
                    <input name="slug" type="file" class="form-control-file">
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadArq" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
