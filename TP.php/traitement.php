<?php
$sexes_autorises = ['H', 'F'];
$animaux_autorises = ['chien', 'chat', 'oiseau', 'poisson', 'dragon', 'hamster', 'poule', 'torue', 'serpent', 'hamster','vache', 'aucun', ''];
$loisirs_autorises = ['sport', 'lecture', 'jeux'];

$profils_php = [
    ['nom' => 'Alice', 'ville' => 'Paris', 'animaux' => 'chat'],
    ['nom' => 'Bob', 'ville' => 'Lyon', 'animaux' => 'chien'],
    ['nom' => 'Charlie', 'ville' => 'Paris', 'animaux' => 'aucun'],
    ['nom' => 'Diana', 'ville' => 'Marseille', 'animaux' => 'chat'],
    ['nom' => 'Eve', 'ville' => 'Lyon', 'animaux' => 'poisson'],
];

$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Error contexte');
    echo 'Erreur : Ce script n\'accepte que les requêtes POST.';
    exit;
}

$data['nom'] = htmlspecialchars(trim($_POST['nom'] ?? ''));
$data['email'] = htmlspecialchars(trim($_POST['email'] ?? ''));
$data['password'] = $_POST['password'] ?? '';
$data['sexe'] = htmlspecialchars(trim($_POST['sexe'] ?? ''));
$data['ville'] = htmlspecialchars(trim($_POST['ville'] ?? ''));
$data['animaux'] = htmlspecialchars(trim($_POST['agit initnimaux'] ?? ''));

$data['loisirs'] = [];
if (!empty($_POST['loisirs']) && is_array($_POST['loisirs'])) {
    foreach ($_POST['loisirs'] as $loisir) {
        if (in_array($loisir, $loisirs_autorises)) {
             $data['loisirs'][] = htmlspecialchars(trim($loisir));
        }
    }
}

if (empty($data['nom'])) {
    $errors['nom'] = 'Le nom est requis.';
} elseif (strlen($data['nom']) < 2 || strlen($data['nom']) > 50) {
    $errors['nom'] = 'Le nom doit contenir entre 2 et 50 caractères.';
}

if (empty($data['email'])) {
    $errors['email'] = 'L\'email est requis.';
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Le format de l\'email est invalide.';
}

if (empty($data['password'])) {
    $errors['password'] = 'Le mot de passe est requis.';
} elseif (strlen($data['password']) < 8) {
    $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
}

if (empty($data['sexe'])) {
    $errors['sexe'] = 'Veuillez sélectionner votre sexe.';
} elseif (!in_array($data['sexe'], $sexes_autorises)) {
    $errors['sexe'] = 'La valeur sélectionnée est invalide.';
}

if (empty($data['ville'])) {
    $errors['ville'] = 'La ville est requise.';
}

if (!in_array($data['animaux'], $animaux_autorises)) {
    $errors['animaux'] = 'L\'animal sélectionné est invalide.';
}

