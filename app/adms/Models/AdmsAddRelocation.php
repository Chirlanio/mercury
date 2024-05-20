<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddRelocation
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsAddRelocation {

    private $Resultado;
    private $Dados;
    private $File;
    private $FileUp;
    private $FileResult;

    function getResultado() {
        return $this->Resultado;
    }

    public function addRelocation(array $Dados) {
        $this->Dados = $Dados['data'];
        $this->FileUp = $Dados['data_file'];

        if (!empty($this->Dados['relocation_name'])) {
            $this->insertRelocation();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Selecione um arquivo do tipo \".csv ou .txt\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
        if ($this->FileUp['type'] == 'text/csv' OR $this->FileUp['type'] == 'text/plain') {
            $this->File = fopen($this->FileUp['tmp_name'], "r");
            while ($row = fgetcsv($this->File, 2000, ";")) {
                $this->FileResult['adms_relocation_id'] = $this->FileUp['adms_relocation_id'];
                $this->FileResult['source_store_id'] = $row[0];
                $this->FileResult['destination_store_id'] = $row[1];
                $this->FileResult['product_reference'] = $row[2];
                $this->FileResult['size'] = $row[3];
                $this->FileResult['quantity_requested'] = $row[4];

                $this->insertRelocationItems();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Selecione um arquivo do tipo \".csv ou .txt\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
        $this->valFile();
    }

    private function insertRelocation() {
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $addRelocation = new \App\adms\Models\helper\AdmsCreate;
        $addRelocation->exeCreate("adms_relocations", $this->Dados);
        if ($addRelocation->getResult()) {
            if (empty($this->FileUp['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Remanejo</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->FileUp['adms_relocation_id'] = $addRelocation->getResult();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Remanejo não cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function insertRelocationItems() {
        $this->FileResult['created'] = date("Y-m-d H:i:s");

        $addRelocation = new \App\adms\Models\helper\AdmsCreate;
        $addRelocation->exeCreate("adms_relocation_items", $this->FileResult);
        if ($addRelocation->getResult()) {
            $this->Resultado = true;
        } else {
            $this->Resultado = false;
        }
    }

    private function valFile() {

        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->FileUp, 'assets/files/relocations/' . $this->FileUp['adms_relocation_id'] . "/", date("YmdHis") . "-" . $this->FileUp['name']);
        if ($uploadArq->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Remanejo</strong> cadastrado com sucesso, arquivo salvo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Remanejo cadastrado, o arquivo não foi salvo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id lj_ori_id, nome loja_origem FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id lj_ori_id, nome loja_origem FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_ori'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == 7) {
            $listar->fullRead("SELECT id lj_des_id, nome loja_destino FROM tb_lojas WHERE status_id <>:status_id AND id <>:id ORDER BY id ASC", "status_id=2&id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id lj_des_id, nome loja_destino FROM tb_lojas WHERE status_id <>:status_id ORDER BY id ASC", "status_id=2");
        }
        $registro['loja_des'] = $listar->getResult();

        $this->Resultado = ['loja_ori' => $registro['loja_ori'], 'loja_des' => $registro['loja_des']];

        return $this->Resultado;
    }
}
