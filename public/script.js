let currentEvent = {};

function openModal(date) {
    document.getElementById('modalDateInput').value = date;
    document.getElementById('displayDate').innerText = date;
    const modal = document.getElementById('eventModal');
    modal.classList.remove('hidden'); 
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('eventModal');
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
}

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

function closeViewModal() {
    const modal = document.getElementById('viewEventModal');
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
}

function openEditModal() {
    closeViewModal();
    
    document.getElementById('editEventId').value = currentEvent.id;
    document.getElementById('editEventTitle').value = currentEvent.title;
    document.getElementById('editEventDate').value = currentEvent.date;

    const modal = document.getElementById('editEventModal');
    modal.classList.remove('hidden'); 
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editEventModal');
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
}