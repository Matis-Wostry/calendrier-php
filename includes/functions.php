<?php
date_default_timezone_set('Europe/Paris');

/**
 * Génère les données nécessaires pour afficher la grille du mois
 */
function getCalendarDays($month, $year) {
    $firstDayOfMonth = strtotime("$year-$month-01");
    $daysInMonth = date('t', $firstDayOfMonth);
    $dayOfWeek = date('N', $firstDayOfMonth);
    
    $paddingBefore = $dayOfWeek - 1;
    
    return [
        'daysInMonth' => $daysInMonth,
        'paddingBefore' => $paddingBefore,
        'monthName' => date('F', $firstDayOfMonth),
        'year' => $year
    ];
}