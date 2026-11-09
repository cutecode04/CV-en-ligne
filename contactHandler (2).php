<?php
require_once "../config/db.php";

$nom = trim($_POST['nom'] ?? '');
$email = $_POST['email'] ?? '';
$msg = trim($_POST['message'] ?? '');

// Nettoyage espaces multiples
$nom = preg_replace('/\s+/', ' ', $nom);

// VALIDATION
if ($nom === '') {
    http_response_code(400);
    echo "Le nom est obligatoire.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Adresse e-mail invalide.";
    exit;
}

if (strlen($msg) < 20 || strlen($msg) > 500) {
    http_response_code(400);
    echo "Le message doit contenir entre 20 et 500 caractères.";
    exit;
}

// INSERTION
$stmt = $conn->prepare("INSERT INTO messages (nom, email, msg) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nom, $email, $msg);
$stmt->execute();

echo "Message envoyé avec succès.";