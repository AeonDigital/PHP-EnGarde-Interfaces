<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Engine;

use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;








/**
 * Interface para um roteador.
 * Um roteador tem o trabalho de pré-processar todas as rotas configuradas para uma aplicação
 * além de identificar, a partir da URL requisitada, qual exatamente está sendo requerida.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iRouter
{





    /**
     * Deve verificar quando a aplicação possui alterações que envolvam a necessidade de efetuar
     * uma atualização nos dados das rotas.
     *
     * Idealmente verificará se os controllers da aplicação possuem alguma alteração posterior
     * a data do último processamento, e, estando o sistema configurado para atualizar
     * automaticamente as rotas, deverá retornar ``true``.
     *
     * Também deve retornar ``true`` quando, por qualquer motivo definido na implementação, o
     * processamento anterior não existir ou for considerado como desatualizado.
     *
     * @return      bool
     */
    function isToProcessApplicationRoutes() : bool;



    /**
     * Varre os arquivos de ``controllers`` da aplicação e efetua o processamento das mesmas.
     * Idealmente o resultado deve ser um arquivo de configuração contendo todos os dados necessários
     * para a execução de cada rota de forma individual.
     *
     * @return      void
     *
     * @throws      \RuntimeException
     *              Caso algum erro ocorra no processo.
     */
    function processApplicationRoutes() : void;



    /**
     * Identifica se a rota passada corresponde a alguma das rotas configuradas para a
     * aplicação e retorna um array associativo contendo todos os dados correspondentes a mesma.
     *
     * Em caso de falha na identificação da rota será retornado ``null``.
     *
     * @param       string $targetRoute
     *              Porção relativa da ``URI`` que está sendo executada.
     *              É necessário constar na rota, como sua primeira parte, o nome da aplicação
     *              que está sendo executada.
     *              Não deve constar quaisquer parametros ``querystring`` ou ``fragment``.
     *
     * @return      ?array
     */
    function selectTargetRawRoute(string $targetRoute) : ?array;
}
