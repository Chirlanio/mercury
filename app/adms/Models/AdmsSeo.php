<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsSeo
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsSeo {

    private $Resultado;
    private $UrlController;
    private $Url;
    private $UrlConjunto;
    private $UrlParamentro;
    //private $ResultadoFac;
    private $Tabela;
    private $Coluna;
    private $listarSeobasico;
    private static $Format;

    public function listarSeo($Tabela = null, $Coluna = null, $Valor = null) {
        $this->montarUrl();
        $this->UrlParamentro = (string) $Valor;
        if (!empty($this->UrlParamentro)) {
            $this->Tabela = (string) $Tabela;
            $this->Coluna = (string) $Coluna;
            $this->listarSeobasico = $this->listarSeoPg();
            $this->listarSeoPer();
        } else {
            $this->listarSeoPg();
            $this->Resultado[0]['dir_img'] = 'pagina';
        }
        //$this->listarSeoFac();
        return $this->Resultado;
    }

    private function listarSeoPg() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT pg.id, pg.menu_controller, pg.menu_metodo, pg.nome_pagina, pg.imagem
                FROM adms_paginas pg
                WHERE pg.controller =:controller
                ORDER BY pg.id ASC
                LIMIT :limit', "controller={$this->UrlController}&limit=1");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    private function listarSeoPer() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id, titulo, descricao, keywords, imagem
                FROM {$this->Tabela} 
                WHERE {$this->Coluna} =:valor
                ORDER BY id ASC
                LIMIT :limit", "valor={$this->UrlParamentro}&limit=1");

        $this->Resultado = $listar->getResultado();
        $this->Resultado[0]['endereco'] = $this->listarSeobasico[0]['endereco'] . '/' . $this->UrlParamentro;
        $this->Resultado[0]['dir_img'] = $this->listarSeobasico[0]['endereco'];
    }

    /*private function listarSeoFac() {
        $listarFac = new \App\adms\Models\helper\AdmsRead();
        $listarFac->fullRead('SELECT og_site_name, og_locale, fb_admins, twitter_site FROM adms_seo WHERE id =:id LIMIT :limit', "id=1&limit=1");
        $this->ResultadoFac = $listarFac->getResultado();
        $this->Resultado[0]['og_site_name'] = $this->ResultadoFac[0]['og_site_name'];
        $this->Resultado[0]['og_locale'] = $this->ResultadoFac[0]['og_locale'];
        $this->Resultado[0]['fb_admins'] = $this->ResultadoFac[0]['fb_admins'];
        $this->Resultado[0]['twitter_site'] = $this->ResultadoFac[0]['twitter_site'];
    }*/

    private function montarUrl() {
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->Url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            $this->limparUrl();
            $this->UrlConjunto = explode("/", $this->Url);

            if (isset($this->UrlConjunto[0])) {
                $this->UrlController = $this->slugController($this->UrlConjunto[0]);
            } else {
                $this->UrlController = $this->slugController(CONTROLER);
            }

            if (isset($this->UrlConjunto[1])) {
                $this->UrlParametro = $this->UrlConjunto[1];
            } else {
                $this->UrlParametro = null;
            }
            //echo "URL: {$this->Url} <br>";
            //echo "Controlle: {$this->UrlController} <br>";
        } else {
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlParametro = null;
        }
    }

    private function limparUrl() {
        //Eliminar as tags
        $this->Url = strip_tags($this->Url);
        //Eliminar espaços em branco
        $this->Url = trim($this->Url);
        //Eliminar a barra no final da URL
        $this->Url = rtrim($this->Url, "/");

        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
        $this->Url = strtr(utf8_decode($this->Url), utf8_decode(self::$Format['a']), self::$Format['b']);
    }

    private function slugController($SlugController) {
        $UrlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($SlugController)))));
        return $UrlController;
    }

}
