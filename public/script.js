/**
 * GESTION DE L'INTERACTIVITÉ DU CALENDRIER (FRONT-END)
 * Ce script contrôle l'ouverture/fermeture des fenêtres modals et 
 * la manipulation dynamique des données d'événements.
 */

// Objet global servant de "mémoire tampon" pour stocker les informations de l'événement actuellement visualisé ou en cours de modification.
let currentEvent = {};

/**
 * Affiche la fenêtre de création d'événement.
 * @param {string} date - La date sélectionnée au format YYYY-MM-DD
 */
function openModal(date) {
    document.getElementById('modalDateInput').value = date;
    document.getElementById('displayDate').innerText = date;
    const modal = document.getElementById('eventModal');
    modal.classList.remove('hidden'); 
    modal.classList.add('flex');
}

/**
 * Ferme la fenêtre de création d'événement.
 */
function closeModal() {
    const modal = document.getElementById('eventModal');
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
}

/**
 * Affiche les détails d'un événement et gère les droits d'édition.
 * @param {number} id     - ID de l'événement en BDD
 * @param {string} title  - Titre de l'événement
 * @param {string} image  - Chemin vers l'image (si existante)
 * @param {string} userId - Token de l'auteur de l'événement
 * @param {string} date   - Date de l'événement
 */
function openViewModal(id, title, image, userId, date) {
    currentEvent = { id: id, title: title, date: date };

    document.getElementById('viewEventTitle').innerText = title;
    
    const imgContainer = document.getElementById('viewEventImageContainer');
    const imgTag = document.getElementById('viewEventImage');
    if (image) {
        imgTag.src = image; 
        imgContainer.classList.remove('hidden');
    } else {
        imgContainer.classList.add('hidden');
    }

    const actionsDiv = document.getElementById('viewEventActions');
    const noActionsDiv = document.getElementById('viewEventNoActions');
    
    if (userId === currentUserToken) {
        actionsDiv.classList.remove('hidden'); 
        actionsDiv.classList.add('flex');
        noActionsDiv.classList.add('hidden');
        document.getElementById('deleteEventId').value = id;
    } else {
        actionsDiv.classList.add('hidden'); 
        actionsDiv.classList.remove('flex');
        noActionsDiv.classList.remove('hidden');
    }

    const modal = document.getElementById('viewEventModal');
    modal.classList.remove('hidden'); 
    modal.classList.add('flex');
}

/**
 * Ferme la fenêtre de visualisation.
 */
function closeViewModal() {
    const modal = document.getElementById('viewEventModal');
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
}

/**
 * Bascule de la fenêtre de vue vers la fenêtre de modification.
 * Pré-remplit le formulaire avec les données de l'événement sélectionné.
 */
function openEditModal() {
    closeViewModal();
    
    document.getElementById('editEventId').value = currentEvent.id;
    document.getElementById('editEventTitle').value = currentEvent.title;
    document.getElementById('editEventDate').value = currentEvent.date;

    const modal = document.getElementById('editEventModal');
    modal.classList.remove('hidden'); 
    modal.classList.add('flex');
}

/**
 * Ferme la fenêtre de modification.
 */
function closeEditModal() {
    const modal = document.getElementById('editEventModal');
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
}