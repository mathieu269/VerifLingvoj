

<tr>
	
	<th>
		<h2>
			<?php echo htmlspecialchars($choix[$_GET["type"]]["libelle"]);?>
			/ <?php echo htmlspecialchars($_GET["element"]);?>
		</h2>
	</th>
	
	<?php foreach (array_keys($listeFichiers) as $codeLangue) {?>
		
		<th>
			<?php echo htmlspecialchars($codeLangue);?>
		</th>
		
	<?php }?>
	
	<th></th>
	
</tr>
