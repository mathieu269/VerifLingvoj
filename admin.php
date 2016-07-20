<?php


$choix = [
	"coeur" => [
		"libelle" => "cœur",
		"liste" => [],
	],
	"extensions" => [
		"repertoire" => PLX_PLUGINS,
		"libelle" => "extensions",
		"liste" => [],
	],
	"themes" => [
		"repertoire" => PLX_ROOT . $plxAdmin->aConf["racine_themes"],
		"libelle" => "thèmes",
		"liste" => [],
	],
];


// cœur

$repCoeur = PLX_CORE . "lang/fr";
$dh = opendir($repCoeur);

while (FALSE !== ($filename = readdir($dh))) {
	if (in_array($filename, [".", ".."])) {
		continue;
	}
	
	$choix["coeur"]["liste"][$filename] = PLX_CORE . "lang/%s/$filename";
}


// extensions et thèmes

foreach (["extensions", "themes"] as $type) {
	
	$repertoire = $choix[$type]["repertoire"];
	$dh = opendir($repertoire);
	
	while (FALSE !== ($filename = readdir($dh))) {
		if (	in_array($filename, [".", ".."])
			||	!is_dir($repertoire . $filename)
		) {
			continue;
		}
		
		$choix[$type]["liste"][$filename] = $repertoire . "$filename/lang/%s.php";
	}
	
}

if (isset($_GET["type"])) {
	
	
	
	$langues = plxUtils::getLangs();
	
	$infos = $choix[$_GET["type"]]["liste"][$_GET["element"]];
	
	
	if (isset($_GET["langue"])) {
		$languesFiltre = ["fr", $_GET["langue"]];
	} else {
		$languesFiltre = $langues;
	}
	
	
	// recherche des fichiers de langues existants
	
	$languesPresentes = [];
	$listeFichiers = [];
	
	foreach ($langues as $codeLangue) {
		
		$fichier = sprintf($infos, $codeLangue);
		
		if (is_file($fichier)) {
			$languesPresentes[] = $codeLangue;
			
			if (in_array($codeLangue, $languesFiltre)) {
				$listeFichiers[$codeLangue] = $fichier;
			}
		}
		
	}
	
	$nombreFichiers = count($listeFichiers);
	
	ksort($listeFichiers);
	
	$languesPresentes = array_unique($languesPresentes);
	
	
	// parcours des fichiers
	
	$resultats = [
		"incomplets" => [],
		"complets" => [],
	];
	
	
	foreach ($listeFichiers as $codeLangue => $f) {
		
		include $f;
		
		foreach($LANG as $code => $valeur) {
			
			
			if (!isset($resultats["incomplets"][$code])) {
				$resultats["incomplets"][$code] = [];
			}
			
			$resultats["incomplets"][$code][$codeLangue] = $valeur;
			
			
			if (count($resultats["incomplets"][$code]) === $nombreFichiers) {
				$resultats["complets"][$code] = $resultats["incomplets"][$code];
				unset($resultats["incomplets"][$code]);
			}
			
		}
		
		
	}
	
	$total = array_reduce($resultats, function ($total, $tab) {
		$total += count($tab);
		return $total;
	}, 0);
	
	
	$plxAdmin = plxAdmin::getInstance();
	
	
	require "resultats/resultats.liste.php";
	//require "resultats/resultats.tableau.php";
	
	
	return; // sortie de admin.php
	
} // FIN if (isset($_GET["type"])) {



?>

<ul>
	
	<?php foreach ($choix as $codeT => $t) {?>
		
		<li>
			
			<h2>
				<?php echo htmlspecialchars($t["libelle"]);?>
			</h2>
			
			<ul>
				
				<?php foreach (array_keys($t["liste"]) as $codeE) {?>
					
					<?php
						$lien = implode("&", [
							"p={$_GET["p"]}",
							"type=$codeT",
							"element=$codeE",
						]);
					?>
					
					<li>
						<a href="?<?php echo htmlspecialchars($lien);?>">
							<?php echo htmlspecialchars($codeE);?></a>
					</li>
					
				<?php }?>
				
			</ul>
		</li>
		
	<?php }?>
	
</ul>
