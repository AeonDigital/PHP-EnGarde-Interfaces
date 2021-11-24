<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;










/**
 * Interface usada para representar as configuração de segurança para uma aplicação.
 *
 * Nenhuma das propriedades definidas devem poder ser sobrescritas.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iSecurity
{





    /**
     * Retornará ``true`` se a aplicação estiver configurada para usar as definições de segurança.
     * Quando ``false`` indica que a aplicação é pública.
     *
     * @return      bool
     */
    function getIsActive() : bool;



    /**
     * Retornará o nome do cookie que carrega informações da sessão atual do usuário.
     *
     * @return      string
     */
    function getDataCookieName() : string;



    /**
     * Retornará o nome do cookie de autenticação.
     *
     * @return      string
     */
    function getSecurityCookieName() : string;



    /**
     * Retorna a rota para o local onde o usuário faz login.
     *
     * @return      string
     */
    function getRouteToLogin() : string;



    /**
     * Retorna a rota para o local onde o usuário deve ser direcionado quando efetua o login.
     *
     * @return      string
     */
    function getRouteToStart() : string;



    /**
     * Retorna a rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
     *
     * @return      string
     */
    function getRouteToResetPassword() : string;



    /**
     * Retorna uma coleção de nomes de campos que servem como chaves identificadoras
     * para os usuários do sistema.
     *
     * @return      array
     */
    function getLoginKeyNames() : array;



    /**
     * Retornará o Id do usuário anonimo da aplicação.
     *
     * @return      int
     */
    function getAnonymousId() : int;



    /**
     * Retorna o nome de uma classe que implemente a interface
     * ``AeonDigital\EnGarde\Interfaces\Engine\iSession`` e que será responsável pelo
     * controle das sessões de UA na aplicação.
     *
     * @return      string
     */
    function getSessionNamespace() : string;



    /**
     * Indica se as sessões devem ser renovar a cada iteração do usuário.
     * O padrão é ``true``.
     *
     * @return      bool
     */
    function getIsSessionRenew() : bool;



    /**
     * Retornará o tempo (em minutos) que cada sessão deve suportar de inatividade.
     * O padrão são 40 minutos.
     *
     * @return      int
     */
    function getSessionTimeout() : int;



    /**
     * Retornará o limite de falhas de login permitidas para um mesmo ``IP`` em um determinado
     * periodo. O padrão são 50 tentativas.
     *
     * @return      int
     */
    function getAllowedFaultByIP() : int;



    /**
     * Retornará o tempo de bloqueio para um ``IP`` [em minutos].
     * O padrão são 50 minutos.
     *
     * @return      int
     */
    function getIPBlockTimeout() : int;



    /**
     * Retornará o limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
     * O padrão são 5 tentativas.
     *
     * @return      int
     */
    function getAllowedFaultByLogin() : int;



    /**
     * Retornará o tempo de bloqueio para um Login [em minutos].
     * O padrão são 20 minutos.
     *
     * @return      int
     */
    function getLoginBlockTimeout() : int;





    /**
     * Retorna uma coleção de intervalos de IPs que tem permissão de acessar a aplicação.
     *
     * Isto implica em dizer que a regra de segurança excluirá de acesso toda requisição que
     * venha de um IP que não esteja na lista previamente definida.
     * [tudo é proibido até que seja liberado]
     *
     * @return      array
     */
    function getAllowedIPRanges() : array;
    /**
     * Retorna uma coleção de intervalos de IPs que estão bloqueados de acessar a aplicação.
     *
     * Isto implica em dizer que a regra de segurança permitirá o acesso de toda requisição que
     * venha de um IP que não esteja na lista previamente definida.
     * [tudo é permitido até que seja bloqueado]
     *
     * @return      array
     */
    function getDeniedIPRanges() : array;
    /**
     * Identifia se o IP informado está dentro dos ranges definidos como válidos para o
     * acesso a esta aplicação.
     *
     * As regras ``AllowedIPRanges`` e ``DeniedIPRanges`` são auto-excludentes, ou seja, apenas
     * uma delas pode estar valendo e, na presença de ambos conjuntos existirem, a regra
     * ``AllowedIPRanges`` (que é mais restritiva) é que prevalecerá para este teste.
     *
     * Se nenhuma das regras estiver definido, todas as requisições serão aceitas.
     *
     * @param       string $ip
     *              IP que será testado em seu formato ``human readable``.
     *
     * @return      bool
     */
    function isAllowedIP(string $ip) : bool;






    /**
     * Retorna uma instância configurada a partir de um array que contenha
     * as chaves correlacionadas a cada propriedade aqui definida.
     *
     * @param       array $config
     *              Array associativo contendo os valores a serem definidos para a instância.
     *
     * @return      iSecurity
     */
    static function fromArray(array $config) : iSecurity;
}
