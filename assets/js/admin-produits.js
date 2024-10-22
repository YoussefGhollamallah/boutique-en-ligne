document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');
    const saveButtons = document.querySelectorAll('.btn-save');
    const cancelButtons = document.querySelectorAll('.btn-cancel');

    editButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const row = button.closest('tr');
            toggleEditMode(row, true);
        });
    });

    saveButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const row = button.closest('tr');
            saveChanges(row);
        });
    });

    cancelButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const row = button.closest('tr');
            toggleEditMode(row, false);
        });
    });
    
    function toggleEditMode(row, isEditing) {
        const fields = row.querySelectorAll('.editable');
        fields.forEach(field => {
            const fieldName = field.getAttribute('data-field');
            
            if (isEditing) {
                const input = document.createElement('input');
                input.type = fieldName === 'prix' ? 'number' : 'text';
                input.value = field.textContent.trim();
                input.name = fieldName;
                field.innerHTML = '';
                field.appendChild(input);
            } else {
                field.innerHTML = field.querySelector('input').value;
            }
        });

        // Pour l'image
        const imageField = row.querySelector('td img');
        const fileInput = row.querySelector('td input[type="file"]');
        if (isEditing) {
            imageField.style.display = 'none';
            fileInput.style.display = 'block';
        } else {
            imageField.style.display = 'block';
            fileInput.style.display = 'none';
        }

        // Toggle visibility des boutons
        row.querySelector('.btn-edit').style.display = isEditing ? 'none' : 'inline-block';
        row.querySelector('.btn-save').style.display = isEditing ? 'inline-block' : 'none';
        row.querySelector('.btn-cancel').style.display = isEditing ? 'inline-block' : 'none';
    }

    function saveChanges(row) {
        const productId = row.getAttribute('data-product-id');
        const formData = new FormData();

        row.querySelectorAll('.editable input').forEach(input => {
            formData.append(input.name, input.value);
        });

        const fileInput = row.querySelector('input[type="file"]');
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }

        fetch(`update-product.php?id=${productId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toggleEditMode(row, false);
                // Mettre à jour l'image si une nouvelle a été téléchargée
                if (data.newImage) {
                    row.querySelector('td img').src = `<?php echo ASSETS; ?>/images/${data.newImage}`;
                }
            } else {
                alert('Erreur lors de la sauvegarde');
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});
