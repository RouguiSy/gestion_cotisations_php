<?php
function initSemainesSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['semaines'])) {
        $_SESSION['semaines'] = generateSemaines();
    }
}

function generateSemaines() {
    $semaines = [];
    $dateDebut = new DateTime();
    $dateDebut->modify('first day of this week');
    
    for ($i = 1; $i <= 40; $i++) {
        $debut = clone $dateDebut;
        $fin = clone $dateDebut;
        $fin->modify('next saturday');
        $fin->setTime(0, 0, 0);
        
        $semaines[] = [
            'numero' => $i,
            'date_debut' => $debut->format('Y-m-d'),
            'date_fin' => $fin->format('Y-m-d H:i:s'),
            'est_cloturee' => false
        ];
        
        $dateDebut->modify('+1 week');
    }
    return $semaines;
}

function getSemaines() {
    initSemainesSession();
    return $_SESSION['semaines'];
}

function getSemaineByNumero($numero) {
    $semaines = getSemaines();
    foreach ($semaines as $semaine) {
        if ($semaine['numero'] == $numero) {
            return $semaine;
        }
    }
    return null;
}

function getSemainesNonCloturees() {
    $semaines = getSemaines();
    $result = [];
    foreach ($semaines as $semaine) {
        if (!$semaine['est_cloturee']) {
            $result[] = $semaine;
        }
    }
    return $result;
}

function getDerniereSemaine() {
    $semaines = getSemaines();
    return end($semaines);
}
