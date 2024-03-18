<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsSlug
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsSlug {

    private $Nome;
    private $Format;

    public function nomeSlug($Nome) {
        $this->Nome = (string) $Nome;
        $this->Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $this->Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';

        $this->Nome = strtr(mb_convert_encoding($this->Nome, 'ISO-8859-1', 'UTF-8'), mb_convert_encoding($this->Format['a'], 'ISO-8859-1', 'UTF-8'), $this->Format['b']);
        $this->Nome = strip_tags($this->Nome);

        $this->Nome = str_replace(' ', '-', $this->Nome);

        $this->Nome = str_replace(array('-----', '----', '---', '--'), '-', $this->Nome);

        $this->Nome = strtolower($this->Nome);

        return $this->Nome;
    }

}
