<?php

$langues = plxUtils::getLangs();

$infos = $choix[$_GET["type"]]["liste"][$_GET["element"]];


// recherche des fichiers de langues existants

$listeFichiers = [];

foreach ($langues as $codeLangue) {
	
	$fichier = sprintf($infos, $codeLangue);
	
	if (is_file($fichier)) {
		$listeFichiers[$codeLangue] = $fichier;
	}
	
}

$nombreFichiers = count($listeFichiers);

ksort($listeFichiers);


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

?>

<style type="text/css">
	
	.manquant
	{
		background-color : #F99;
	}
	
	
	  aside
	, .inline-form.action-bar
	{
		display : none;
	}
	
	section
	{
		margin : 0 !important;
		width : 100% !important;
	}
	
	.grid {
		overflow : initial;
	}
	
</style>

<h1>
	<?php echo htmlspecialchars($choix[$_GET["type"]]["libelle"]);?>
	/ <?php echo htmlspecialchars($_GET["element"]);?>
</h1>


<?php if (0 === $total) {?>
	<strong>aucun élément</strong>
<?php }?>


<?php foreach ($resultats as $t => $tab) {?>
	
	<?php
		if (0 === count($tab)) {
			continue;
		}
		
		ksort($tab);
		
	?>
	
	
	<h2>
		<?php echo htmlspecialchars($t);?>
	</h2>
	
	<table>
		
		
		<?php require "titres.php";?>
		
		
		<?php foreach (array_keys($tab) as $code) {?>
			
			<tr>
				
				<th>
					<?php echo htmlspecialchars($code);?>
				</th>
				
				<?php foreach (array_keys($listeFichiers) as $codeLangue) {?>
					
					<?php if (!isset($tab[$code][$codeLangue])) {?>
						
						<td class="manquant"></td>
						
					<?php } else {?>
						
						<td>
							<?php echo htmlspecialchars($tab[$code][$codeLangue]);?>
						</td>
						
					<?php }?>
					
				<?php }?>
				
				<th>
					<?php echo htmlspecialchars($code);?>
				</th>
				
			</tr>
			
		<?php }?>
		
		
		<?php require "titres.php";?>
		
		
	</table>
	
<?php }?>

