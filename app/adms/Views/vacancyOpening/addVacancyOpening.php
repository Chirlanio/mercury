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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Abertura de Vagas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_vacancy']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'vacancy-opening/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="adms_loja_id" id="adms_loja_id" class="form-control is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['stores'] as $stp) {
                            extract($stp);
                            if (isset($valorForm['adms_loja_id']) and $valorForm['adms_loja_id'] == $lj_id) {
                                echo "<option value='$lj_id' selected>$store</option>";
                            } else {
                                echo "<option value='$lj_id'>$store</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="adms_request_type_id" id="adms_request_type_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['typeRequests'] as $request) {
                            extract($request);
                            if (isset($valorForm['adms_request_type_id']) and $valorForm['adms_request_type_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$type_name</option>";
                            } else {
                                echo "<option value='$r_id'>$type_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label>Colaborador</label>
                    <select name="adms_employee_id" id="adms_employee_id" class="form-control is-invalid">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['employees'] as $employee) {
                            extract($employee);
                            if (isset($valorForm['adms_employee_id']) and $valorForm['adms_employee_id'] == $f_id) {
                                echo "<option value='$f_id' selected>$employee_name</option>";
                            } else {
                                echo "<option value='$f_id'>$employee_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cargo</label>
                    <select name="adms_cargo_id" id="adms_cargo_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cargos'] as $cargo) {
                            extract($cargo);
                            if (isset($valorForm['adms_cargo_id']) and $valorForm['adms_cargo_id'] == $c_id) {
                                echo "<option value='$c_id' selected>$cargo_name</option>";
                            } else {
                                echo "<option value='$c_id'>$cargo_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Turno</label>
                    <select name="adms_work_schedule_id" id="adms_work_schedule_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sched'] as $schedule) {
                            extract($schedule);
                            if (isset($valorForm['adms_work_schedule_id']) and $valorForm['adms_work_schedule_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$schedule_name</option>";
                            } else {
                                echo "<option value='$s_id'>$schedule_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea name="comments" id="editor" class="form-control editorCK" rows="3"><?php
                        if (isset($valorForm['comments'])) {
                            echo $valorForm['comments'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddVacancy" type="submit" class="btn btn-warning btn-submit" value="Salvar">
        </form>
    </div>
</div>