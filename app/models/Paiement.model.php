<?php
function initPaiementsSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['paiements'])) {
        $_SESSION['paiements'] = [];
    }
}

function getPaiements() {
    initPaiementsSession();
    return $_SESSION['paiements'];
}

function getPaiementsByApprenant($apprenantId) {
    $paiements = getPaiements();
    $result = [];
    foreach ($paiements as $paiement) {
        if ($paiement['apprenant_id'] == $apprenantId) {
            $result[] = $paiement;
        }
    }
    return $result;
}

function getPaiementsByCampagne($campagneId) {
    $paiements = getPaiements();
    $result = [];
    foreach ($paiements as $paiement) {
        if ($paiement['campagne_id'] == $campagneId) {
            $result[] = $paiement;
        }
    }
    return $result;
}

function ajouterPaiement($apprenantId, $campagneId, $montant, $semaineNumero = null) {
    initPaiementsSession();
    $id = count($_SESSION['paiements']) + 1;
    $newPaiement = [
        'id' => $id,
        'apprenant_id' => $apprenantId,
        'campagne_id' => $campagneId,
        'montant' => $montant,
        'semaine_numero' => $semaineNumero,
        'date_paiement' => date('Y-m-d H:i:s'),
        'statut' => 'valide'
    ];
    $_SESSION['paiements'][] = $newPaiement;
    return $newPaiement;
}

function getTotalCollecte() {
    $paiements = getPaiements();
    return array_sum(array_column($paiements, 'montant'));
}

function getTotalCollecteByApprenant($apprenantId) {
    $paiements = getPaiementsByApprenant($apprenantId);
    return array_sum(array_column($paiements, 'montant'));
}

function getTotalCollecteByCampagne($campagneId) {
    $paiements = getPaiementsByCampagne($campagneId);
    return array_sum(array_column($paiements, 'montant'));
}

function getApprenantPayeSemaine($apprenantId, $semaineNumero) {
    $paiements = getPaiements();
    foreach ($paiements as $paiement) {
        if ($paiement['apprenant_id'] == $apprenantId && 
            isset($paiement['semaine_numero']) && 
            $paiement['semaine_numero'] == $semaineNumero) {
            return true;
        }
    }
    return false;
}