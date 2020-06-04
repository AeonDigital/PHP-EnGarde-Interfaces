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
     * Retorna os dados de um usuário que esteja carregado no momento.
     *
     * @return      ?array
     */
    function retrieveUserData() : ?array;



    /**
     * Permite definir os dados existentes do cookie de segurança.
     *
     * @param       array $cookieData
     *              Array associativo do cookie de segurança.
     *
     * @return      void
     */
    function setSecurityCookieData(array $securityCookieData) : void;



    /**
     * Retorna o status atual do login do UA.
     *
     * @return      string
     */
    function retrieveLoginStatus() : string;
    /**
     * Retorna o status atual da navegação do UA.
     *
     * @return      string
     */
    function retrieveBrowseStatus() : string;



    /**
     * Permite definir o diretório onde os dados da aplicação estão armazenados.
     *
     * @param       string $pathToLocalData
     *              Caminho completo até o diretório de dados.
     *
     * @return      void
     */
    function setPathToLocalData(string $pathToLocalData) : void;
    /**
     * Resgata o caminho completo até onde os dados da aplicação estão armazenados.
     *
     * @return      string
     */
    function getPathToLocalData() : string;



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
     * @return      bool
     */
    function loadSessionData(string $sessionHash) : bool;
    /**
     * Carrega as informações do usuário de ``userName`` indicado.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @return      bool
     */
    function loadUserData(string $userName) : bool;



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
