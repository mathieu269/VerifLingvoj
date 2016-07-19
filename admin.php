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
	require "resultats/resultats.php";
	return; // sortie de admin.php
}

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
