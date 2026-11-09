<?php
require_once __DIR__ . "/../config/db.php";

/* ======================
   RÉCUPÉRATION & NETTOYAGE
====================== */

// Récupération brute
$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// 1️⃣ SUPPRIMER espaces début / fin
$nom = trim($nom);

// 2️⃣ SUPPRIMER espaces multiples internes
$nom = preg_replace('/\s+/', ' ', $nom);

/* ======================
   VALIDATION
====================== */

// NOM: ne doit pas être vide après nettoyage
if ($nom === '') {
    http_response_code(400);
    echo "Le nom ne doit pas être vide ou composé uniquement d’espaces.";
    exit;
}

// EMAIL: format valide
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Adresse e-mail invalide.";
    exit;
}

// MESSAGE: longueur 20–500 caractères
$longueur = strlen($message);

if ($longueur < 20 || $longueur > 500) {
    http_response_code(400);
    echo "Le message doit contenir entre 20 et 500 caractères.";
    exit;
}

/* ======================
   INSERTION EN BASE
====================== */

$stmt = $conn->prepare(
    "INSERT INTO messages (nom, email, msg) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $nom, $email, $message);
$stmt->execute();

echo "Message envoyé avec succès.";
