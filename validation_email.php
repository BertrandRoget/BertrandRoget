<?php
require_once('header.php');
?>
<?php
     $id = '';
     $email = '';
     $password = '';
     $repeat_password = '';

         if (isset($_GET['id'])) {
        $db = connexion();
        
        $query = $db->prepare("SELECT * FROM utilisateur WHERE id = :id");
        $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

        $query->execute();

        if(!$result = $query->fetch())
            die ("L'id " . $_GET['id'] . " n'existe pas");

        $id = $result['id'];
        $email = $result['email'];
        $gender = $result['password'];
        $birthdate = $result['repeat_password'];

    }

         // Si le formulaire a été soumis
    if (isset($_POST['form_contact'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];


        $form_errors = [];

        // Contrôle des champs
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $form_errors['email'] = 'Veuillez saisir l\'email';
        if (strlen($_POST['password']) == '')
            $form_errors['password'] = 'Veuillez saisir un mot de passe';
        if (strlen($_POST['repeat_password']) == '')
            $form_errors['repeat_password'] = 'Veuillez confirmer le mot de passe';

        
        if (count($form_errors) == 0) {
            // Connexion à la base
            $connexion = connexion();

            // Préparation de la requête
            if ($id == '')
                $requete = $connexion->prepare('INSERT INTO utilisateur(email, password, repeat_password) VALUES (:email, :password, :repeat_password)');
            else {
                $requete = $connexion->prepare('UPDATE utilisateur SET email = :email, password = :password, repeat_password = :repeat_password WHERE id = :id');
                $requete->bindValue(':id', $id, PDO::PARAM_INT);
            }

            $requete->bindValue(':email', htmlspecialchars($_POST['email']), PDO::PARAM_STR);
            $requete->bindValue(':password', htmlspecialchars($_POST['password']), PDO::PARAM_STR);
            $requete->bindValue(':repeat_password', htmlspecialchars($_POST['repeat_password']), PDO::PARAM_STR);


            // Exécution de la requête
            $requete->execute();

            // Vérification
            error_log($requete->rowCount() . " ligne insérée");

            // Redirection vers view.php
           // redirect('view.php');
        }
    }



?>




<body>

<form  name="form_contact" action="" method="post" class="form" style="border:1px solid #ccc">
<input type="hidden" name="forgot_form" value="1"/>
  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input class = "<?php echo isset($form_errors['email']) ? 'is-invalid' : '' ?>" type="text" placeholder="Enter Email" name="email" required>
              <?php echo isset($form_errors['email']) ? '<div class="invalid-feedback">' . $form_errors['email'] . '</div>' : '' ?>

    <label for="psw"><b>Password</b></label>
    <input  class = "<?php echo isset($form_errors['password']) ? 'is-invalid' : '' ?>" type="password" placeholder="Enter Password" name="password" required>
                <?php echo isset($form_errors['password']) ? '<div class="invalid-feedback">' . $form_errors['password'] . '</div>' : '' ?>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input   class = "<?php echo isset($form_errors['repeat_password']) ? 'is-invalid' : '' ?>" type="password" placeholder="Repeat Password" name="repeat_password" required>
                <?php echo isset($form_errors['repeat_password']) ? '<div class="invalid-feedback">' . $form_errors['repeat_password'] . '</div>' : '' ?>

    <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>
    
 
    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>

</body>


<?php
require_once('footer.php');
?>