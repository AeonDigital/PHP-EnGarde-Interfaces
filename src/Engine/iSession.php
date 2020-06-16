<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Engine;

use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\Interfaces\DAL\iDAL as iDAL;







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
     * Cookie de segurança que identifica a sessão atualmente setada.
     *
     * @return      iCookie
     */
    function retrieveSecurityCookie() : iCookie;
    /**
     * Caminho completo até o diretório de dados da aplicação.
     * Usado em casos onde as informações de sessão estão armazenadas fisicamente
     * junto com a aplicação.
     *
     * @return      string
     */
    function retrievePathToLocalData() : string;



    /**
     * Informará ``true`` caso a implementação esteja apta a utilizar um
     * banco de dados.
     *
     * @return      bool
     */
    function hasDataBase() : bool;
    /**
     * Retorna um objeto ``iDAL`` configurado com as credenciais correlacionadas
     * ao atual perfil de usuário sendo usado pelo UA.
     *
     * @return      iDAL
     */
    function getDAL() : iDAL;



    /**
     * Retorna os dados da sessão autenticada que está atualmente reconhecida,
     * ativa e válida.
     *
     * @return      ?array
     */
    function retrieveSession() : ?array;



    /**
     * Retorna os dados de um usuário autenticado que esteja associado a sessão
     * que está reconhecida, ativa e válida.
     *
     * @return      ?array
     */
    function retrieveUser() : ?array;
    /**
     * Retorna o objeto completo do perfil de usuário atualmente em uso.
     *
     * @return      ?array
     */
    function retrieveUserProfile() : ?array;
    /**
     * Retorna o perfil de segurança do usuário atualmente em uso.
     *
     * @return      ?string
     */
    function retrieveUserProfileName() : ?string;
    /**
     * Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
     *
     * @return      ?array
     */
    function retrieveUserProfiles() : ?array;
    /**
     * Efetua a troca do perfil de segurança atualmente em uso por outro que deve estar
     * na coleção de perfis disponíveis para este mesmo usuário.
     *
     * @return      ?array
     */
    function changeUserProfile(string $profile) : bool;



    /**
     * Retorna o status atual relativo a identificação e autenticação do UA
     * para a sessão atual.
     *
     * @return      string
     */
    function retrieveSecurityStatus() : string;





    /**
     * Efetua o login do usuário.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @param       string $userPassword
     *              Senha de autenticação.
     *
     * @param       string $grantPermission
     *              Permissão que será concedida a uma sessão autenticada
     *
     * @param       string $sessionHash
     *              Sessão autenticada que receberá a permissão especial.
     *
     * @return      bool
     *              Retornará ``true`` quando o login for realizado com
     *              sucesso e ``false`` quando falhar por qualquer motivo.
     */
    function executeLogin(
        string $userName,
        string $userPassword,
        string $grantPermission = "",
        string $sessionHash = ""
    ) : bool;
    /**
     * Verifica se o UA possui uma sessão válida para ser usada.
     *
     * @return      bool
     */
    function checkUserAgentSession() : bool;
    /**
     * Efetua o logout do usuário na aplicação e encerra sua sessão.
     *
     * @return      bool
     */
    function executeLogout() : bool;




    /**
     * Verifica se o usuário atualmente identificado possui permissão de acesso
     * na rota identificada a partir do seu perfil em uso.
     *
     * @param       string $methodHTTP
     *              Método HTTP sendo usado.
     *
     * @param       string $rawURL
     *              URL evocada em seu estado bruto.
     *
     * @return      bool
     */
    function checkRoutePermission(
        string $methodHTTP,
        string $rawURL
    ) : bool;
    /**
     * Retorna uma URI para a qual o usuário deve ser direcionado em caso de falha
     * na verificação de permissão da rota atual.
     *
     * @return      string
     */
    function getRouteRedirect() : string;






    /**
     * Gera um registro de atividade para a requisição atual.
     *
     * @param       string $methodHTTP
     *              Método HTTP evocado.
     *
     * @param       string $fullURL
     *              URL completa evocada pelo UA.
     *
     * @param       ?array $postData
     *              Dados que foram postados na requisição.
     *
     * @param       string $controller
     *              Controller que foi acionado.
     *
     * @param       string $action
     *              Nome da action que foi executada.
     *
     * @param       string $activity
     *              Atividade executada.
     *
     * @param       string $note
     *              Observação.
     *
     * @return      bool
     */
    function registerLogActivity(
        string $methodHTTP,
        string $fullURL,
        ?array $postData,
        string $controller,
        string $action,
        string $activity,
        string $note
    ) : bool;
}
