function openModal(date) {
    document.getElementById('modalDateInput').value = date;
    document.getElementById('displayDate').innerText = date;
    const modal = document.getElementById('eventModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => { modal.querySelector('div').classList.remove('scale-95'); }, 10);
}

function closeModal() {
    const modal = document.getElementById('eventModal');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}