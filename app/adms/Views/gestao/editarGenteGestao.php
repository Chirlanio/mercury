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
                <h2 class="display-4 titulo">Editar Dados - Gente & Gestão</h2>
            </div>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail - Gerência</label>
                    <input name="email_gerente" type="email" class="form-control" placeholder="Digite o e-mail da gerência" value="<?php
                    if (isset($valorForm['email_gerente'])) {
                        echo $valorForm['email_gerente'];
                    }
                    ?>" autofocus required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail - Treinamento</label>
                    <input name="email_treinamento" type="email" class="form-control" placeholder="E-mail de treinamento" value="<?php
                    if (isset($valorForm['email_treinamento'])) {
                        echo $valorForm['email_treinamento'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail - Recrutamento</label>
                    <input name="email_curriculo" type="email" class="form-control" placeholder="Recrutamento e seleção" value="<?php
                    if (isset($valorForm['email_curriculo'])) {
                        echo $valorForm['email_curriculo'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail - Fardamento</label>
                    <input name="email_farda_selecao" type="text" class="form-control" placeholder="E-mail de remetente" value="<?php
                    if (isset($valorForm['email_farda_selecao'])) {
                        echo $valorForm['email_farda_selecao'];
                    }
                    ?>">
                </div>
            </div>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Avisos</label>
                    <textarea name="aviso" type="text" class="form-control editorCK" placeholder="Avisos">
                        <?php
                        if (isset($valorForm['aviso'])) {
                            echo $valorForm['aviso'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <hr>
            <!<!-- Recrutamento -->
            <div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Descrição - Recrutamento</label>
                        <textarea name="descricao_recrutamento" class="form-control editorCKQ">
                            <?php
                            if (isset($valorForm['descricao_recrutamento'])) {
                                echo $valorForm['descricao_recrutamento'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Observações - Recrutamento</label>
                        <textarea name="obs_recrutamento" class="form-control editorObs">
                            <?php
                            if (isset($valorForm['obs_recrutamento'])) {
                                echo $valorForm['obs_recrutamento'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">*</span> Link - Recrutamento</label>
                        <input name="link_recrutamento" type="text" class="form-control" placeholder="Link para solicitação" value="<?php
                        if (isset($valorForm['link_recrutamento'])) {
                            echo $valorForm['link_recrutamento'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <hr>
            <!-- Fardamento -->
            <div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Descrição - Fardamento</label>
                        <textarea name="descricao_fardamento" class="form-control editorFarUm">
                            <?php
                            if (isset($valorForm['descricao_fardamento'])) {
                                echo $valorForm['descricao_fardamento'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Observações - Fardamento</label>
                        <textarea name="obs_fardamento" class="form-control editorFarDois">
                            <?php
                            if (isset($valorForm['obs_fardamento'])) {
                                echo $valorForm['obs_fardamento'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">*</span> Link - Fardamento</label>
                        <input name="link_fardamento" type="text" class="form-control" placeholder="Link para solicitação" value="<?php
                        if (isset($valorForm['link_fardamento'])) {
                            echo $valorForm['link_fardamento'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <hr>
            <!-- Matriz -->
            <div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Descrição - Matriz Disciplinar</label>
                        <textarea name="descricao_matriz" class="form-control editorMatUm">
                            <?php
                            if (isset($valorForm['descricao_matriz'])) {
                                echo $valorForm['descricao_matriz'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Observações - Matriz Disciplinar</label>
                        <textarea name="obs_matriz" class="form-control editorMatDois">
                            <?php
                            if (isset($valorForm['obs_matriz'])) {
                                echo $valorForm['obs_matriz'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="link_matriz"><span class="text-danger">*</span> Link - Matriz Disciplinar</label>
                        <input name="link_matriz" id="link_matriz" type="text" class="form-control" placeholder="Link para solicitação" value="<?php
                        if (isset($valorForm['link_matriz'])) {
                            echo $valorForm['link_matriz'];
                        }
                        ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="contato_matriz"><span class="text-danger">*</span> Contato - Matriz Disciplinar</label>
                        <input name="contato_matriz" id="phone_with_ddd" type="text" class="form-control phone_with_ddd" placeholder="Link para solicitação" value="<?php
                        if (isset($valorForm['contato_matriz'])) {
                            echo $valorForm['contato_matriz'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <hr>
            <!-- Desligamentos -->
            <div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Descrição - Desligamentos</label>
                        <textarea name="descricao_desligamento" class="form-control editorDesUm">
                            <?php
                            if (isset($valorForm['descricao_desligamento'])) {
                                echo $valorForm['descricao_desligamento'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">* </span>Observações - Desligamentos</label>
                        <textarea name="obs_desligamento" class="form-control editorDesDois">
                            <?php
                            if (isset($valorForm['obs_desligamento'])) {
                                echo $valorForm['obs_desligamento'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group mb-3 col-md-12 border-bottom">
                        <div class="form-group">
                            <input name="arquivo_antigo" type="hidden" value="<?php
                            if (isset($valorForm['arquivo'])) {
                                echo $valorForm['arquivo'];
                            } elseif (isset($valorForm['arquivo_antigo'])) {
                                echo $valorForm['arquivo_antigo'];
                            }
                            ?>">
                            <label for="arquivo"><span class="text-danger">* </span>Arquivo</label>
                            <input name="arquivo" type="file" class="form-control-file" value="<?php
                            if (isset($valorForm['arquivo_antigo'])) {
                                echo $valorForm['arquivo_antigo'];
                            } elseif (isset($valorForm['arquivo'])) {
                                echo $valorForm['arquivo'];
                            }
                            ?>">
                        </div>
                    </div>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditGenteGestao" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
