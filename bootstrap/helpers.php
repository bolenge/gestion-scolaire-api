<?php
    /**
     * Les fonctions rajouter au projet
     */

    use Ekolo\Framework\Bootstrap\Config;
    use Ekolo\Framework\Http\Request;

    if (!function_exists('locales')) {
        /**
         * Permet de renvoyer le locale d'un objet
         * @param string $object L'objet en question
         * @param string $lang La langue
         * @return array
         */
        function locales(string $object, string $lang = 'fr') {
            $lang = request()->headers()->has('Locale') ? request()->headers()->get('Locale') : $lang;
            $locales_path = config('path.locales');
            $locales_path = __DIR__.'/../'.$locales_path.'/'.$object.'/'.$lang.'.php';

            if (!file_exists($locales_path)) {
                throw new \Exception('Le fichier de la langue "'.$object.'/'.$lang.'.php n\'existe pas');
            }

            $results = require $locales_path;

            return $results;
        }
    }

    if (!function_exists('base_path')) {
        /**
         * Renvoi le base path de l'application
         * @return string
         */
        function base_path(){
            return (new Config)->basePath();
        }
    }

    if (!function_exists('request')) {
        /**
         * Renvoi l'instance de Ekolo\Framework\Http\Request
         * @return Request
         */
        function request(){
            return new Request;
        }
    }