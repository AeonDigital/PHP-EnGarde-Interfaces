<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;

use AeonDigital\Interfaces\Http\iFactory as iFactory;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\Interfaces\Engine\iSession as iSession;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;



/**
 * Interface para uma classe que representa a coleção de configurações do servidor no momento
 * em que a requisição ``Http`` é recebida.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iServer
{





    /**
     * Data e hora do momento em que a requisição que ativou a aplicação
     * chegou ao domínio.
     *
     * @return      \DateTime
     */
    function getNow() : \DateTime;



    /**
     * Resgata a versão atual do framework.
     *
     * @return      string
     */
    function getVersion() : string;





    /**
     * Resgata um array associativo contendo todas as variáveis definidas para o servidor no
     * momento atual. Normalmente retorna o conteúdo de ``$_SERVER``.
     *
     * @return      array
     *              Será retornado ``[]`` caso nada tenha sido definido.
     */
    function getServerVariables() : array;



    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma coleção de headers ``Http`` definidos.
     *
     * @return      array
     *              Retornará ``[]`` caso nenhum seja encontrado.
     */
    function getRequestHeaders() : array;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a versão do protocolo ``Http``.
     *
     * @return      string
     *              Caso não seja possível identificar a versão deve ser retornado o valor ``1.1``.
     */
    function getRequestHttpVersion() : string;
    /**
     * Resgata a identificação do UA que está executando esta requisição.
     *
     * @return      string
     */
    function getRequestUserAgent() : string;
    /**
     * Retorna o ``IP`` do UA que está executando esta requisição.
     *
     * @return      string
     */
    function getRequestUserAgentIP() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Indica se a requisição está exigindo o uso de ``Https``.
     *
     * @return      bool
     */
    function getRequestIsUseHttps() : bool;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o método ``Http`` que está sendo usado.
     *
     * @return      string
     */
    function getRequestMethod() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna ``http`` ou ``https`` conforme o protocolo que está sendo utilizado pela
     * requisição.
     *
     * @return      string
     */
    function getRequestProtocol() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o nome do domínio onde o servidor está operando.
     *
     * @return      string
     */
    function getRequestDomainName() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a parte ``path`` da ``URI`` que está sendo executada.
     *
     * @return      string
     */
    function getRequestPath() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a porta ``Http`` que está sendo evocada.
     *
     * @return      int
     */
    function getRequestPort() : int;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os cookies passados pelo ``UA`` em seu formato bruto.
     *
     * @return      string
     */
    function getRequestCookies() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os querystrings definidos na ``URI`` em seu formato bruto.
     *
     * @return      string
     */
    function getRequestQueryStrings() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     *
     * Retorna um array de objetos que implementam ``AeonDigital\Interfaces\Stream\iFileStream``
     * representando os arquivos que foram submetidos durante a requisição.
     *
     * @return      array
     *              Os arquivos são resgatados de ``$_FILES``.
     */
    function getRequestFiles() : array;





    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma string que representa toda a ``URI`` que está sendo acessada no momento.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ scheme ":" ][ "//" authority ][ "/" path ][ "?" query ]
     * ```
     *
     * Obs: A porção ``fragment``, iniciada pelo caractere ``#`` não é utilizada.
     *
     * @return      string
     */
    function getCurrentURI() : string;



    /**
     * Resgata toda a coleção de informações passadas na requisição.
     *
     * Concatena neste resultado as informações submetidas pelo UA.
     * Em caso de colisão de chaves de valores a ordem de prioridade de prevalencia será:
     *
     * - requestRouteParans
     *   Parametros nomeados na própria rota e identificados pelo processamento da mesma.
     * - $_POST
     *   Parametros passados por POST.
     * - $_GET
     *   Parametros passados por GET.
     * - "php://input"
     *   Dados obtidos do stream bruto.
     *
     * Não inclui valores passados via cookies.
     *
     * @return      array
     */
    function getPostedData() : array;










    /**
     * Retorna o endereço completo do diretório onde o domínio está sendo executado.
     *
     * @return      string
     */
    function getRootPath() : string;



    /**
     * Retorna o caminho (a partir da raiz do domínio) até o diretório onde a o framework
     * está rodando.
     *
     * @return      string
     */
    function getRootSubPath() : string;



    /**
     * Indica que as requisições feitas para o domínio devem ser realizadas sob o protocolo
     * ``Https``.
     *
     * @return      bool
     */
    function getForceHttps() : bool;



    /**
     * Retorna o tipo de ambiente que o domínio está rodando no momento.
     *
     * Valores Esperados:
     *  - ``PRD``   : Production
     *  - ``HML``   : Homolog
     *  - ``QA``    : Quality Assurance
     *  - ``DEV``   : Development
     *  - ``LCL``   : Local
     *  - ``UTEST`` : Unit Test
     *
     * @return      string
     */
    function getEnvironmentType() : string;



    /**
     * Retorna ``true`` se o domínio está em modo de debug.
     *
     * @return      bool
     */
    function getIsDebugMode() : bool;



    /**
     * Retorna ``true`` se for para as aplicações atualizar suas
     * respectivas configurações de rotas.
     *
     * @return      bool
     */
    function getIsUpdateRoutes() : bool;



    /**
     * Retorna a coleção de nomes de aplicações instaladas no domínio
     *
     * @return      array
     */
    function getHostedApps() : array;



    /**
     * Retorna o nome da aplicação padrão do domínio.
     *
     * @return      string
     */
    function getDefaultApp() : string;



    /**
     * Retorna o timezone do domínio.
     *
     * @return      string
     */
    function getDateTimeLocal() : string;



    /**
     * Retorna o tempo máximo (em segundos) para a execução das requisições.
     *
     * @return      int
     */
    function getTimeout() : int;



    /**
     * Valor máximo (em Mb) para o upload de um arquivo.
     *
     * @return      int
     */
    function getMaxFileSize() : int;



    /**
     * Valor máximo (em Mb) para a postagem de dados.
     *
     * @return      int
     */
    function getMaxPostSize() : int;



    /**
     * Resgata o caminho até a view que deve ser enviada ao ``UA`` em caso de
     * erros no domínio.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToErrorView(bool $fullPath = false) : string;
    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de necessidade
     * de envio de uma simples mensagem ``Http``.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    function getPathToHttpMessageView(bool $fullPath = false) : string;



    /**
     * Resgata o nome da classe responsável por iniciar a aplicação.
     *
     * @return      string
     */
    function getApplicationClassName() : string;



    /**
     * Retorna o nome da aplicação que deve responder a requisição ``Http`` atual.
     *
     * @return      string
     */
    function getApplicationName() : string;
    /**
     * Indica quando na ``URI`` atual o nome da aplicação a ser executada está omitida. Nestes
     * casos a aplicação padrão deve ser executada.
     *
     * @return      bool
     */
    function getIsApplicationNameOmitted() : bool;
    /**
     * Retorna o nome completo da classe da aplicação que deve ser instanciada para responder
     * a requisição atual.
     *
     * @return      string
     */
    function getApplicationNamespace() : string;
    /**
     * Retorna a URI que está sendo requisitada em ``nível de aplicação``, ou seja, irá SEMPRE
     * adicionar o nome da aplicação que está sendo chamada na primeira partícula da URI caso
     * ela esteja omitida.
     * Não irá retornar usar qualquer querystring da requisição, apenas a parte ``path``.
     *
     * @return      string
     */
    function getApplicationRequestUri() : string;
    /**
     * Retorna a URI que está sendo requisitada em ``nível de aplicação``, ou seja, irá SEMPRE
     * adicionar o nome da aplicação que está sendo chamada na primeira partícula da URI caso
     * ela esteja omitida e em adição, trará qualquer querystring definida originalmente na
     * requisição.
     *
     * @return      string
     */
    function getApplicationRequestFullUri() : string;



    /**
     * Pode retornar uma string para onde o UA deve ser redirecionado caso alguma das
     * configurações ou processamento dos presentes dados indique que tal redirecionamento
     * seja necessário.
     *
     * Retorna ``''`` caso nenhum redirecionamento seja necessário.
     *
     * @return      string
     */
    function getNewLocationPath() : string;





    /**
     * Retorna a coleção de métodos ``Http`` que devem poder ser usados pelas actions.
     * Ou seja, aqueles que os desenvolvedores terão acesso de configurar.
     *
     * Originalmente estes:
     * "GET", "POST", "PUT", "PATCH", "DELETE"
     *
     * @return      array
     */
    function getDeveloperHttpMethods() : array;
    /**
     * Retorna a coleção de métodos ``Http`` que devem poder ser controlados exclusivamente
     * pelo próprio framework.
     *
     * Originalmente estes:
     * "HEAD", "OPTIONS", "TRACE", "DEV", "CONNECT"
     *
     * @return      array
     */
    function getFrameworkHttpMethods() : array;





    /**
     * Efetua as configurações necessárias para o manipulador básico de mensagens Http.
     *
     * @return      void
     */
    function setHttpRawMessage() : void;
    /**
     * Efetua configurações para o ``PHP`` conforme as propriedades definidas para esta classe.
     *
     * Esta ação só tem efeito na primeira vez que é executada.
     *
     * @throws      \RunTimeException
     *              Caso alguma propriedade obrigatória não tenha sido definida ou seja um valor
     *              inválido.
     */
    function setPHPConfiguration() : void;





    /**
     * Retorna um objeto ``iFactory``.
     *
     * @return      iFactory
     */
    function getHttpFactory() : iFactory;
    /**
     * Retorna a instância ``iServerRequest`` a ser usada.
     *
     * @return      iServerRequest
     */
    function getServerRequest() : iServerRequest;
    /**
     * Retorna a instância ``Config\iApplication``.
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      iApplication
     */
    function getApplicationConfig(array $config = []) : iApplication;
    /**
     * Retorna a instância ``Config\iSecurity`` a ser usada.
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      ?iSecurity
     */
    function getSecurityConfig(array $config = []) : iSecurity;
    /**
     * Retorna uma instância ``iSession`` para efetuar o controle de sessão
     * de UA dentro da aplicação.
     *
     * @return      iSession
     */
    function getSecuritySession() : iSession;
    /**
     * Identifica se existem definições de seguranças.
     *
     * Normalmente isto significa verificar se os métodos ``getSecurityConfig`` e
     * ``getSecuritySession`` estão, ambos, aptos a retornarem instâncias de suas respectivas
     * classes com as configurações correspondentes.
     *
     * @return      bool
     */
    function hasDefinedSecuritySettings() : bool;
    /**
     * Retorna a instância ``Config\iRoute`` a ser usada.
     *
     * @param       ?array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @param       bool $isRaw
     *              Quando ``true`` indica que o parametro passado em ``$config`` possui as
     *              informações necessárias para a criação do objeto ``iRoute``, no entanto
     *              este precisa de algum tratamento especial antes da criação da instância.
     *
     * @return      ?iRoute
     */
    function getRouteConfig(?array $config = null, bool $isRaw = false) : ?iRoute;
    /**
     * Retorna os dados brutos referentes a rota que está sendo executada no momento.
     *
     * @return      ?array
     */
    function getRawRouteConfig() : ?array;



    /**
     * Redireciona o ``UA`` para a URL indicada.
     *
     * Esta ação interrompe o script imediatamente após o redirecionamento.
     *
     * @param       string $url
     *              URL para onde o ``UA`` será redirecionado.
     *
     * @param       int $code
     *              Código ``Http``.
     *
     * @param       string $message
     *              Mensagem ``Http``.
     *              Se nenhuma for informada irá usar a mensagem padrão que corresponda
     *              ao código ``Http`` indicado.
     *
     * @return      void
     */
    function redirectTo(string $url, int $code = 302, string $message = "") : void;



    /**
     * Inicia uma nova instância ``Config\iServer``.
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      iServer
     */
    static function fromArray(array $config) : iServer;
}
