<?php
session_start();

// Inclusion des fichiers de configuration et fonctions
require_once('../config/database.php');
require_once('../includes/functions.php');
require_once('../includes/header.php');

// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['month']) && isset($_GET['year'])) {
    $_SESSION['current_month'] = $_GET['month'];
    $_SESSION['current_year'] = $_GET['year'];
}

// Récupération du mois et de l'année
$month = $_SESSION['current_month'] ?? date('m');
$year = $_SESSION['current_year'] ?? date('Y');

// Données du calendrier
$calendar = getCalendarDays($month, $year);

// Navigation
$prevMonth = date('m', strtotime("$year-$month-01 -1 month"));
$prevYear = date('Y', strtotime("$year-$month-01 -1 month"));
$nextMonth = date('m', strtotime("$year-$month-01 +1 month"));
$nextYear = date('Y', strtotime("$year-$month-01 +1 month"));

// Récupération des événements depuis la base de données
$allEvents = getEventsForMonth($db, $month, $year);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <main class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">
            Calendrier Dynamique PHP
        </h1>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-4">
            <div class="p-4 border-b flex justify-between items-center">
                <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Précédent</a>
                <h2 class="text-xl font-semibold uppercase tracking-wider">
                    <?= $calendar['monthName'] . " " . $calendar['year'] ?>
                </h2>
                <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Suivant</a>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-px mb-2">
            <?php
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            foreach ($jours as $jour) {
            ?>
                <div class="text-center font-bold text-gray-500 uppercase text-xs tracking-wider py-2">
                    <?= $jour ?>
                </div>
            <?php }; ?>
        </div>

        <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200">
            <?php for ($i = 0; $i < $calendar['paddingBefore']; $i++) { ?>
                <div class="bg-gray-50 h-32"></div>
            <?php }; ?>

            <?php for ($day = 1; $day <= $calendar['daysInMonth']; $day++) { ?>
                <?php
                $dayPad = str_pad($day, 2, "0", STR_PAD_LEFT);
                $currentDateStr = "$year-$month-$dayPad";
                $isToday = ($day == date('j') && $month == date('m') && $year == date('Y'));
                $isSunday = (date('N', strtotime($currentDateStr)) == 7);
                ?>
                <div class="h-32 p-2 border-t relative <?= $isSunday ? 'bg-[repeating-linear-gradient(45deg,transparent,transparent_10px,#f3f4f6_10px,#f3f4f6_20px)] cursor-not-allowed' : 'bg-white hover:bg-blue-50 transition-colors group' ?>">

                    <div class="flex justify-between items-start">
                        <p class="<?= $isToday ? 'bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full font-bold' : ($isSunday ? 'text-gray-400' : 'text-gray-700') ?>">
                            <?= $day ?>
                        </p>

                        <?php if (!$isSunday) { ?>
                            <button onclick="openModal('<?= $currentDateStr ?>')"
                                class="opacity-0 group-hover:opacity-100 bg-blue-100 text-blue-600 p-1 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        <?php }; ?>
                    </div>

                    <div class="mt-1 space-y-1 overflow-y-auto max-h-20">
                        <?php if (isset($allEvents[$day])) { ?>
                            <?php foreach ($allEvents[$day] as $e) { ?>
                                <?php
                                $hasImage = !empty($e['image']);

                                $jsId = $e['id'];
                                $jsTitle = htmlspecialchars(addslashes($e['title']), ENT_QUOTES);
                                $jsImage = $hasImage ? htmlspecialchars(addslashes($e['image']), ENT_QUOTES) : '';
                                $jsUserId = htmlspecialchars(addslashes($e['user_id']), ENT_QUOTES);
                                ?>

                                <button type="button" onclick="openViewModal('<?= $jsId ?>', '<?= $jsTitle ?>', '<?= $jsImage ?>', '<?= $jsUserId ?>', '<?= $currentDateStr ?>')"
                                    class="w-full text-left text-[10px] p-1 bg-blue-500 text-white rounded truncate shadow-sm hover:bg-blue-600 flex items-center gap-1 transition-colors"
                                    title="<?= htmlspecialchars($e['title']) ?>">

                                    <?php if ($hasImage) { ?>
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    <?php }; ?>

                                    <span class="truncate"><?= htmlspecialchars($e['title']) ?></span>
                                </button>
                            <?php }; ?>
                        <?php }; ?>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </main>

    <script>
        const currentUserToken = "<?= $_COOKIE['user_token'] ?? '' ?>";
    </script>
    <script src="script.js"></script>
    <?php include('../includes/modals.php'); ?>
</body>

</html>