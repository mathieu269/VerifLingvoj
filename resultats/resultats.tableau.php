
<style type="text/css">
	
	.manquant
	{
		background-color : #F99;
	}
	
	th.incomplets
	{
		background-color : #FCC;
	}
	th.complets
	{
		background-color : #CFC;
	}
	
	
	  aside
	, .inline-form.action-bar
	, section .alert.red
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



<?php if (0 === $total) {?>
	<strong>aucun élément</strong>
<?php }?>



<table id="tableauResultats">
	
	<thead>
		<?php require "titres.tableau.php";?>
	</thead>
	
	
	<tbody>
	
	<?php foreach ($resultats as $t => $tab) {?>
		
		<?php
			if (0 === count($tab)) {
				continue;
			}
			
			ksort($tab);
			
		?>
		
		
		<tr>
			<th class="<?php echo htmlspecialchars($t);?>"
				 colspan="<?php echo $nombreFichiers + 2;?>"
			>
				<?php echo htmlspecialchars($t);?>
			</th>
		</tr>
		

		<?php foreach (array_keys($tab) as $code) {?>
			
			<tr>
				
				<th class="<?php echo htmlspecialchars($t);?>">
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
				
			</tr>
			
		<?php }?>
			
			
	<?php }?>
	
	</tbody>
	
</table>
