<?php
/**
 * Génère les données nécessaires pour afficher la grille du mois
 */
function getCalendarDays($month, $year)
{
    $firstDayOfMonth = strtotime("$year-$month-01");
    $daysInMonth = date('t', $firstDayOfMonth);
    $dayOfWeek = date('N', $firstDayOfMonth);

    $paddingBefore = $dayOfWeek - 1;

    $moisFrancais = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];

    $numeroMois = (int)date('n', $firstDayOfMonth);

    return [
        'daysInMonth' => $daysInMonth,
        'paddingBefore' => $paddingBefore,
        'monthName' => $moisFrancais[$numeroMois],
        'year' => $year
    ];
}

/**
 * Récupère tous les événements pour un mois et une année donnés
 */
function getEventsForMonth($db, $month, $year)
{
    $sql = "SELECT id, title, event_date, DAY(event_date) as day, user_id, image 
        FROM events 
        WHERE MONTH(event_date) = :month 
        AND YEAR(event_date) = :year";

    $stmt = $db->prepare($sql);
    $stmt->execute([':month' => $month, ':year' => $year]);

    $events = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $events[$row['day']][] = $row;
    }
    return $events;
}
