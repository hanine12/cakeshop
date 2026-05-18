<?php
require_once '../classes/User.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->full_name;
        $_SESSION['user_role'] = $user->role;
        
        if ($user->role === 'admin') {
            header('Location: /cakeshop/admin/');
        } else {
            header('Location: /cakeshop/');
        }
        exit;
    } else {
        $error = 'Email ou mot de passe incorrect.';
    }
}
?>

<div class="form-container">
    <h2>🔐 Connexion</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Se connecter</button>
    </form>
    <p style="text-align:center; margin-top:15px;">
        Pas de compte ? <a href="register.php">S'inscrire</a>
    </p>
</div>

<?php require_once '../includes/footer.php'; ?>