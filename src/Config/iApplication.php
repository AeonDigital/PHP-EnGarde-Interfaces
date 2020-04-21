<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;










/**
 * Nesta interface estão as configurações básicas para o funcionamento de uma Aplicação.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iApplication
{





    /**
     * Retorna o nome da aplicação.
     *
     * @return      string
     */
    function getAppName() : string;



    /**
     * Retorna o caminho completo até o diretório raiz da aplicação.
     *
     * Todas as demais configurações que indicam diretórios ou arquivos usando caminhos
     * relativos iniciam a partir deste diretório.
     *
     * @return      string
     */
    function getAppRootPath() : string;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de rotas da aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToAppRoutes(bool $fullPath = false) : string;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de controllers
     * da aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToControllers(bool $fullPath = false) : string;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório das views
     * da aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToViews(bool $fullPath = false) : string;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os recursos para as views (imagens, JS, CSS ...).
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToViewsResources(bool $fullPath = false) : string;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os documentos de configuração das legendas.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToLocales(bool $fullPath = false) : string;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
     * para os arquivos de cache.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToCacheFiles(bool $fullPath = false) : string;










    /**
     * Retorna a rota inicial da aplicação.
     *
     * @return      string
     */
    function getStartRoute() : string;



    /**
     * Retorna a Namespace comum à todos os controllers da aplicação corrente.
     *
     * @return      string
     */
    function getControllersNamespace() : string;



    /**
     * Retorna a coleção de locales suportada pela aplicação.
     *
     * @return      array
     */
    function getLocales() : array;



    /**
     * Retorna o locale padrão para a aplicação corrente.
     *
     * @return      string
     */
    function getDefaultLocale() : string;



    /**
     * Retorna ``true`` se a aplicação deve usar o sistema de legendas.
     *
     * @return      bool
     */
    function getIsUseLabels() : bool;



    /**
     * Retorna um array associativo contendo os valores padrões para as rotas de toda a
     * aplicação. Estes valores podem ser sobrescritos pelas definições padrões dos controllers
     * e das próprias rotas.
     *
     * @return      array
     */
    function getDefaultRouteConfig() : array;










    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros
     * na aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToErrorView(bool $fullPath = false) : string;










    /**
     * Inicia uma nova instância ``Config\iApplication``.
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      iApplication
     */
    static function fromArray(array $config) : iApplication;
}
