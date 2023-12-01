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
                <h2 class="display-4 titulo">Cadastrar Política/Processo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_process']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'process-library/list'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="title" type="text" class="form-control is-invalid" placeholder="Titulo do processo" value="<?php
                    if (isset($valorForm['title'])) {
                        echo $valorForm['title'];
                    }
                    ?>" required autofocus>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Categoria</label>
                    <select name="adms_cats_process_id" id="adms_cats_process_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cats'] as $catPro) {
                            extract($catPro);
                            if (isset($valorForm['adms_cats_process_id']) AND $valorForm['adms_cats_process_id'] == $cat_id) {
                                echo "<option value='$cat_id' selected>$category</option>";
                            } else {
                                echo "<option value='$cat_id'>$category</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="version_number"><span class="text-danger">*</span> Versão</label>
                    <input name="version_number" id="version_number" type="text" class="form-control is-invalid" placeholder="1.0.0.23" value="<?php
                    if (isset($valorForm['version_number'])) {
                        echo $valorForm['version_number'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Área</label>
                    <select name="adms_area_id" id="adms_area_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['area'] as $arPro) {
                            extract($arPro);
                            if (isset($valorForm['adms_area_id']) AND $valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$area_name</option>";
                            } else {
                                echo "<option value='$a_id'>$area_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Gestor da Área</label>
                    <select name="adms_manager_area_id" id="adms_manager_area_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['manager'] as $manPro) {
                            extract($manPro);
                            if (isset($valorForm['adms_manager_area_id']) AND $valorForm['adms_manager_area_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$manager</option>";
                            } else {
                                echo "<option value='$m_id'>$manager</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Setor</label>
                    <select name="adms_sector_id" id="adms_sector_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sector'] as $secPro) {
                            extract($secPro);
                            if (isset($valorForm['adms_sector_id']) AND $valorForm['adms_sector_id'] == $sec_id) {
                                echo "<option value='$sec_id' selected>$sector_name</option>";
                            } else {
                                echo "<option value='$sec_id'>$sector_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Gestor do Setor</label>
                    <select name="adms_manager_sector_id" id="adms_manager_sector_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['manager_sector'] as $fPro) {
                            extract($fPro);
                            if (isset($valorForm['adms_manager_sector_id']) AND $valorForm['adms_manager_sector_id'] == $f_id) {
                                echo "<option value='$f_id' selected>$manager_sector</option>";
                            } else {
                                echo "<option value='$f_id'>$manager_sector</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Inicial</label>
                    <input name="date_validation_start" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_validation_start'])) {
                        echo $valorForm['date_validation_start'];
                    }
                    ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Final</label>
                    <input name="date_validation_end" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_validation_end'])) {
                        echo $valorForm['date_validation_end'];
                    }
                    ?>" required="">
                </div>

                <div class="form-group col-md-3">
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
                    <label><span class="text-danger">*</span> Arquivos</label>
                    <input name="file_name_process[]" id="file_name_process" class="form-control-file is-invalid" type="file" multiple required/>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddProcess" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
