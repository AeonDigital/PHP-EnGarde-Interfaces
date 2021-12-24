<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Engine;










/**
 * Define uma Aplicação que terá como responsabilidade servir ao ``UA`` a rota
 * que ele está requisitando.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iApplication
{





    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    function run() : void;
}
