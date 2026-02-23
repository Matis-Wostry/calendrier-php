<?php
// On inclut les fichiers nécessaires au début
require_once('../includes/functions.php');

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$calendar = getCalendarDays($month, $year);

$prevMonth = date('m', strtotime("$year-$month-01 -1 month"));
$prevYear = date('Y', strtotime("$year-$month-01 -1 month"));
$nextMonth = date('m', strtotime("$year-$month-01 +1 month"));
$nextYear = date('Y', strtotime("$year-$month-01 +1 month"));

$currentDateStr = "$year-$month-" . str_pad($day, 2, "0", STR_PAD_LEFT);
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
    <script src="./script.js" defer></script>


    <main class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">
            <?php echo "Calendrier Dynamique PHP"; ?>
        </h1>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Précédent</a>
                <h2 class="text-xl font-semibold">
                    <?= $calendar['monthName'] . " " . $calendar['year'] ?>
                </h2>
                <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Suivant</a>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200">
            <?php for ($i = 0; $i < $calendar['paddingBefore']; $i++) { ?>
                <div class="bg-gray-50 h-32"></div>
            <?php } ?>

            <?php for ($day = 1; $day <= $calendar['daysInMonth']; $day++) { ?>
                <?php
                $isToday = ($day == date('j') && $month == date('m') && $year == date('Y'));
                ?>
                <div class="bg-white h-32 p-2 border-t hover:bg-blue-50 transition-colors group relative">
                    <div class="flex justify-between items-start">
                        <p class="<?= $isToday ? 'bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full font-bold' : 'text-gray-700' ?>">
                            <?= $day ?>
                        </p>

                        <button onclick="openModal('<?= $currentDateStr ?>')"
                            class="opacity-0 group-hover:opacity-100 bg-blue-100 text-blue-600 p-1 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>

                </div>
            <?php }; ?>
        </div>
        </div>
    </main>

    <div id="eventModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Nouvel événement</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form method="POST" action="event_handler.php" class="space-y-4">
                <input type="hidden" name="event_date" id="modalDateInput">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Que voulez-vous prévoir ?</label>
                    <input type="text" name="title" required placeholder="Ex: Déjeuner Cartier"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="bg-blue-50 p-3 rounded-lg flex items-center text-blue-700 text-sm">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"></path>
                    </svg>
                    Date sélectionnée : <span id="displayDate" class="font-bold ml-1"></span>
                </div>

                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">Annuler</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg transition">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>