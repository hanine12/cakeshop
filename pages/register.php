<?php
require_once '../classes/User.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->full_name = $_POST['full_name'];
    $user->email = $_POST['email'];
    $user->phone = $_POST['phone'];
    $user->password = $_POST['password'];

    if ($user->emailExists($_POST['email'])) {
        $error = 'Cet email est déjà utilisé.';
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        if ($user->register()) {
            $success = 'Inscription réussie ! Redirection...';
            header('refresh:2;url=login.php');
        } else {
            $error = 'Erreur lors de l\'inscription.';
        }
    }
}
?>

<div class="form-container">
    <h2>🍰 Inscription</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nom complet</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone">
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required minlength="6">
        </div>
        <div class="form-group">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">S'inscrire</button>
    </form>
    <p style="text-align:center; margin-top:15px;">
        Déjà un compte ? <a href="login.php">Se connecter</a>
    </p>
</div>

<?php require_once '../includes/footer.php'; ?>