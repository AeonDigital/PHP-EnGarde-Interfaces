<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Engine;










/**
 * Representa uma modalidade de tipo de controle de sessão de acesso.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iSession
{


    /**
     * Renova a sessão do usuário.
     *
     * @param       int $sessionTimeout
     *              Tempo (em minutos) em que a sessão deve ser expandida.
     *
     * @return      bool
     *              Retornará ``true`` caso a ação tenha sido bem sucedida, ``false``
     *              se houver alguma falha no processo.
     */
    function renewSession(int $sessionTimeout) : bool;



    /**
     * A partir do hash de autenticação da sessão do UA, carrega os dados da sessão caso ela
     * ainda esteja válida.
     *
     * @param       string $sessionHash
     *              Hash de autenticação da sessão do UA.
     *
     * @return      ?array
     *              Dados referentes a sessão atualmente válida para o UA.
     *              Retornará ``null`` caso nenhuma sessão seja identificada
     */
    function loadSessionData(string $sessionHash) : ?array;
    /**
     * Carrega as informações do usuário de ``userName`` indicado.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @return      ?array
     */
    function loadUserData(string $userName) : ?array;



    /**
     * Identifica se o IP do UA está liberado para uso na aplicação.
     *
     * @return      bool
     */
    function checkValidIP() : bool;
    /**
     * Verifica se o usuário informado existe e está apto a receber autenticação para a
     * aplicação corrente.
     *
     * @param       string $userLogin
     *              Nome do usuário.
     *
     * @return      bool
     */
    function checkUserLogin(string $userLogin) : bool;
    /**
     * Verifica se a senha do usuário confere.
     *
     * @param       string $userPassword
     *              Senha do usuário.
     *
     * @return      bool
     */
    function checkUserPassword(string $userPassword) : bool;



    /**
     * Inicia os sets de segurança necessários para que uma sessão autenticada possa iniciar.
     *
     * @param       string $sessionHash
     *              Hash de autenticação da sessão do UA.
     *
     * @return      bool
     *              Retornará ``true`` caso a ação tenha sido bem sucedida, ``false``
     *              se houver alguma falha no processo.
     */
    function inityAuthenticatedSession(string $sessionHash) : bool;
    /**
     * Encerra a sessão autenticada do usuário.
     *
     * @return      bool
     *              Retornará ``true`` caso a ação tenha sido bem sucedida, ``false``
     *              se houver alguma falha no processo.
     */
    function closeAuthenticatedSession() : bool;



    /**
     * Gera um registro de atividade do usuário.
     *
     * @param       array $logRegistryData
     *              Dados que serão usados para preencher o log de atividade.
     *
     * @return      bool
     *              Retornará ``true`` caso a ação tenha sido bem sucedida, ``false``
     *              se houver alguma falha no processo.
     */
    function registerLogActivity(array $logRegistryData) : bool;



    /**
     * Identifica se o usuário atualmente autenticado tem ou não permissão de acessar
     * a rota atual.
     *
     * @return      bool
     */
    function checkPermissionForRoute() : bool;
}
