<?php
    session_start();
    $connected = isset($_SESSION['connected']) && $_SESSION['connected'];
    require_once('header.php');
?>

<?php
    // Nombre d'éléments affichable par page
    $nb_element = 3;

    // Le numéro de la page que nous souhaitons visualiser, 1 par défaut
    $page = getInt('page', 1);
    // Calcul de l'offset pour la requête SQL
    $offset = ($page - 1) * $nb_element;   // Si on est à la page 1, (1-1)*10 = OFFSET 0, si on est à la page 2, (2-1)*10 = OFFSET 10, etc.

    // Filtre de recherche sur les colonnes nom/prénom/email/téléphone
    $search = getValue('s');
    
    // Conditions du filtre, l'ajout des conditions se fera progressivement selon les paramètres passés
    $conds = [];

    if ($search != '')
        $conds[] = "(firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
    
    // Souscription au mail ?
    $mail_subscribe = getValue('mail_subscribe');
    if ($mail_subscribe == '1')
        $conds[] = 'mail_subscribe = 1';
    // Souscription au téléphone ?
    $phone_subscribe = getValue('phone_subscribe');
    if ($phone_subscribe == '1')
        $conds[] = 'phone_subscribe = 1';

    // Construction de la clause SQL WHERE selon les conditions
    $where = '';
    if (count($conds) > 0)
        $where = 'WHERE ' . implode(' AND ', $conds);

    // Affichage du formulaire de recherche
    echo '
        <form method="GET" action="#">
            <input type="search" placeholder="recherche" name="s" value="' . $search . '">
            <label><input type="checkbox" name="mail_subscribe" value="1" ' . ($mail_subscribe == '1' ? 'checked' : '') . '> Contact par email</label>
            <label><input type="checkbox" name="phone_subscribe" value="1" ' . ($phone_subscribe == '1' ? 'checked' : '') . '> Contact par téléphone</label>
            <input type="submit" value="Rechercher">
        </form>';
    
    // Ouverture de la connexion BDD (base de donnée)
    $db = connexion();

    $query = $db->query("SELECT COUNT(*) AS nb FROM tableformulaire $where");
    $nb_elements = $query->fetch()['nb'];
    if ($nb_elements == 0)
        die ("Aucune donnée à afficher");
    $max_page = ceil($nb_elements / $nb_element);

    $query_string = "
        SELECT id,
               firstname as Prénom, 
               lastname as Nom,
               email as Email,
               gender as genre,
               DATE_FORMAT(birthdate, '%d/%m/%Y') as \"Date de naissance\",
               phone as Téléphone,
               mail_subscribe as \"Contact par email\",
               phone_subscribe as \"Contact par téléphone\"
        FROM tableformulaire
        $where
        LIMIT $nb_element OFFSET $offset
    ";

    $query = $db->query($query_string);

    $results = $query->fetchAll();

    $tableau = table_html($results, $connected, 'index.php');

    echo $tableau;

    if ($page > 1 ) // Seulement si on est sur la page 2 ou plus, afficher un bouton "Précédent"
    {
        echo '<a href="?' . getImplode('page', $page - 1) . '">Précédent </a>';
    }
    if ($page < $max_page) // Seulement si on est pas sur la dernière page, afficher un bouton "Suivant"
    {
        echo '<a href="?' . getImplode('page', $page + 1) . '">Suivant</a>';
    }
    
?>

<?php
    require_once('footer.php');
?>