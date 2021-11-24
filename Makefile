#
# Aeon Digital
# Rianna Cantarelli <rianna@aeondigital.com.br>
#
.SILENT:





#
# Mostra log resumido do git
# Use o parametro 'len' para indicar a quantidade de itens a serem mostrados.
#
# O workaround abaixo se deve ao fato que o operador <<< não funciona em condições
# normais do 'Makefile' mesmo quando é setado SHELL=/bin/bash.
# O comando abaixo deveria ser apenas 1 linha como a seguinte:
# column -e -t -s "|" <<< $(git log -3 --pretty='format:%ad | %s' --reverse --date=format:'%d %B | %H:%M')
#
LOG_LENGTH=10
git-log:
	if [ -z "${len}" ]; then \
		git log -${LOG_LENGTH} --pretty='format:%ad | %s' --reverse --date=format:'%d %B | %H:%M' > .tmplogdata; \
	else \
		git log -${len} --pretty='format:%ad | %s' --reverse --date=format:'%d %B | %H:%M' > .tmplogdata; \
	fi;
	# Sem esta linha extra o comando 'column' apresenta um erro de 'line too long'
	echo "" >> .tmplogdata
	column .tmplogdata -e -t -s "|"
	rm .tmplogdata
	





#
# Mostra qual a tag atual do projeto.
tag:
	git describe --abbrev=0 --tags

#
# Redefine a tag atualmente vigente para o commit mais recente
tag-remark:
	./tag-update.sh "remark"

#
# Atualiza o 'patch' da tag atualmente definida 
# para a branch principal 'main'.
tag-update:
	./tag-update.sh "version" "patch"

#
# Atualiza o 'minor version'  da tag atualmente definida 
# para a branch principal 'main'.
tag-update-minor:
	./tag-update.sh "version" "minor"

#
# Atualiza o 'major version'  da tag atualmente definida 
# para a branch principal 'main'.
tag-update-major:
	./tag-update.sh "version" "major"

#
# Atualiza a 'stability' da tag atualmente definida 
# para a branch principal 'main'.
#
# Use o parametro 'stability' para indicar qual será a nova 'stability'.
# use apenas um dos seguintes valores: 'alpha'; 'beta'; 'cr'; 'r'
tag-stability:
	./tag-update.sh "stability" "${stability}"
