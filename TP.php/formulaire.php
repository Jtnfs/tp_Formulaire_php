<?php
// Démarrer la session pour lire les erreurs envoyées par traitement.php
session_start();

// Récupérer les erreurs et les anciennes données (s'il y en a)
$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];

// Vider la session pour ne pas ré-afficher les erreurs
unset($_SESSION['errors']);
unset($_SESSION['data']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>TP Formulaire</title>
</head>
<body class="container mt-4 mb-5">
  <header>
    <h1 class="text-center">Formulaire</h1>
  </header>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Erreur :</strong> Le formulaire contient des erreurs.
    </div>
  <?php endif; ?>

  <form action="traitement.php" method="post">
    
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" name="nom" id="nom" 
               class="form-control <?php echo isset($errors['nom']) ? 'is-invalid' : ''; ?>" 
               value="<?php echo htmlspecialchars($data['nom'] ?? ''); ?>" 
               required minlength="2" maxlength="50">
        <?php if (isset($errors['nom'])): ?>
            <div class="invalid-feedback"><?php echo $errors['nom']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" 
               class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
               value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" 
               required>
        <?php if (isset($errors['email'])): ?>
            <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
        <?php endif; ?>
    </div>
    
    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
  </form>
</body>
</html>