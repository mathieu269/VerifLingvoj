
<style type="text/css">
	
	.manquant span
	{
		background-color : #F99;
		color : white;
	}
	
	.incomplets
	{
		background-color : #FCC;
	}
	.complets
	{
		background-color : #CFC;
	}
	
</style>



<h2>
	
	<?php echo htmlspecialchars($choix[$_GET["type"]]["libelle"]);?>
	/ <?php echo htmlspecialchars($_GET["element"]);?>
	
	<?php foreach ($languesPresentes as $codeLangue) {?>
		
		<?php
			
			if ("fr" === $codeLangue) {
				continue;
			}
			
			$lien = implode("&", [
				"p={$_GET["p"]}",
				"type={$_GET["type"]}",
				"element={$_GET["element"]}",
				"langue=$codeLangue",
			]);
		?>
		
		<a href="?<?php echo htmlspecialchars($lien);?>">
			<?php echo htmlspecialchars($codeLangue);?></a>
		
	<?php }?>
	
	<?php
		$lien = implode("&", [
			"p={$_GET["p"]}",
			"type={$_GET["type"]}",
			"element={$_GET["element"]}",
		]);
	?>
	
	<a href="?<?php echo htmlspecialchars($lien);?>">
		<em>toutes les langues</em></a>
	
</h2>

<?php if (0 === $total) {?>
	<strong>aucun élément de langue</strong>
<?php }?>


<?php foreach ($resultats as $t => $tab) {?>
	
	<?php
		if (0 === count($tab)) {
			continue;
		}
		
		ksort($tab);
		
	?>
	
	
	<h3 class="<?php echo htmlspecialchars($t);?>">
		<?php echo htmlspecialchars($t);?>
	</h3>
	
	<ul>
		
		<?php foreach (array_keys($tab) as $code) {?>
			
			<li>
			
			<span class="<?php echo htmlspecialchars($t);?>">
				<?php echo htmlspecialchars($code);?>
			</span>
			
			<ul>
				
				<?php foreach (array_keys($listeFichiers) as $codeLangue) {?>
					
					<?php if (!isset($tab[$code][$codeLangue])) {?>
						
						<li class="manquant">
							<span>
								<?php echo htmlspecialchars($codeLangue);?>&nbsp;: manquant
							</span>
						</li>
						
					<?php } else {?>
						
						<li>
							<?php echo htmlspecialchars($codeLangue);?>&nbsp;:
							<?php echo htmlspecialchars($tab[$code][$codeLangue]);?>
						</li>
						
					<?php }?>
					
				<?php }?>
				
			</ul>
			
		<?php }?>
		
	</ul>
	
<?php }?>

