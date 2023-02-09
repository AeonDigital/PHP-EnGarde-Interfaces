<?php

declare(strict_types=1);

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
     * @return iCookie
     */
    public function retrieveSecurityCookie(): iCookie;
    /**
     * Caminho completo até o diretório de dados da aplicação.
     * Usado em casos onde as informações de sessão estão armazenadas fisicamente
     * junto com a aplicação.
     *
     * @return string
     */
    public function retrievePathToLocalData(): string;



    /**
     * Informará ``true`` caso a implementação esteja apta a utilizar um
     * banco de dados.
     *
     * @return bool
     */
    public function hasDataBase(): bool;
    /**
     * Retorna um objeto ``iDAL`` configurado com as credenciais correlacionadas
     * ao atual perfil de usuário sendo usado pelo UA.
     *
     * @return iDAL
     */
    public function getDAL(): iDAL;



    /**
     * Retorna os dados da sessão autenticada que está atualmente reconhecida,
     * ativa e válida.
     *
     * @return ?array
     */
    public function retrieveSession(): ?array;



    /**
     * Retorna os dados de um usuário autenticado que esteja associado a sessão
     * que está reconhecida, ativa e válida.
     *
     * @return ?array
     */
    public function retrieveUser(): ?array;
    /**
     * Retorna o objeto completo do perfil de usuário atualmente em uso.
     *
     * @return ?array
     */
    public function retrieveUserProfile(): ?array;
    /**
     * Retorna o perfil de segurança do usuário atualmente em uso.
     *
     * @return ?string
     */
    public function retrieveUserProfileName(): ?string;
    /**
     * Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
     *
     * @param string $applicationName
     * Se definido, retornará apenas os profiles que correspondem ao nome da
     * aplicação indicada.
     *
     * @return ?array
     */
    public function retrieveUserProfiles(string $applicationName = ""): ?array;
    /**
     * Efetua a troca do perfil de segurança atualmente em uso por outro que deve estar
     * na coleção de perfis disponíveis para este mesmo usuário.
     *
     * @return ?array
     */
    public function changeUserProfile(string $profile): bool;



    /**
     * Retorna o status atual relativo a identificação e autenticação do UA
     * para a sessão atual.
     *
     * @return string
     */
    public function retrieveSecurityStatus(): string;





    /**
     * Efetua o login do usuário.
     *
     * @param string $userName
     * Nome do usuário.
     *
     * @param string $userPassword
     * Senha de autenticação.
     *
     * @param string $grantPermission
     * Permissão que será concedida a uma sessão autenticada
     *
     * @param string $sessionHash
     * Sessão autenticada que receberá a permissão especial.
     *
     * @return bool
     * Retornará ``true`` quando o login for realizado com
     * sucesso e ``false`` quando falhar por qualquer motivo.
     */
    public function executeLogin(
        string $userName,
        string $userPassword,
        string $grantPermission = "",
        string $sessionHash = ""
    ): bool;
    /**
     * Verifica se o UA possui uma sessão válida para ser usada.
     *
     * @return bool
     */
    public function checkUserAgentSession(): bool;
    /**
     * Efetua o logout do usuário na aplicação e encerra sua sessão.
     *
     * @return bool
     */
    public function executeLogout(): bool;




    /**
     * Verifica se o usuário atualmente identificado possui permissão de acesso
     * na rota identificada a partir do seu perfil em uso.
     *
     * @param string $methodHttp
     * Método ``Http`` sendo usado.
     *
     * @param string $rawRoute
     * Rota evocada em seu estado bruto (contendo o nome da aplicação).
     *
     * @return bool
     */
    public function checkRoutePermission(
        string $methodHttp,
        string $rawRoute
    ): bool;





    /**
     * Efetua o pré-processamento das rotas e suas respectivas permissões de acesso.
     *
     * @param string $pathToAppRoutes
     * Caminho completo até o arquivo de rotas pré-configuradas.
     *
     * @return void
     */
    public function processRoutesPermissions(string $pathToAppRoutes): void;






    /**
     * Gera um registro de atividade para a requisição atual.
     *
     * @param string $methodHttp
     * Método ``Http`` evocado.
     *
     * @param string $fullURL
     * URL completa evocada pelo UA.
     *
     * @param ?array $postData
     * Dados que foram postados na requisição.
     *
     * @param string $controller
     * Controller que foi acionado.
     *
     * @param string $action
     * Nome da action que foi executada.
     *
     * @param string $activity
     * Atividade executada.
     *
     * @param string $note
     * Observação.
     *
     * @return bool
     */
    public function registerLogActivity(
        string $methodHttp,
        string $fullURL,
        ?array $postData,
        string $controller,
        string $action,
        string $activity,
        string $note
    ): bool;
}