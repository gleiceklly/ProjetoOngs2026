<?php

namespace Core\Library;

class Erros
{
    /**
    * controller not found
     *
     *
     *
     * @return void
     */

    public static function controllerNotFound ($nomeController = DEFAULT_CONTROLLER) {
        echo "Controller ({$nomeController}) não localizado na estrutura do projeto.";
    }

    /**
    * method not found
     *
     *
     *
     * @return void
     */

    public static function methodNotFound ($nomeMethod = DEFAULT_METHOD) {
        echo "Método ({$nomeMethod}) não localizado no controller.";
    }
}