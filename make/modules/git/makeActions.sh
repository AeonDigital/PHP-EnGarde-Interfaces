#!/bin/bash -eu

#
# Carrega dependencias
source "${PWD}/make/modules/makeEnvironment.sh"
source "${MK_ROOT_PATH}/make/modules/makeTools.sh"
source "${MK_ROOT_PATH}/make/mseStandAlone/loadScripts.sh";

#
# Se quiser,
# defina um arquivo em 'make/makeEnvironment.sh' e use-o para
# suas configurações personalizadas.
if [ -f "${MK_MY_ENVIRONMENT_FILE}" ]; then
  source "${MK_MY_ENVIRONMENT_FILE}"
fi;










#
# Mostra log resumido do git
# Use o parametro 'len' para indicar a quantidade de itens a serem mostrados.
gitShowLog() {
  if [ -z ${len+x} ]; then
    len="${GIT_LOG_LENGTH}";
  fi;

  tmpLogData=$(git log -${len} --pretty='format:%ad | %s' --reverse --date=format:'%d %B | %H:%M');
  column -e -t -s "|" <<< "${tmpLogData}"
}




#
# Configura o repositório para armazenar localmente as credenciais do git.
gitConfigLocal() {

  if [ ! -d .git ]; then
    setIMessage "" 1;
    setIMessage "O diretório atual não é um repositório Git";
    setIMessage "Ação abortada";
    alertUser;
  else
    setIMessage "" 1;
    setIMessage "Iniciando configuração ${PURPLE}local${NONE} para este repositório.";
    setIMessage "As configurações locais atualmente definidas serão perdidas.";
    setIMessage "Você confirma esta ação?";
    promptUser;

    if [ "$MSE_GB_PROMPT_RESULT" == "1" ]; then
      mkdir -p ~/.gitcredentials
      chmod 700 ~/.gitcredentials


      if [ ! -d ~/.gitcredentials ]; then
        setIMessage "" 1;
        setIMessage "Não foi possível criar o diretório ${PURPLE}~/.gitcredentials${NONE}.";
        setIMessage "Ação abortada";
        alertUser;
      else
          local tmpISOK="1";
          local tmpRepo="${PWD##*/}";
          local tmpEmail=$(git config --global --get user.email);
          local tmpName=$(git config --global --get user.name);

          setIMessage "" 1;
          setIMessage "Você deseja usar as configurações padrões?";
          setIMessage "Repositório: ${PURPLE}${tmpRepo}${NONE}";
          setIMessage "Email      : ${PURPLE}${tmpEmail}${NONE}";
          setIMessage "Nome       : ${PURPLE}${tmpName}${NONE}";
          setIMessage "";
          setIMessage "Se escolher 'não' você poderá definir cada um dos itens acima.";
          promptUser;

          if [ "$MSE_GB_PROMPT_RESULT" == "0" ]; then
            if [ "${tmpISOK}" == "1" ]; then
              setIMessage "" 1;
              setIMessage "Informe o nome do ${PURPLE}repositório${NONE}.";
              promptUser "value";

              if [ "$MSE_GB_PROMPT_RESULT" == "" ]; then
                tmpISOK="0";

                setIMessage "" 1;
                setIMessage "Este valor não pode ficar vazio.";
                setIMessage "Ação abortada";
                alertUser;
              else
                tmpRepo="$MSE_GB_PROMPT_RESULT";
              fi;
            fi;


            if [ "${tmpISOK}" == "1" ]; then
              setIMessage "" 1;
              setIMessage "Informe o ${PURPLE}email${NONE}.";
              setIMessage "${PURPLE}git config --local user.email ??${NONE}";
              promptUser "value";

              if [ "$MSE_GB_PROMPT_RESULT" == "" ]; then
                tmpISOK="0";

                setIMessage "" 1;
                setIMessage "Este valor não pode ficar vazio.";
                setIMessage "Ação abortada";
                alertUser;
              else
                tmpEmail="$MSE_GB_PROMPT_RESULT";
              fi;
            fi;


            if [ "${tmpISOK}" == "1" ]; then
              setIMessage "" 1;
              setIMessage "Informe o ${PURPLE}nome${NONE}.";
              setIMessage "${PURPLE}git config --local user.name ??${NONE}";
              promptUser "value";

              if [ "$MSE_GB_PROMPT_RESULT" == "" ]; then
                tmpISOK="0";

                setIMessage "" 1;
                setIMessage "Este valor não pode ficar vazio.";
                setIMessage "Ação abortada";
                alertUser;
              else
                tmpName="$MSE_GB_PROMPT_RESULT";
              fi;
            fi;
          fi;


          if [ "${tmpISOK}" == "1" ]; then
            git config --local user.email "${tmpEmail}"
            git config --local user.name "${tmpName}"
            git config --local credential.helper "store --file ~/.gitcredentials/${tmpRepo}"

            rm -f "~/.gitcredentials/${tmpRepo}";

            setIMessage "" 1;
            setIMessage "Configurações executadas.";
            setIMessage "Suas credenciais serão pedidas no próximo pull/push e após serão lidas";
            setIMessage "do arquivo de configuração armazenado em ~/.gitcredentials/${tmpRepo}";
            alertUser;
          fi;
      fi;

    fi;

  fi;
}





