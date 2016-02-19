<p class="rubrique">Créer un nouvel article</p>
<form method="post" action="index.php?uc=creer&quoi=valider&post=1&num=<?php echo $num; ?>">
   <p>
       <label for="nomPost">
       Titre du nouveau article :
       </label>
       <input type="text" name="nomPost" id="nomPost" value="article n° <?php echo $prochaine; ?>" required/>
       <br />
       <label for="lePost">
       Votre article :
       </label><br />
       <textarea name="lePost" id="lePost" rows="10" cols="80" >Ce mini forum est vraiment génial !!!</textarea>
       <input type="submit" value="Envoyer" />      
   </p>
</form>

