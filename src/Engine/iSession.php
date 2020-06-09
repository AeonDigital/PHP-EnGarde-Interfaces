<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Engine;

use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;








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
     * Retorna o tipo de sessão que a instância concreta representa.
     *
     * @return      string
     */
    function retrieveSessionType() : string;



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
     * Retorna os dados da sessão autenticada que está atualmente reconhecida,
     * ativa e válida.
     *
     * @return      ?array
     */
    function retrieveAuthenticatedSession() : ?array;



    /**
     * Retorna os dados de um usuário autenticado que esteja associado a sessão
     * que está reconhecida, ativa e válida.
     *
     * @return      ?array
     */
    function retrieveAuthenticatedUser() : ?array;
    /**
     * Retorna o perfil de segurança do usuário atualmente em uso.
     *
     * @return      ?string
     */
    function retrieveAuthenticatedUserProfile() : ?string;
    /**
     * Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
     *
     * @return      ?array
     */
    function retrieveAuthenticatedUserProfiles() : ?array;



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
     * Retorna o status atual relativo aos testes de segurança.
     *
     * @return      string
     */
    function retrieveSecurityStatus() : string;





    /**
     * Verifica se o UA possui uma sessão válida para ser usada.
     *
     * @return      void
     */
    function authenticateUserAgentSession() : void;





    /**
     * Efetua o login do usuário.
     *
     * @param       string $userLogin
     *              Nome do usuário.
     *
     * @param       string $userPassword
     *              Senha de autenticação.
     *
     * @return      bool
     *              Retornará ``true`` quando o login for realizado com
     *              sucesso e ``false`` quando falhar por qualquer motivo.
     */
    function executeLogin(
        string $userLogin,
        string $userPassword
    ) : bool;
    /**
     * Dá ao usuário atualmente logado um tipo especial de permissão (geralmente concedida
     * por um usuário de nível superior) para que ele possa executar determinadas ações que
     * de outra forma não seriam possíveis.
     *
     * @param       string $userLogin
     *              Nome do usuário.
     *
     * @param       string $userPassword
     *              Senha de autenticação.
     *
     * @param       string $typeOfPermission
     *              Tipo de permissão concedida.
     *
     * @return      bool
     */
    function grantSpecialPermission(
        string $userLogin,
        string $userPassword,
        string $typeOfPermission
    ) : bool;
    /**
     * Efetua o logout do usuário na aplicação e encerra sua sessão.
     *
     * @return      bool
     */
    function executeLogout() : bool;
}
