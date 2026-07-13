<?php
function initApprenantsSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['apprenants'])) {
        $_SESSION['apprenants'] = getDefaultApprenants();
    }
}

function getDefaultApprenants() {
    return [
        [
            'id' => 1,
            'nom' => 'Diallo',
            'prenom' => 'Boubacar',
            'email' => 'boubacar.diallo@example.com',
            'telephone' => '771234567',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'gerant',
            'actif' => true,
            'date_inscription' => date('Y-m-d')
        ],
        [
            'id' => 2,
            'nom' => 'Sow',
            'prenom' => 'Abdou',
            'email' => 'abdou.sow@example.com',
            'telephone' => '772345678',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'apprenant',
            'actif' => true,
            'date_inscription' => date('Y-m-d')
        ],
        [
            'id' => 3,
            'nom' => 'Ndiaye',
            'prenom' => 'Fatou',
            'email' => 'fatou.ndiaye@example.com',
            'telephone' => '773456789',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'apprenant',
            'actif' => true,
            'date_inscription' => date('Y-m-d')
        ],
        [
            'id' => 4,
            'nom' => 'Gueye',
            'prenom' => 'Ibrahima',
            'email' => 'ibrahima.gueye@example.com',
            'telephone' => '774567890',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'apprenant',
            'actif' => true,
            'date_inscription' => date('Y-m-d')
        ],
        [
            'id' => 5,
            'nom' => 'Fall',
            'prenom' => 'Moussa',
            'email' => 'moussa.fall@example.com',
            'telephone' => '775678901',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'apprenant',
            'actif' => true,
            'date_inscription' => date('Y-m-d')
        ],
        [
            'id' => 6,
            'nom' => 'Ba',
            'prenom' => 'Aminata',
            'email' => 'aminata.ba@example.com',
            'telephone' => '776789012',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'coach',
            'actif' => true,
            'date_inscription' => date('Y-m-d')
        ]
    ];
}

function getApprenants() {
    initApprenantsSession();
    return $_SESSION['apprenants'];
}

function getApprenantById($id) {
    $apprenants = getApprenants();
    foreach ($apprenants as $apprenant) {
        if ($apprenant['id'] == $id) {
            return $apprenant;
        }
    }
    return null;
}

function getApprenantByEmail($email) {
    $apprenants = getApprenants();
    foreach ($apprenants as $apprenant) {
        if ($apprenant['email'] === $email) {
            return $apprenant;
        }
    }
    return null;
}

function getApprenantsActifs() {
    $apprenants = getApprenants();
    $result = [];
    foreach ($apprenants as $apprenant) {
        if ($apprenant['actif']) {
            $result[] = $apprenant;
        }
    }
    return $result;
}

// Fonctions de validation
function required($field, &$value, array &$errors) {
    $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
    if (empty($value)) {
        $errors[] = "Le champ $field est requis.";
    }
}

function validateEmail($field, &$value, array &$errors) {
    $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
    if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Le champ $field doit être un email valide.";
    }
}

// Fonctions d'auth
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /gestion-cotis?controller=auth&action=login');
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['role'] !== $role) {
        header('Location: /gestion-cotis?controller=' . $_SESSION['role'] . '&action=dashboard');
        exit;
    }
}