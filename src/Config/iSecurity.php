<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;

use AeonDigital\Interfaces\DAL\iDAL;








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
     * Retorna um array associativo contendo os nomes de perfils de usuário e
     * respectivas credenciais de acesso ao banco de dados.
     *
     * @param       string $userProfile
     *              Se definido, retornará exclusivamente os dados referentes
     *              a este próprio perfil.
     *              Se o perfil indicado não existir, deverá retornar ``[]``.
     *
     * @return      array
     */
    function getDBCredentials(string $userProfile = "") : array;
    /**
     * Retorna um objeto ``iDAL`` configurado com as credenciais correlacionadas
     * ao atual perfil de usuário sendo usado pelo UA.
     *
     * @return      iDAL
     */
    function getDAL() : iDAL;





    /**
     * Verifica se a informação de autenticação passada corresponde a uma sessão
     * reconhecida como ativa e válida para a requisição realizada pelo UA.
     *
     * Em caso afirmativo, carrega os dados do usuário autenticado.
     *
     * @param       string $sessionHash
     *              Hash de autenticação da sessão do UA.
     *
     * @return      bool
     */
    function checkAuthenticationInformation(string $sessionHash) : bool;
    /**
     * Retorna o perfil do usuário atualmente reconhecido pelo sistema de segurança.
     *
     * @return      ?array
     */
    function getAuthenticatedUser() : ?array;
    /**
     * Retorna o perfil do usuário atualmente reconhecido pelo sistema de segurança.
     *
     * @return      string
     */
    function getUserProfile() : string;
    /**
     * Retorna uma coleção de perfis de segurança que o usuário atualmente reconhecido
     * tem autorização de utilizar.
     *
     * @return      array
     */
    function getAllowedUserProfiles() : array;





    /**
     * Efetua o login do usuário.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @param       string $userPassword
     *              Senha de autenticação.
     *
     * @param       string $fullPathToLocalData
     *              Caminho completo até o diretório que armazena dados locais.
     *              (deve ser usado apenas para casos onde sessionType = "local")
     *
     * @return      bool
     *              Retornará ``true`` quando o login for realizado com
     *              sucesso e ``false`` quando falhar por qualquer motivo.
     */
    function executeLogin(
        string $userName,
        string $userPassword,
        string $fullPathToLocalData = ""
    ) : bool;
    /**
     * Dá ao usuário atualmente logado um tipo especial de permissão (geralmente concedida
     * por um usuário de nível superior) para que ele possa executar determinadas ações que
     * de outra forma não seriam possíveis.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @param       string $userPassword
     *              Senha de autenticação.
     *
     * @param       string $typeOfPermission
     *              Tipo de permissão concedida.
     *
     * @param       string $fullPathToLocalData
     *              Caminho completo até o diretório que armazena dados locais.
     *              (deve ser usado apenas para casos onde sessionType = "local")
     *
     * @return      bool
     */
    function grantSpecialPermission(
        string $userName,
        string $userPassword,
        string $typeOfPermission,
        string $fullPathToLocalData = ""
    ) : bool;
    /**
     * Efetua o logout do usuário na aplicação e encerra sua sessão.
     *
     * @return      bool
     */
    function executeLogout() : bool;
    /**
     * Retorna a mensagem de erro para casos em que o login falhou.
     *
     * @return      string
     */
    function getLoginErrorMessage() : string;





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
