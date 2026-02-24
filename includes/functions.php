<?php
/**
 * Génère toutes les données nécessaires pour construire la grille du calendrier.
 * Calcule le nombre de jours, le décalage pour le premier jour du mois, et traduit le mois.
 * @param int|string $month Le mois ciblé (1 à 12)
 * @param int|string $year L'année ciblée (ex: 2026)
 * @return array Un tableau associatif contenant les infos pour l'affichage HTML
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
 * Récupère tous les événements de la base de données pour un mois donné,
 * et les trie par jour pour faciliter l'affichage dans la grille.
 * @param PDO $db L'instance de connexion à la base de données
 * @param int|string $month Le mois ciblé
 * @param int|string $year L'année ciblée
 * @return array Un tableau d'événements groupés par jour (ex: $events[15] pour le 15 du mois)
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
