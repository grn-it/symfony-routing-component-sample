install:
	setfacl -dR -m u:$(uid):rwX .
	setfacl -R -m u:$(uid):rwX .
