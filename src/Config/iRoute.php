<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;










/**
 * Interface usada para representar a configuração de uma determinada rota em execução de uma
 * aplicação.
 *
 * @package     AeonDigital\EnGarde\Interfaces
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iRoute
{





    //
    // Os seguintes itens representam valores que DEVEM estar definidos para
    // que seja possível identificar com precisão a rota que deve ser executada
    // e suas configurações mais essenciais.
    //
    // APENAS PODEM SER DEFINIDOS ANTES DE INICIAR O PROCESSAMENTO DA ROTA EM SI.

    /**
     * Retorna o nome da aplicação que está sendo executada.
     *
     * @return      string
     */
    function getApplication() : string;
    /**
     * Retorna a namespace completa do controller que está respondendo a requisição.
     *
     * @return      string
     */
    function getNamespace() : string;
    /**
     * Retorna o nome do controller que possui a action que deve resolver a rota.
     *
     * @return      string
     */
    function getController() : string;
    /**
     * Retorna o nome da action que resolve a rota.
     *
     * @return      string
     */
    function getAction() : string;
    /**
     * Retorna os métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @return      array
     */
    function getAllowedMethods() : array;
    /**
     * Retorna um array associativo contendo a coleção de mimetypes que esta rota é capaz de
     * devolver como resposta.
     *
     * Esperado array associativo onde as chaves devem ser os valores abreviados (mime) e os
     * valores correspondem ao nome completo do (mimetype).
     *
     * Ex:
     * ```
     *  [ "txt" => "text/plain", "xhtml" => "application/xhtml+xml" ]
     * ```
     *
     * @return      array
     */
    function getAllowedMimeTypes() : array;
    /**
     * Retorna o método ``HTTP`` que está sendo usado para evocar esta rota.
     *
     * @return      string
     */
    function getMethod() : string;
    /**
     * Retorna a rota que está sendo resolvida e seus respectivos aliases.
     * As rotas devem sempre ser definidas de forma relativa à raiz (começando com "/").
     *
     * @return      array
     */
    function getRoutes() : array;
    /**
     * Retorna ``true`` caso aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
     *
     * @return      bool
     */
    function getIsUseXHTML() : bool;
    /**
     * Retorna o nome do método que deve ser executado na classe da Aplicação para resolver a rota.
     * Se não for definido deve retornar ``run`` como valor padrão.
     *
     * @return      string
     */
    function getRunMethodName() : string;
    /**
     * Resgata um array associativo contendo propriedades customizadas para o processamento
     * da rota.
     *
     * @return      array
     */
    function getCustomProperties() : array;










    //
    // Os itens abaixo representam valores que PODEM ser definidos e tem como objetivo
    // aumentar as informações sobre esta a rota aqui representada mas não tem nenhuma
    // obrigatoriedade em ser usados.
    //
    // APENAS PODEM SER DEFINIDOS ANTES DE INICIAR O PROCESSAMENTO DA ROTA EM SI.

    /**
     * Retorna uma descrição sobre a ação executada por esta rota.
     *
     * @return      string
     */
    function getDescription() : string;
    /**
     * Retorna uma descrição técnica para a rota.
     * O formato MarkDown pode ser utilizado.
     *
     * @return      string
     */
    function getDevDescription() : string;
    /**
     * Retorna uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @return      array
     */
    function getRelationedRoutes() : array;










    //
    // A partir daqui estão métodos que representam sub sistema que PODEM ou não serem
    // usados conforme cada rota.
    //
    // APENAS PODEM SER DEFINIDOS ANTES DE INICIAR O PROCESSAMENTO DA ROTA EM SI.


    //
    // SUB-SISTEMA: MIDDLEWARES

    /**
     * Retorna a coleção de nomes de Middlewares que devem ser executados durante o
     * processamento da rota alvo.
     *
     * Cada item do array refere-se a um método existente na classe da aplicação que retorna uma
     * instância do Middleware alvo.
     *
     * @return      array
     */
    function getMiddlewares() : array;



    //
    // SUB-SISTEMA: SEGURANÇA

    /**
     * Retorna ``true`` se a rota deve ser protegida pelo sistema de segurança da aplicação.
     *
     * Uma rota definida como segura DEVE ter o sistema de cache desabilitado.
     *
     * @return      bool
     */
    function getIsSecure() : bool;



    //
    // SUB-SISTEMA: CACHE

    /**
     * Retorna ``true`` se a rota possui um conteúdo cacheável.
     *
     * Apenas retornará ``true`` se, alem de definido assim a propriedade ``cacheTimeout`` for
     * maior que zero, ``isSecure`` for ``false`` e o método que está sendo usado para responder
     * ao ``UA`` for ``HEAD`` ou ``GET``.
     *
     * @return      bool
     */
    function getIsUseCache() : bool;
    /**
     * Retorna o tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * Um valor igual a ``0`` indica que o armazenamento não deve ser feito (tal qual se o sistema
     * de cache estivesse desativado).
     *
     * Não deve existir uma forma de cache infinito.
     *
     * @return      int
     */
    function getCacheTimeout() : int;



    //
    // SUB-SISTEMA: NEGOCIAÇÃO DE CONTEÚDO
    // Não é um sistema em si, mas uma coleção de valores que serão inferidos antes de
    // efetivamente executar a rota.

    /**
     * Retorna o Locale a ser usado para resolver esta rota.
     *
     * @return      string
     */
    function getResponseLocale() : string;
    /**
     * Retorna o Mime (extenção) a ser usado para resolver esta rota.
     *
     * @return      string
     */
    function getResponseMime() : string;
    /**
     * Retorna o MimeType (canônico) a ser usado para resolver esta rota.
     *
     * @return      string
     */
    function getResponseMimeType() : string;
    /**
     * Quando ``true`` indica que o código de retorno deve passar por algum tratamento que
     * facilite a leitura do mesmo por humanos.
     *
     * @return      bool
     */
    function getResponseIsPrettyPrint() : bool;
    /**
     * Retorna ``true`` se o resultado da execução da rota deve ser uma resposta em formato de
     * download.
     *
     * @return      bool
     */
    function getResponseIsDownload() : bool;



    /**
     * Processa a negociação de conteúdo para identificar qual locale deve ser usado para
     * responder a esta rota.
     *
     * Esta ação deve ser executada ANTES do processamento da rota para que tal resultado
     * seja conhecido durante sua execução.
     *
     * Irá preencher o valor que deve ser retornado em ``$this->getResponseLocale()``.
     *
     * @param       ?array $requestLocales
     *              Coleção de Locales que o ``UA`` explicitou preferência.
     *
     * @param       ?array $requestLanguages
     *              Coleção de linguagens em que o ``UA`` explicitou preferência.
     *
     * @param       ?array $applicationLocales
     *              Coleção de locales usados pela Aplicação.
     *
     * @param       ?string $defaultLocale
     *              Locale padrão da Aplicação.
     *
     * @param       ?string $forceLocale
     *              Locale que terá prioridade sobre os demais podendo inclusive ser um que a
     *              aplicação não esteja apta a servir.
     *
     * @return      bool
     *              Retorna ``true`` caso tenha sido possível identificar o locale a ser usado.
     */
    function negotiateLocale(
        ?array $requestLocales,
        ?array $requestLanguages,
        ?array $applicationLocales,
        ?string $defaultLocale,
        ?string $forceLocale
    ) : bool;



    /**
     * Processa a negociação de conteúdo para identificar qual mimetype deve ser usado para
     * responder a esta rota.
     *
     * Esta ação deve ser executada ANTES do processamento da rota para que tal resultado
     * seja conhecido durante sua execução.
     *
     * Irá preencher os valores que devem ser retornados nos métodos ``$this->getResponseMime()``
     * e ``$this->getResponseMimeType()``.
     *
     * @param       ?array $requestMimes
     *              Coleção de mimeTypes que o ``UA`` explicitou preferência.
     *
     * @param       ?string $forceMime
     *              Mime que terá prioridade sobre os demais podendo inclusive ser um que a rota
     *              não esteja apta a utilizar.
     *
     * @return      bool
     *              Retorna ``true`` caso tenha sido possível identificar o mimetype a ser usado.
     */
    function negotiateMimeType(
        ?array $requestMimes,
        ?string $forceMime
    ) : bool;





    //
    // OS ITENS ABAIXO PODEM TER SEUS VALORES ALTERADOS DURANTE A EXECUÇÃO DA ROTA.

    /**
     * Retorna o nome do documento que deve ser devolvido ao efetuar o download da rota.
     * Se nenhum nome for definido de forma explicita, este valor será criado a partir do nome da
     * rota principal.
     *
     * @return      string
     */
    function getResponseDownloadFileName() : string;
    /**
     * Define o nome do documento que deve ser devolvido ao efetuar o download da rota.
     *
     * @param       string $responseDownloadFileName
     *              Nome do arquivo que será enviado ao UA como um download.
     *
     * @return      void
     */
    function setResponseDownloadFileName(string $responseDownloadFileName) : void;



    /**
     * Retorna a coleção de headers a serem enviados na resposta para o ``UA``.
     *
     * @return      array
     */
    function getResponseHeaders() : array;
    /**
     * Define uma coleção de headers a serem enviados na resposta para o ``UA``.
     * As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
     *
     * @param       array $responseHeaders
     *              Array associativo [key => value] contendo a coleção de headers a serem
     *              enviados ao ``UA``.
     *
     * @return      void
     */
    function setResponseHeaders(array $responseHeaders) : void;
    /**
     * Adiciona novos itens na coleção de headers.
     *
     * @param       array $responseHeaders
     *              Array associativo [key => value] contendo a coleção de headers a serem
     *              enviados ao ``UA``.
     *
     * @return      void
     */
    function addResponseHeaders(array $responseHeaders) : void;










    //
    // Os itens a seguir podem ter seus valores pré-definidos na definição principal da rota.
    // Quando não definidos, irão herdar (se possível) as definições existentes na configuração
    // de sua própria aplicação.
    //
    // TODOS OS ITENS ABAIXO PODEM SER REDEFINIDOS EM TEMPO DE EXECUÇÃO DURANTE O PROCESSAMENTO
    // DESTA PRÓPRIA ROTA.

    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * @return      string
     */
    function getMasterPage() : string;
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * @param       string $masterPage
     *              Caminho relativo até a master page.
     *
     * @return      void
     */
    function setMasterPage(string $masterPage) : void;



    /**
     * Retorna o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * @return      string
     */
    function getView() : string;
    /**
     * Define o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * @param       string $view
     *              Caminho relativo até a view.
     *
     * @return      void
     */
    function setView(string $view) : void;



    /**
     * Retorna uma coleção de caminhos até as folhas de estilos que devem ser incorporadas no
     * documento final (caso trate-se de um formato que aceita este tipo de recurso).
     *
     * @return      array
     */
    function getStyleSheets() : array;
    /**
     * Redefine toda coleção de caminhos até as folhas de estilos que devem ser incorporadas no
     * documento final (caso trate-se de um formato que aceita este tipo de recurso.)
     *
     * Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado
     * aos recursos HTML definidos em ``iApplicationConfig->getPathToViewsResources();``.
     *
     * @param       array $styleSheets
     *              Coleção de folhas de estilos.
     *
     * @return      void
     */
    function setStyleSheets(array $styleSheets) : void;
    /**
     * Adiciona novas folhas de estilo na coleção existente.
     *
     * Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->getPathToViewsResources();``.
     *
     * @param       array $styleSheets
     *              Coleção de folhas de estilo a serem adicionadas na lista atual.
     *
     * @return      void
     */
    function addStyleSheets(array $styleSheets) : void;



    /**
     * Retorna uma coleção de caminhos até as scripts que devem ser incorporadas no documento
     * final (caso trate-se de um formato que aceita este tipo de recurso).
     *
     * @return      array
     */
    function getJavaScripts() : array;
    /**
     * Redefine toda coleção de caminhos até as scripts que devem ser incorporadas no documento
     * final (caso trate-se de um formato que aceita este tipo de recurso.)
     *
     * Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * @param       array $javaScripts
     *              Coleção de scripts.
     *
     * @return      void
     */
    function setJavaScripts(array $javaScripts) : void;
    /**
     * Adiciona novos scripts na coleção existente.
     *
     * Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * @param       array $javaScripts
     *              Coleção de scripts a serem adicionadas na lista atual.
     *
     * @return      void
     */
    function addJavaScripts(array $javaScripts) : void;



    /**
     * Retorna a coleção de metadados a serem incorporados nas views ``X/HTML``.
     *
     * @return      array
     */
    function getMetaData() : array;
    /**
     * Redefinr a coleção de metadados a serem incorporados nas views ``X/HTML``.
     * As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
     *
     * @param       array $metaData
     *              Array associativo [key => value] contendo a coleção de itens a serem adicionados
     *              na tag <head> em formato <meta name="key" content="value" />
     *
     * @return      void
     */
    function setMetaData(array $metaData) : void;
    /**
     * Adiciona novos itens na coleção existente.
     *
     * @param       array $metaData
     *              Array associativo [key => value] contendo a coleção de itens a serem adicionados
     *              na tag <head> em formato <meta name="key" content="value" />
     *
     * @return      void
     */
    function addMetaData(array $metaData) : void;



    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     * que será usado para responder a requisição.
     *
     * @return      string
     */
    function getLocaleDictionary() : string;
    /*
     * Define o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do
     * locale que será usado para responder a requisição.
     *
     * @param       string $localeDictionary
     *              Caminho relativo até o arquivo de legendas.
     *
     * @return      void
     */
    function setLocaleDictionary(string $localeDictionary) : void;










    //
    // Métodos de criação e extração dos dados aqui definidos.

    /**
     * Retorna uma instância configurada a partir de um array que contenha
     * as chaves correlacionadas a cada propriedade aqui definida.
     *
     * @param       array $config
     *              Array associativo contendo os valores a serem definidos para a instância.
     *
     * @return      iRoute
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    static function fromArray(array $config) : iRoute;
    /**
     * Retorna uma instância configurada a partir de uma uma string estruturada de forma a
     * receber os valores mínimos a serem usados para as definições de uma rota.
     *
     * @param       string $config
     *              String estruturada.
     *
     * @return      iRoute
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    static function fromString(string $config) : iRoute;
    /**
     * Converte as propriedades definidas neste objeto para um ``array associativo``.
     *
     * @return      array
     */
    function toArray() : array;
}
