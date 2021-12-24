#
# Aeon Digital
# Rianna Cantarelli <rianna@aeondigital.com.br>
#
.SILENT:




#
# Mostra log resumido do git
# Use o parametro 'len' para indicar a quantidade de itens a serem mostrados.
git-log:
	make/makeActions.sh gitShowLog "${MAKECMDGOALS}"





#
# Mostra qual a tag atual do projeto.
tag:
	git describe --abbrev=0 --tags

#
# Redefine a tag atualmente vigente para o commit mais recente
tag-remark:
	make/makeActions.sh gitTagManagement "remark"

#
# Atualiza o 'patch' da tag atualmente definida
# para a branch principal 'main'.
tag-update:
	make/makeActions.sh gitTagManagement "version" "patch"

#
# Atualiza o 'minor version'  da tag atualmente definida
# para a branch principal 'main'.
tag-update-minor:
	make/makeActions.sh gitTagManagement "version" "minor"

#
# Atualiza o 'major version'  da tag atualmente definida
# para a branch principal 'main'.
tag-update-major:
	make/makeActions.sh gitTagManagement "version" "major"

#
# Atualiza a 'stability' da tag atualmente definida
# para a branch principal 'main'.
#
# Use o parametro 'stability' para indicar qual será a nova 'stability'.
# use apenas um dos seguintes valores: 'alpha'; 'beta'; 'cr'; 'r'
tag-stability:
	make/makeActions.sh gitTagManagement "stability" "${stability}"