#
# Gerencia as ações de controle de tags do git para o projeto.
gitTagManagement() {
  GIT_ACTIVE_BRANCH=$(git branch --show-current);



  #
  # Identifica se a branch atual refere-se ao 'main'
  if [ "${GIT_ACTIVE_BRANCH}" != "main" ]; then
    setIMessage "" 1;
    setIMessage "Alterne para a branch principal ${PURPLE}main${NONE}.";
    setIMessage ":: git checkout main";
    alertUser;
  else
    #
    # Identifica se existem alterações não comitadas
    if [ $(git status --porcelain | wc -l) -gt "0" ] && [ 1 == 2 ]; then
      setIMessage "" 1;
      setIMessage "Foram encontradas alterações não comitadas.";
      setIMessage "Efetue o commit das alterações para prosseguir.";
      setIMessage ":: git add .";
      setIMessage ":: git commit -m \"message\"";
      setIMessage ":: git push origin main";
      alertUser;
    else

      GIT_ATUAL_TAG="0.0.0-alpha";
      if [ "$(git tag)" != "" ]; then
        GIT_ATUAL_TAG=$(git describe --abbrev=0 --tags);
      fi

      TAG_SPLIT=(${GIT_ATUAL_TAG//-/ });
      TAG_RAW_VERSION=(${TAG_SPLIT[0]//[!0-9.]/ });


      VERSION_SPLIT=(${TAG_RAW_VERSION//\./ });

      PROJECT_VERSION_MAJOR=${VERSION_SPLIT[0]};
      PROJECT_VERSION_MINOR=${VERSION_SPLIT[1]};
      PROJECT_VERSION_PATCH=${VERSION_SPLIT[2]};
      PROJECT_VERSION_STABILITY=("-"${TAG_SPLIT[1]});

      PROJECT_ATUAL_VERSION="${PROJECT_VERSION_MAJOR}.${PROJECT_VERSION_MINOR}.${PROJECT_VERSION_PATCH}";

      ISOK=1;

      if [ "$1" == "remark" ]; then
        git tag -d "${GIT_ATUAL_TAG}";
        git push --delete origin "${GIT_ATUAL_TAG}";
        git tag "${GIT_ATUAL_TAG}";
        git push --tags origin;
      else
        if [ "$1" == "version" ]; then
          if [ "$2" == "patch" ]; then
            PROJECT_VERSION_PATCH=$((PROJECT_VERSION_PATCH+1));
          else
            if [ "$2" == "minor" ]; then
              PROJECT_VERSION_MINOR=$((PROJECT_VERSION_MINOR+1));
              PROJECT_VERSION_PATCH=0;
            else
              if [ "$2" == "major" ]; then
                PROJECT_VERSION_MAJOR=$((PROJECT_VERSION_MAJOR+1));
                PROJECT_VERSION_MINOR=0;
                PROJECT_VERSION_PATCH=0;
              else
                ISOK=0;
              fi
            fi
          fi
        elif [ "$1" == "stability" ]; then
          if [ "$2" == "alpha" ] || [ "$2" == "beta" ] || [ "$2" == "cr" ] || [ "$2" == "r" ]; then
            if [ "$2" == "r" ]; then
              PROJECT_VERSION_STABILITY="";
            else
              PROJECT_VERSION_STABILITY="-$2";
            fi
          else
            ISOK=0;
          fi
        else
          ISOK=0;
        fi



        if [ "${ISOK}" == "0" ]; then
          setIMessage "" 1;
          setIMessage "Parametros incorretos: [ ${1}; ${2} ].";
          setIMessage "Nenhuma ação foi realizada.";
          alertUser;
        else
          USE_VERSION="${PROJECT_VERSION_MAJOR}.${PROJECT_VERSION_MINOR}.${PROJECT_VERSION_PATCH}";
          NEW_VERSION="v${USE_VERSION}${PROJECT_VERSION_STABILITY}";

          #
          # Verifica se é necessário atualizar o versionamento da documentação exportada
          CONF="docs/conf.py";
          if [ -f "${CONF}" ]; then
            OLD_SHORT_VERSION="project_short_version = '.*'";
            NEW_SHORT_VERSION="project_short_version = '${USE_VERSION}'";
            sed -i "s/${OLD_SHORT_VERSION}/${NEW_SHORT_VERSION}/" "${CONF}";

            OLD_FULL_VERSION="project_full_version = '.*'";
            NEW_FULL_VERSION="project_full_version = '${NEW_VERSION}'";
            sed -i "s/${OLD_FULL_VERSION}/${NEW_FULL_VERSION}/" "${CONF}";

            if [ $(git status --porcelain | wc -l) -gt "0" ]; then
              git add .;
              git commit -m "Atualizado para a versão ${NEW_VERSION}";
              git push origin main;
            fi
          fi

          git tag ${NEW_VERSION};
          git push --tags origin;
        fi
      fi;
    fi;
  fi;
}









#
# Permite evocar uma função deste script a partir de um argumento passado ao chamá-lo.
$*
