<p class="rubrique">Créer une nouvelle rubrique</p>
<form method="post" action="index.php?uc=creer&quoi=valider&post=0&num=<?php echo $num; ?>">
   <p>
       <label for="nomRubrique">
       Nom de la nouvelle rubrique :
       </label>
       <input type="text" name="nomRubrique" id="nomRubrique" value="rubrique n° <?php echo $prochaine; ?>" required/>
       <input type="submit" value="Envoyer" />      
   </p>
</form>