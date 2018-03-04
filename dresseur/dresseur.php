<?php
require_once('header.php');
?>
<ul>
    <?php

    function affiche_menu($dresseurs)
    {
        foreach($dresseurs as $key => $value) {
            echo'<li>'.$value.'</li>';
        }
    }

    $dresseurs= array('Prénom', 'Nom', 'Adresse', 'email', 'date de licence');
    // Exécute la fonction utilisateur
    affiche_menu($dresseurs);

    ?>
    
</ul>









<?php
    require_once('footer.php');
?>