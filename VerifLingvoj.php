<?php


class VerifLingvoj extends plxPlugin {
	
	
	public function __construct($default_lang) {
		
		parent::__construct($default_lang);
		
		$this->setAdminProfil(PROFIL_ADMIN, PROFIL_MANAGER);
		$this->setConfigProfil(PROFIL_ADMIN);
		$this->setAdminMenu(
			  "Vérifier les langues"
			, 5
		);
		
	}
	
}

