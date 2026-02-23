<?php
// On inclut les fichiers nécessaires au début
require_once('../includes/functions.php');

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$calendar = getCalendarDays($month, $year);

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

    <?php include('../includes/header.php'); ?>

    <main class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">
            <?php echo "Calendrier Dynamique PHP"; ?>
        </h1>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Précédent</button>
                <p class="text-xl font-semibold">Février 2026</p>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Suivant</button>
            </div>

            <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200">
                <?php for ($i = 0; $i < $calendar['paddingBefore']; $i++): ?>
                    <div class="bg-gray-50 h-32"></div>
                <?php endfor; ?>

                <?php for ($day = 1; $day <= $calendar['daysInMonth']; $day++): ?>
                    <?php
                    $isToday = ($day == date('j') && $month == date('m') && $year == date('Y'));
                    ?>
                    <div class="bg-white h-32 p-2 border-t hover:bg-blue-50 transition-colors relative">
                        <span class="<?= $isToday ? 'bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full' : 'text-gray-700' ?>">
                            <?= $day ?>
                        </span>

                        <div class="mt-1 space-y-1 overflow-y-auto max-h-20">
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>

</body>

</html>