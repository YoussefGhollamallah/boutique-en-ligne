document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');
    const saveButtons = document.querySelectorAll('.btn-save');
    const cancelButtons = document.querySelectorAll('.btn-cancel');
    const editableFields = document.querySelectorAll('.editable');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = button.closest('tr');
            row.querySelectorAll('.editable').forEach(field => {
                field.contentEditable = true;
                field.classList.add('editing');
            });
            row.querySelector('.btn-edit').style.display = 'none';
            row.querySelector('.btn-save').style.display = 'inline-block';
            row.querySelector('.btn-cancel').style.display = 'inline-block';
        });
    });

    saveButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = button.closest('tr');
            const userId = row.dataset.userId;
            const updatedData = {};

            row.querySelectorAll('.editable').forEach(field => {
                field.contentEditable = false;
                field.classList.remove('editing');
                updatedData[field.dataset.field] = field.textContent.trim();
            });

            // Envoyer les données mises à jour au serveur
            fetch(`update-user.php?id=${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Utilisateur mis à jour avec succès');
                } else {
                    alert('Erreur lors de la mise à jour de l\'utilisateur');
                }
            });

            row.querySelector('.btn-edit').style.display = 'inline-block';
            row.querySelector('.btn-save').style.display = 'none';
            row.querySelector('.btn-cancel').style.display = 'none';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = button.closest('tr');
            row.querySelectorAll('.editable').forEach(field => {
                field.contentEditable = false;
                field.classList.remove('editing');
            });
            row.querySelector('.btn-edit').style.display = 'inline-block';
            row.querySelector('.btn-save').style.display = 'none';
            row.querySelector('.btn-cancel').style.display = 'none';
        });
    });
});