<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;

use AeonDigital\Interfaces\Http\iFactory as iFactory;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;





/**
 * Interface para uma classe que representa a coleção de configurações do servidor no momento
 * em que a requisição ``HTTP`` é recebida.
 *
 * Normalmente servirá como um wrapper para os valores da variável ``$_SERVER``.
 * As propriedades que podem ser definidas (set) não devem poder ser sobrescritas.
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
     * momento atual.
     *
     * @return      array
     *              Será retornado ``[]`` caso nada tenha sido definido.
     */
    function getServerVariables() : array;
    /**
     * Permite definir a coleção de valores das variáveis do servidor que estão atualmente
     * definidas.
     *
     * Este método apenas pode ser efetivo se for em um ambiente de testes.
     * Num ambiente de produção estes valores devem ser definidos automaticamente pelo construtor
     * da classe.
     *
     * @param       array $oServer
     *              Array associativo com as variáveis do servidor.
     *
     * @return      void
     */
    function setServerVariables(array $oServer) : void;



    /**
     * Retorna o endereço completo do diretório onde o domínio está sendo executado.
     * Normalmente este valor vem de ``$_SERVER`` mas ele pode também ser alterado e definido
     * diretamente através do método ``setRootPath``.
     *
     * @return      string
     */
    function getRootPath() : string;
    /**
     * Define o local onde o domínio está sendo executado.
     *
     * @param       string $rootPath
     *              Endereço completo do diretório.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o caminho indicado seja inválido
     */
    function setRootPath(string $rootPath) : void;





    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma coleção de headers ``HTTP`` definidos.
     *
     * @return      array
     *              Retornará ``[]`` caso nenhum seja encontrado.
     */
    function getRequestHeaders() : array;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a versão do protocolo ``HTTP``.
     *
     * @return      string
     *              Caso não seja possível identificar a versão deve ser retornado o valor ``1.1``.
     */
    function getRequestHTTPVersion() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Indica se a requisição está exigindo o uso de ``HTTPS``.
     *
     * @return      bool
     */
    function getRequestIsUseHTTPS() : bool;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o método ``HTTP`` que está sendo usado.
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
     * Retorna a porta ``HTTP`` que está sendo evocada.
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
     * Retorna o ``IP`` do usuário que está no momento visitando o site.
     * Um valor vazio em retorno indica que não foi possível identificar o ``IP``.
     *
     * @return      string
     */
    function getClientIP() : string;





    /**
     * Resgata toda a coleção de informações passadas na requisição.
     * Sejam parametros via querystrings ou dados postados atravéz de formulários.
     *
     * Não inclui valores passados via cookies.
     *
     * @return      array
     */
    function getPostedData() : array;










    /**
     * Retorna o tipo de ambiente que o domínio está rodando no momento.
     *
     * Valores comuns:
     *  - "production"  :   Indica que trata-se de um ambiente de produção.
     *  - "development" :   Indica um ambiente de desenvolvimento e homologação.
     *  - "local"       :   Trata-se de um ambiente local; Máquina local de um programador.
     *  - "test"        :   Quando estiver efetuando testes unitários.
     *  - "testview"    :   Para testes unitários que efetuam validação de retorno de Views.
     *  - "localtest"   :   Deve funcionar tal qual "local" mas indica uma configuração para testes unitários.
     *
     * @return      string
     */
    function getEnvironmentType() : string;
    /**
     * Define o tipo de ambiente que o domínio está rodando no momento
     *
     * @param       string $environmentType
     *              Tipo de ambiente.
     *
     * @return      void
     */
    function setEnvironmentType(string $environmentType) : void;



    /**
     * Retorna ``true`` se o domínio está em modo de debug.
     *
     * @return      bool
     */
    function getIsDebugMode() : bool;
    /**
     * Define configuração para o modo de debug.
     *
     * @param       bool $isDebugMode
     *              Indique ``true`` se o domínio estiver em modo de debug.
     *
     * @return      void
     */
    function setIsDebugMode(bool $isDebugMode) : void;



    /**
     * Retorna ``true`` se for para a aplicação alvo atualizar suas respectivas rotas.
     *
     * @return      bool
     */
    function getIsUpdateRoutes() : bool;
    /**
     * Define configuração que indica para a aplicação algo que ela deve atualizar suas
     * respectivas rotas.
     *
     * @param       bool $isUpdateRoutes
     *              Indique ``true`` se for para a aplicação alvo atualizar suas rotas.
     *
     * @return      void
     */
    function setIsUpdateRoutes(bool $isUpdateRoutes) : void;



    /**
     * Retorna a coleção de nomes de aplicações instaladas no domínio
     *
     * @return      array
     */
    function getHostedApps() : array;
    /**
     * Define a coleção de nomes das aplicações instaladas no domínio.
     *
     * @param       array $hostedApps
     *              Array contendo o nome de cada uma das aplicações do domínio. Cada uma delas
     *              precisa necessariamente corresponder ao nome de um diretório que fique na
     *              raiz do domínio.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function setHostedApps(array $hostedApps) : void;



    /**
     * Retorna o nome da aplicação padrão do domínio.
     *
     * @return      string
     */
    function getDefaultApp() : string;
    /**
     * Define a aplicação padrão para o domínio.
     * A aplicação apontada precisa estar definida em ``hostedApps``.
     *
     * @param       string $defaultApp
     *              Nome da aplicação que será a padrão.
     *              Caso ``''`` será definida a primeira aplicação definida em
     *              ``hostedApps``.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function setDefaultApp(string $defaultApp) : void;



    /**
     * Retorna o timezone do domínio.
     *
     * @return      string
     */
    function getDateTimeLocal() : string;
    /**
     * Define o timezone do domínio.
     *
     * @param       string $dateTimeLocal
     *              Timezone que será definido.
     *              [Lista de fusos horários suportados](http://php.net/manual/en/timezones.php)
     *
     * @return      void
     */
    function setDateTimeLocal(string $dateTimeLocal) : void;



    /**
     * Retorna o tempo máximo (em segundos) para a execução das requisições.
     *
     * @return      int
     */
    function getTimeOut() : int;
    /**
     * Define o tempo máximo (em segundos) para a execução das requisições.
     *
     * @param       int $timeOut
     *              Timeout que será definido.
     *
     * @return      void
     */
    function setTimeOut(int $timeOut) : void;



    /**
     * Valor máximo (em Mb) para o upload de um arquivo.
     *
     * @return      int
     */
    function getMaxFileSize() : int;
    /**
     * Define o valor máximo (em Mb) para o upload de um arquivo.
     *
     * @param       int $maxFileSize
     *              Tamanho máximo (em Mb).
     *
     * @return      void
     */
    function setMaxFileSize(int $maxFileSize) : void;



    /**
     * Valor máximo (em Mb) para a postagem de dados.
     *
     * @return      int
     */
    function getMaxPostSize() : int;
    /**
     * Define o valor máximo (em Mb) para a postagem de dados.
     *
     * @param       int $maxPostSize
     *              Tamanho máximo (em Mb).
     *
     * @return      void
     */
    function setMaxPostSize(int $maxPostSize) : void;



    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * @return      string
     */
    function getPathToErrorView() : string;
    /**
     * Resgata o caminho completo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * @return      string
     */
    function getFullPathToErrorView() : string;
    /**
     * Define o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * O caminho deve ser definido a partir do diretório raiz do domínio.
     *
     * @param       string $pathToErrorView
     *              Caminho até a view de erro padrão.
     *
     * @return      void
     */
    function setPathToErrorView(string $pathToErrorView) : void;



    /**
     * Resgata o nome da classe responsável por iniciar a aplicação.
     *
     * @return      string
     */
    function getApplicationClassName() : string;
    /**
     * Define o nome da classe responsável por iniciar a aplicação.
     *
     * @param       string $applicationClassName
     *              Nome da classe.
     *
     * @return      void
     */
    function setApplicationClassName(string $applicationClassName) : void;



    /**
     * Retorna o nome da aplicação que deve responder a requisição ``HTTP`` atual.
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
    function isApplicationNameOmitted() : bool;
    /**
     * Retorna o nome completo da classe da aplicação que deve ser instanciada para responder
     * a requisição atual.
     *
     * @return      string
     */
    function retrieveApplicationNS() : string;



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
    function getSecurityConfig(array $config = []) : ?iSecurity;
    /**
     * Retorna a instância ``Config\iRoute`` a ser usada.
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      ?iRoute
     */
    function getRouteConfig(array $config = []) : ?iRoute;





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
     * Efetua as configurações necessárias para os manipuladores de exceptions e errors
     * para as aplicações do domínio.
     *
     * @return      void
     */
    function setErrorListening() : void;
    /**
     * Inicia uma nova instância ``Config\iServer`` a partir dos dados da requisição atual.
     *
     * @return      iServer
     */
    static function fromContext() : iServer;
}
