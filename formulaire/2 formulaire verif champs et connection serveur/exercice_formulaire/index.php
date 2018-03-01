<?php
    require_once('header.php');
?>

<?php
    $id = '';
    $lastname = '';
    $firstname = '';
    $email = '';
    $gender = '';
    $birthdate = '';
    $phone = '';
    $mail_subscribe = 0;
    $phone_subscribe = 0;

    if (isset($_GET['id'])) {
        $db = connexion();
        
        $query = $db->prepare("SELECT * FROM tableformulaire WHERE id = :id");
        $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

        $query->execute();

        if(!$result = $query->fetch())
            die ("L'id " . $_GET['id'] . " n'existe pas");


    }

    // Si le formulaire a été soumis
    if (isset($_POST['form_contact'])) {
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $birthdate = $_POST['birthdate'];
        $phone = $_POST['phone'];
        $mail_subscribe = isset($_POST['mail_subscribe']) ? 1 : 0;
        $phone_subscribe = isset($_POST['phone_subscribe']) ? 1 : 0;

        $form_errors = [];

        // Contrôle des champs
        if (strlen($_POST['lastname']) == 0)
            $form_errors['lastname'] = 'Le nom n\'est pas renseigné';
         if (strlen($_POST['firstname']) == 0)
            $form_errors['firstname'] = 'Le prenom n\'est pas renseigné';
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $form_errors['email'] = 'L\'email n\'est pas valide';
        if (strlen($_POST['phone']) == 0)
            $form_errors['phone'] = 'Le telephone n\'est pas renseigné';
        if (strlen($_POST['gender']) == 0)
            $form_errors['gender'] = 'Le genre n\'est pas renseigné';
            if (strlen($_POST['birthdate']) == 0)
            $form_errors['birthdate'] = 'Le nom n\'est pas renseigné';

        
        if (count($form_errors) == 0) {
            // Connexion à la base
            $connexion = connexion();

            // Préparation de la requête
            if ($id == '')
                $requete = $connexion->prepare('INSERT INTO tableformulaire(lastname, firstname, email, gender, birthdate, phone, mail_subscribe, phone_subscribe) VALUES (:lastname, :firstname, :email, :gender, :birthdate, :phone, :mail_subscribe, :phone_subscribe)');
            else {
                $requete = $connexion->prepare('UPDATE tableformulaire SET lastname = :lastname, firstname = :firstname, email = :email, gender = :gender, birthdate = :birthdate, phone = :phone, mail_subscribe = :mail_subscribe, phone_subscribe = :phone_subscribe WHERE id = :id');
                $requete->bindValue(':id', $id, PDO::PARAM_INT);
            }
            $requete->bindValue(':lastname', htmlspecialchars($_POST['lastname']), PDO::PARAM_STR);
            $requete->bindValue(':firstname', htmlspecialchars($_POST['firstname']), PDO::PARAM_STR);
            $requete->bindValue(':email', htmlspecialchars($_POST['email']), PDO::PARAM_STR);
            $requete->bindValue(':gender', htmlspecialchars($_POST['gender']), PDO::PARAM_STR);
            $requete->bindValue(':birthdate', htmlspecialchars($_POST['birthdate']), PDO::PARAM_STR);
            $requete->bindValue(':phone', htmlspecialchars($_POST['phone']), PDO::PARAM_STR);
            $requete->bindValue(':mail_subscribe', (isset($_POST['mail_subscribe']) ? 1 : 0), PDO::PARAM_INT);
            $requete->bindValue(':phone_subscribe', (isset($_POST['phone_subscribe']) ? 1 : 0), PDO::PARAM_INT);

            // Exécution de la requête
            $requete->execute();

            // Vérification
            error_log($requete->rowCount() . " ligne insérée");

            
        }
    }
?>

    <section class="bg-blue">
        <div class="container">
            <h2>Mon formulaire</h2>
            <div class="row">
                <div class="col-lg-8 offset-2">
                    <form method="post">
                        <input name="form_contact" type="hidden" value="1"/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input  id="lastname" name="lastname" type="text" class="form-control <?php echo isset($form_errors['lastname']) ? 'is-invalid' : ''; ?>" placeholder="Nom" value="<?php echo $lastname; ?>">
                                    <?php echo isset($form_errors['lastname']) ? '<p class="invalid-feedback">' . $form_errors['lastname'] . '</p>' : ''; ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="firstname" name="firstname" type="text" class="form-control <?php echo isset($form_errors['firstname']) ? 'is-invalid' : ''; ?>" placeholder="Prénom" value="<?php echo $firstname; ?>">
                                    <?php echo isset($form_errors['firstname']) ? '<p class="invalid-feedback">' . $form_errors['firstname'] . '</p>' : ''; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <input id="email" name="email" type="email" class="form-control <?php echo isset($form_errors['email']) ? 'is-invalid' : ''; ?>" placeholder="Email" value="<?php echo $email; ?>">
                                    <?php echo isset($form_errors['email']) ? '<p class="invalid-feedback">' . $form_errors['email'] . '</p>' : ''; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <select id="gender" name="gender" class="form-control <?php echo isset($form_errors['gender']) ? 'is-invalid' : ''; ?>">
                                        <option value="">Non renseigné</option>
                                        <option value="M" <?php echo $gender == 'M' ? 'selected' : ''; ?>>Masculin</option>
                                        <option value="F" <?php echo $gender == 'F' ? 'selected' : ''; ?>>Féminin</option>
                                    </select>
                                    <?php echo isset($form_errors['gender']) ? '<p class="invalid-feedback">' . $form_errors['gender'] . '</p>' : ''; ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="birthdate" name="birthdate" type="date" class="form-control <?php echo isset($form_errors['birthdate']) ? 'is-invalid' : ''; ?>" placeholder="Date de naissance" value="<?php echo $birthdate; ?>">
                                    <?php echo isset($form_errors['birthdate']) ? '<p class="invalid-feedback">' . $form_errors['birthdate'] . '</p>' : ''; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="phone" name="phone" type="text" class="form-control <?php echo isset($form_errors['phone']) ? 'is-invalid' : ''; ?>" placeholder="Téléphone" value="<?php echo $phone; ?>">
                                    <?php echo isset($form_errors['phone']) ? '<p class="invalid-feedback">' . $form_errors['phone'] . '</p>' : ''; ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="checkbox-inline <?php echo isset($form_errors['mail_subscribe']) ? 'is-invalid' : ''; ?>"><input id="mail_subscribe" name="mail_subscribe" type="checkbox" <?php echo $mail_subscribe == 1 ? 'checked' : ''; ?> value="1"> Contact par email</label>
                                <label class="checkbox-inline <?php echo isset($form_errors['phone_subscribe']) ? 'is-invalid' : ''; ?>"><input id="phone_subscribe" name="phone_subscribe" type="checkbox" <?php echo $phone_subscribe == 1 ? 'checked' : ''; ?>> Contact par téléphone</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-default btn-webforce">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
    require_once('footer.php');
?>