<?php
session_start();
session_regenerate_id(true);

$usuario = "admin"; 
$senha = 'string(97)"$argon2id$v=19$m=65536,t=4,p=1$aWNMUGNrcXhnNmhBcG9Wcg$DR4mv5EMvG8wXdoVXUiHNVeGO4nzNWxZlOkUoHD0L4U';
var_dump(password_hash("admin", PASSWORD_ARGON2ID));
die();
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION["user"])) {

if (!isset($_SESSION["csrf_token"]) || !hash_equals($_SESSION ["csrf_token"], $token)){
    die("Falha no login");
}    

if ($_POST["login"] == $usuario && password_verify($POST["senha"], $senha)) {
    $_SESSION["User"] = $usuario;
}    
}
if(!isset($_SESSION["user"])){
    header("Location: ../index.php");
}

$page = $_GET["p"] ?? "home";

$titulo = match ($page) {
    "home" => ": home",
    "tab" => ": tabela",
    "form" => ": Formulário",
    default => ": ERRO 404",
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula Sessões em PHP <?= $titulo ?? "" ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header><h1>Sessões</h1></header>
<nav><ul>
    <a href="?p=home">Home</a>
    <a href="?p=tab">Tabela</a>
    <a href="?p=form">Formulário</a>
    <a href="?p=sair">sair</a>
</ul></nav>
<main>
    <section>
        <?php
            require_once match ($page){
                "home" => "./page/home.php",
                "tab" => "./page/tabela",
                "form" => "./page/Formulário",
                "sair" => "./page/logout.php",
                default => ": ERRO 404",
            }

        ?>
    </section>
</main>
<footer>
    <h3> Rodapé </h3>
</footer>
    
</body>
</html>