if (empty($errors)) {
    $search_ville = strtolower($data['ville']);
    $search_animal = $data['animaux'];
    
    $search_results = array_filter($profils_php, function($profil) use ($data, $search_ville, $search_animal) {
        if (strtolower($profil['nom']) === strtolower($data['nom'])) {
            return false;
        }
        if (strtolower($profil['ville']) === $search_ville) {
            return true;
        }
        if (!empty($search_animal) && $profil['animaux'] === $search_animal) {
            return true;
        }
        return false;
    });

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Réussie</title>
    <style>
        body { font-family: sans-serif; margin: 2em; max-width: 600px; }
        div { margin-bottom: 15px; }
        ul { list-style-type: none; padding-left: 0; }
        li { border-bottom: 1px solid #eee; padding: 8px 0; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; }
        .success { background-color: #e6ffed; border: 1px solid #b7ebc9; padding: 15px; }
        .results { background-color: #f4f4f4; border: 1px solid #ddd; padding: 15px; }
    </style>
</head>
<body>
    <div class="success">
        <h2>Merci, <?php echo $data['nom']; ?> ! Inscription réussie.</h2>
    </div>

    <h2>Récapitulatif de vos informations</h2>
    <ul>
        <li><strong>Nom :</strong> <?php echo $data['nom']; ?></li>
        <li><strong>Email :</strong> <?php echo $data['email']; ?></li>
        <li><strong>Sexe :</strong> <?php echo ($data['sexe'] == 'H' ? 'Homme' : 'Femme'); ?></li>
        <li><strong>Ville :</strong> <?php echo $data['ville']; ?></li>
        <li><strong>Animal :</strong> <?php echo ($data['animaux'] ?: 'Non spécifié'); ?></li>
        <li><strong>Loisirs :</strong> 
            <?php 
            if (!empty($data['loisirs'])) {
                echo implode(', ', $data['loisirs']);
            } else {
                echo 'Aucun';
            }
            ?>
        </li>
    </ul>

    <hr>

    <div class="results">
        <h2>Résultats de la recherche</h2>
        <p>Profils correspondant à votre ville (<?php echo $data['ville']; ?>) ou votre animal (<?php echo $data['animaux'] ?: 'N/A'; ?>) :</p>
        
        <?php if (empty($search_results)): ?>
            <p>Aucun autre profil ne correspond à vos critères.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($search_results as $result): ?>
                    <li>
                        <strong><?php echo $result['nom']; ?></strong> 
                        (Ville: <?php echo $result['ville']; ?>, Animal: <?php echo $result['animaux']; ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    
    <br>
    <a href="index.html">Retour au formulaire</a>
</body>
</html>

<?php
} else {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - TP Formulaire</title>
    <style>
        body { font-family: sans-serif; margin: 2em; max-width: 600px; }
        div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%; padding: 8px; box-sizing: border-box;
        }
        fieldset { border: 1px solid #ccc; padding: 10px; }
        legend { font-weight: bold; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        .error-summary { background-color: #ffe6e6; border: 1px solid #ffb7b7; padding: 15px; }
        .error-message { color: red; font-size: 0.9em; font-weight: bold; }
        input.error, select.error { border: 2px solid red; }
    </style>
</head>
<body>

    <div class="error-summary">
        <h2>Le formulaire contient des erreurs</h2>
        <p>Veuillez corriger les champs indiqués ci-dessous.</p>
    </div>

    <form action="traitement.php" method="POST">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required minlength="2" maxlength="50"
                   class="<?php echo isset($errors['nom']) ? 'error' : ''; ?>"
                   value="<?php echo $data['nom']; ?>">
            <?php if (isset($errors['nom'])): ?>
                <span class="error-message"><?php echo $errors['nom']; ?></span>
            <?php endif; ?>
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required
                   class="<?php echo isset($errors['email']) ? 'error' : ''; ?>"
                   value="<?php echo $data['email']; ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-message"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required minlength="8"
                   class="<?php echo isset($errors['password']) ? 'error' : ''; ?>">
            <?php if (isset($errors['password'])): ?>
                <span class="error-message"><?php echo $errors['password']; ?></span>
            <?php endif; ?>
        </div>

        <fieldset class="<?php echo isset($errors['sexe']) ? 'error' : ''; ?>">
            <legend>Sexe :</legend>
            <?php if (isset($errors['sexe'])): ?><span class="error-message"><?php echo $errors['sexe']; ?></span><?php endif; ?>
            <div>
                <input type="radio" id="sexe_h" name="sexe" value="H" required
                       <?php if ($data['sexe'] == 'H') echo 'checked'; ?>>
                <label for="sexe_h" style="display:inline;">Homme</label>
            </div>
            <div>
                <input type="radio" id="sexe_f" name="sexe" value="F"
                       <?php if ($data['sexe'] == 'F') echo 'checked'; ?>>
                <label for="sexe_f" style="display:inline;">Femme</label>
            </div>
        </fieldset>

        <div>
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" required
                   class="<?php echo isset($errors['ville']) ? 'error' : ''; ?>"
                   value="<?php echo $data['ville']; ?>">
            <?php if (isset($errors['ville'])): ?>
                <span class="error-message"><?php echo $errors['ville']; ?></span>
            <?php endif; ?>
        </div>

        <fieldset>
            <legend>Loisirs (choix multiples) :</legend>
            <div>
                <input type="checkbox" id="loisir_sport" name="loisirs[]" value="sport"
                       <?php if (in_array('sport', $data['loisirs'])) echo 'checked'; ?>>
                <label for="loisir_sport" style="display:inline;">Sport</label>
            </div>
            <div>
                <input type="checkbox" id="loisir_lecture" name="loisirs[]" value="lecture"
                       <?php if (in_array('lecture', $data['loisirs'])) echo 'checked'; ?>>
                <label for="loisir_lecture" style="display:inline;">Lecture</label>
            </div>
            <div>
                <input type="checkbox" id="loisir_jeux" name="loisirs[]" value="jeux"
                       <?php if (in_array('jeux', $data['loisirs'])) echo 'checked'; ?>>
                <label for="loisir_jeux" style="display:inline;">Jeux vidéo</label>
            </div>
        </fieldset>

        <div>
            <label for="animaux">Animal de compagnie :</label>
            <select id="animaux" name="animaux" class="<?php echo isset($errors['animaux']) ? 'error' : ''; ?>">
                <option value="">-- Veuillez choisir --</option>
               
               
                <option value="chien" <?php if ($data['animaux'] == 'chien') echo 'selected'; ?>>Chien</option>
               
               
               
               
                <option value="chat" <?php if ($data['animaux'] == 'chat') echo 'selected'; ?>>Chat</option>
                
                
                <option value="oiseau" <?php if ($data['animaux'] == 'oiseau') echo 'selected'; ?>>Oiseau</option>
                
                
                <option value="poisson" <?php if ($data['animaux'] == 'poisson') echo 'selected'; ?>>Poisson</option>
                
                
                
                <option value="dragon" <?php if ($data['animaux'] == 'dragon') echo 'selected'; ?>>Dragon</option>
                
                <option value="hamster" <?php if ($data['animaux'] == 'hamster') echo 'selected'; ?>>Hamster</option>
                
                <option value="poules" <?php if ($data['animaux'] == 'poules') echo 'selected'; ?>>Poules</option>
                
                
                <option value="tortue" <?php if ($data['animaux'] == 'tortue') echo 'selected'; ?>>Tortue</option>
                
                
                <option value="serpent" <?php if ($data['animaux'] == 'serpent') echo 'selected'; ?>>Serpent</option>
                
                
                <option value="ornitorinque" <?php if ($data['animaux'] == 'orinitorinque') echo 'selected'; ?>>Ornitorinque</option>
                
                <option value="vache" <?php if ($data['animaux'] == 'vache') echo 'selected'; ?>>Vache</option>
                
                
                <option value="aucun" <?php if ($data['animaux'] == 'aucun') echo 'selected'; ?>>Aucun</option>
            </select>
            <?php if (isset($errors['animaux'])): ?>
                <span class="error-message"><?php echo $errors['animaux']; ?></span>
            <?php endif; ?>
        </div>

        <hr>
        <button type="submit">Renvoyer</button>

    </form>
</body>
</html>
<?php
}
?>