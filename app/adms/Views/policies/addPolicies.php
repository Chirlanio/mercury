<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Política</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_policies']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'policies/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'><i class='fa-solid fa-list'></i></span></a>
                </div>
                <?php
            }
            ?>
        </div>
        
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 

            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="title" type="text" class="form-control is-invalid" placeholder="Titulo da política" value="<?php
                    if (isset($valorForm['title'])) {
                        echo $valorForm['title'];
                    }
                    ?>" required autofocus>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Conteúdo da Política</label>
                    <textarea name="content" id="editor-dois" class="form-control editorObs" rows="3"><?php
                        if (isset($valorForm['content'])) {
                            echo $valorForm['content'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <div cla

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Data Inicial</label>
                    <input name="dataInicial" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['dataInicial'])) {
                        echo $valorForm['dataInicial'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Data Final</label>
                    <input name="dataFinal" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['dataFinal'])) {
                        echo $valorForm['dataFinal'];
                    }
                    ?>" required="">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sit_id" id="adms_sit_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if (isset($valorForm['adms_sit_id']) AND $valorForm['adms_sit_id'] == $id_sit) {
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input class="form-control-file is-invalid" name="file_name" type="file" required />
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddPolicies" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
