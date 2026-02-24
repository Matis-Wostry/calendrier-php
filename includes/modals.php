<div id="eventModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Nouvel événement</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <form method="POST" action="event_handler.php" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="event_date" id="modalDateInput">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Que voulez-vous prévoir ?</label>
                <input type="text" name="title" required placeholder="Ex: Déjeuner Cartier"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Image (Optionnelle)</label>
                <input type="file" name="event_image" accept="image/jpeg, image/png, image/webp, image/gif"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
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

<div id="viewEventModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95">
        <div class="flex justify-between items-start mb-4">
            <h3 id="viewEventTitle" class="text-2xl font-bold text-gray-800 break-words pr-4"></h3>
            <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>

        <div id="viewEventImageContainer" class="mb-6 hidden">
            <img id="viewEventImage" src="" class="w-full h-48 object-cover rounded-xl shadow-sm">
        </div>

        <div id="viewEventActions" class="flex space-x-3 pt-4 border-t mt-4 hidden">
            <form method="POST" action="delete_event.php" class="flex-1" onsubmit="return confirm('Vraiment supprimer ?');">
                <input type="hidden" name="event_id" id="deleteEventId">
                <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-xl hover:bg-red-200">Supprimer</button>
            </form>
            <button onclick="openEditModal()" class="flex-1 px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-xl hover:bg-blue-200">Modifier</button>
        </div>

        <div id="viewEventNoActions" class="pt-4 border-t mt-4 text-sm text-gray-500 italic text-center hidden">
            Vous ne pouvez pas modifier cet événement.
        </div>
    </div>
</div>

<div id="editEventModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Modifier l'événement</h3>

        <form method="POST" action="update_event.php" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="event_id" id="editEventId">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" id="editEventTitle" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Date</label>
                <input type="date" name="event_date" id="editEventDate" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nouvelle image (Optionnel)</label>
                <input type="file" name="event_image" accept="image/jpeg, image/png, image/webp, image/gif"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700">
                <p class="text-xs text-gray-400 mt-1">Laissez vide pour conserver l'image actuelle.</p>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200">Annuler</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>