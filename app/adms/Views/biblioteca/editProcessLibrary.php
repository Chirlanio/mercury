<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form'][0]);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Processo/Política</h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_process']) {
                        echo "<a href='" . URLADM . "process-library/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                    }
                    if ($this->Dados['botao']['view_process']) {
                        echo "<a href='" . URLADM . "view-process-library/process-library/" . $valorForm['pl_id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i> Visualizar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_process']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "process-payments/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['view_process']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "view-process-library/process-library/" . $valorForm['pl_id'] . "'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 
            <input name="pl_id" type="hidden" value="<?php
            if (isset($valorForm['pl_id'])) {
                echo $valorForm['pl_id'];
            }
            ?>">

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
                            if (isset($valorForm['adms_cats_process_id']) AND $valorForm['adms_cats_process_id'] == $c_id) {
                                echo "<option value='$c_id' selected>$name_category</option>";
                            } else {
                                echo "<option value='$c_id'>$name_category</option>";
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
                    <label for="adms_area_id"><span class="text-danger">*</span> Área</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area'] as $a) {
                            extract($a);
                            if ($valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$area</option>";
                            } else {
                                echo "<option value='$a_id'>$area</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area'] as $a) {
                            extract($a);
                            if ($valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$area</option>";
                            } else {
                                echo "<option value='$a_id'>$area</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>

                </div>

                <div class="form-group col-md-3">
                    <label for="adms_cost_center_id"><span class="text-danger">*</span> Gestor da Área</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_manager_area_id" id="adms_manager_area_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['managerAreas'] as $managerArea) {
                            extract($managerArea);
                            if ($valorForm['adms_manager_area_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$manager_area</option>";
                            } else {
                                echo "<option value='$m_id'>$manager_area</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_manager_area_id" id="adms_manager_area_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['managerAreas'] as $managerArea) {
                            extract($managerArea);
                            if ($valorForm['adms_manager_area_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$manager_area</option>";
                            } else {
                                echo "<option value='$m_id'>$manager_area</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label for="adms_brand_id"><span class="text-danger">*</span> Setor</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_sector_id" id="adms_sector_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sectors'] as $sector) {
                            extract($sector);
                            if ($valorForm['adms_sector_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sector_name</option>";
                            } else {
                                echo "<option value='$s_id'>$sector_name</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_sector_id" id="adms_sector_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sectors'] as $sector) {
                            extract($sector);
                            if ($valorForm['adms_sector_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sector_name</option>";
                            } else {
                                echo "<option value='$s_id'>$sector_name</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label for="adms_manager_sector_id"><span class="text-danger">*</span> Gestor do Setor</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_manager_sector_id" id="adms_manager_sector_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['managerSectors'] as $sector) {
                            extract($sector);
                            if ($valorForm['adms_manager_sector_id'] == $sm_id) {
                                echo "<option value='$sm_id' selected>$manager_sector</option>";
                            } else {
                                echo "<option value='$sm_id'>$manager_sector</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_manager_sector_id" id="adms_manager_sector_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['managerSectors'] as $sector) {
                            extract($sector);
                            if ($valorForm['adms_manager_sector_id'] == $sm_id) {
                                echo "<option value='$sm_id' selected>$manager_sector</option>";
                            } else {
                                echo "<option value='$sm_id'>$manager_sector</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

            </div>
            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Inicial</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="date_validation_start" type="date" class="form-control is-invalid" value="';
                        if (isset($valorForm['date_validation_start'])) {
                            echo $valorForm['date_validation_start'];
                        }
                        echo'" required>';
                    } else {
                        echo '<input name="date_validation_start" type="date" class="form-control is-invalid" value="';
                        if (isset($valorForm['date_validation_start'])) {
                            echo $valorForm['date_validation_start'];
                        }
                        echo'" aria-label="Disabled input" disabled>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Final</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="date_validation_end" type="date" class="form-control is-invalid" value="';
                        if (isset($valorForm['date_validation_end'])) {
                            echo $valorForm['date_validation_end'];
                        }
                        echo'" required>';
                    } else {
                        echo '<input name="date_validation_end" type="date" class="form-control is-invalid" value="';
                        if (isset($valorForm['date_validation_end'])) {
                            echo $valorForm['date_validation_end'];
                        }
                        echo'" aria-label="Disabled input" disabled>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sit_id" id="adms_sit_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                            foreach ($this->Dados['select']['sits'] as $sit) {
                                extract($sit);
                                if (isset($valorForm['adms_sit_id']) AND $valorForm['adms_sit_id'] == $sit_id) {
                                    echo "<option value='$sit_id' selected>$status</option>";
                                } else {
                                    echo "<option value='$sit_id'>$status</option>";
                                }
                            }
                            echo '</select>';
                        } else {
                            foreach ($this->Dados['select']['sits'] as $sit) {
                                extract($sit);
                                if (isset($valorForm['adms_sit_id']) AND $valorForm['adms_sit_id'] == $sit_id) {
                                    echo "<option value='$sit_id' selected>$status</option>";
                                } else {
                                    echo "<option value='$sit_id'>$status</option>";
                                }
                            }
                            echo '</select>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Arquivos</h6>
                                    <small class="text-muted">
                                        <?php
                                        $types = array('png', 'jpg', 'jpeg', 'doc', 'pdf', 'docx');
                                        $path = 'assets/files/orderPayments/' . $valorForm['pl_id'] . '/';
                                        $dir = new DirectoryIterator($path);
                                        foreach ($dir as $fileInfo) {
                                            $ext = strtolower($fileInfo->getExtension());
                                            if (in_array($ext, $types)) {
                                                $arquivo = $fileInfo->getFilename();
                                                echo "<span class='m-auto lead'>";
                                                echo $arquivo . " - <a href='" . URLADM . "assets/files/processLibrary/" . $valorForm['pl_id'] . "/$arquivo' class='btn btn-dark btn-sm mr-1' download><i class='fas fa-download'></i> Baixar</a>";
                                                echo "<a href='" . URLADM . "edit-process-library/process-library/" . $valorForm['pl_id'] . "?id=" . $valorForm['pl_id'] . "&file=$arquivo' class='btn btn-dark btn-sm'><i class='fa-solid fa-trash'></i></a><br>";
                                                echo "</span>";
                                            }
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditProcess" type="submit" class="btn btn-warning" value="Salvar">

        </form>
    </div>
</div>
