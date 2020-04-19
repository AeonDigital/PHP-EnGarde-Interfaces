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
     * Retornará o Id do usuário anonimo da aplicação.
     *
     * @return      int
     */
    function getAnonymousId() : int;



    /**
     * Retorna o tipo de sessão que está sendo usada.
     * - "local"     :  A sessão autenticada do usuário é armazenada na própria aplicação.
     * - "database"  :  A sessão é armazenada num banco de dados.
     *
     * O formato ``local`` deve ser utilizado apenas quando não há realmente um banco de dados
     * disponível.
     *
     * @return      string
     */
    function getSessionType() : string;



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
