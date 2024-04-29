<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($valorForm);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Abertura de Vaga <strong>ID: <?php echo $valorForm['id']; ?></strong></h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_vacancy']) {
                    echo "<a href='" . URLADM . "vacancy-opening/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['view_vacancy']) {
                    echo "<a href='" . URLADM . "view-vacancy-opening/view-vacancy/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">
            <input name="id" type="hidden" value="<?php
            if (!empty($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>" >
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="adms_loja_id" id="adms_loja_id" class="form-control is-invalid" autofocus <?php echo $_SESSION['ordem_nivac'] == STOREPERMITION ? "disabled" : "required"; ?> >
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
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="adms_request_type_id" id="adms_request_type_id" class="form-control is-invalid" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : "required"; ?>>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['typeRequests'] as $fc) {
                            extract($fc);
                            if (isset($valorForm['adms_request_type_id']) and $valorForm['adms_request_type_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$type_name</option>";
                            } else {
                                echo "<option value='$r_id'>$type_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Colaborador</label>
                    <select name="adms_employee_id" id="adms_employee_id" class="form-control is-invalid" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['employees'] as $fc) {
                            extract($fc);
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Cargo</label>
                    <select name="adms_cargo_id" id="adms_cargo_id" class="form-control is-invalid" autofocus <?php echo $_SESSION['ordem_nivac'] == STOREPERMITION ? "disabled" : "required"; ?> >
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Turno</label>
                    <select name="adms_work_schedule_id" id="adms_work_schedule_id" class="form-control is-invalid" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION?  "disabled" : "required"; ?>>
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Recrutador</label>
                    <select name="adms_recruiter_id" id="adms_recruiter_id" class="form-control is-invalid" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : "required"; ?>>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['recruiters'] as $recruiter) {
                            extract($recruiter);
                            if (isset($valorForm['adms_recruiter_id']) and $valorForm['adms_recruiter_id'] == $rec_id) {
                                echo "<option value='$rec_id' selected>$recruiter_name</option>";
                            } else {
                                echo "<option value='$rec_id'>$recruiter_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="interview_hr"> 1ª Entrevista</label>
                    <input name="interview_hr" type="date" id="interview_hr" class="form-control is-valid" value="<?php
                    if (isset($valorForm['interview_hr'])) {
                        echo $valorForm['interview_hr'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
                </div>

                <div class="form-group col-md-4">
                    <label for="evaluators_hr">Avaliador(a)</label>
                    <input name="evaluators_hr" type="text" id="number_order" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['evaluators_hr'])) {
                        echo $valorForm['evaluators_hr'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
                </div>

                <div class="form-group col-md-2">
                    <label for="interview_leader"> 2ª Entrevista</label>
                    <input name="interview_leader" type="date" id="interview_leader" class="form-control is-valid" value="<?php
                    if (isset($valorForm['interview_leader'])) {
                        echo $valorForm['interview_leader'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
                </div>

                <div class="form-group col-md-4">
                    <label for="evaluators_leader">Avaliador(a)</label>
                    <input name="evaluators_leader" type="text" id="number_order" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['evaluators_leader'])) {
                        echo $valorForm['evaluators_leader'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="approved">Candidato(a) Aprovado(a)</label>
                    <input name="approved" type="text" id="approved" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['approved'])) {
                        echo $valorForm['approved'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
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

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> SLA Previsto</label>
                    <input name="predicted_sla" type="number" id="predicted_sla" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['predicted_sla'])) {
                        echo $valorForm['predicted_sla'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : "required"; ?>>  
                </div>

                <div class="form-group col-md-3">
                    <label for="closing_date">Data de Fechamento</label>
                    <input name="closing_date" type="date" id="closing_date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['closing_date'])) {
                        echo $valorForm['closing_date'];
                    }
                    ?>" <?php echo $_SESSION['ordem_nivac'] >= STOREPERMITION ? "disabled" : ""; ?>>
                </div>

                <?php if ($_SESSION['ordem_nivac'] != STOREPERMITION) { ?>
                    <div class="form-group col-md-3">
                        <label><span class="text-danger">*</span> Situação</label>
                        <select name="adms_sit_vacancy_id" id="adms_sit_vacancy_id" class="form-control is-invalid" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->Dados['select']['sits'] as $sit) {
                                extract($sit);
                                if (isset($valorForm['adms_sit_vacancy_id']) and $valorForm['adms_sit_vacancy_id'] == $s_id) {
                                    echo "<option value='$s_id' selected>$name_sit</option>";
                                } else {
                                    echo "<option value='$s_id'>$name_sit</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditVacancy" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

