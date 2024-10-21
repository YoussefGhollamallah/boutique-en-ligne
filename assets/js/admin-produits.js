document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');
    const saveButtons = document.querySelectorAll('.btn-save');
    const cancelButtons = document.querySelectorAll('.btn-cancel');

    editButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const row = button.closest('tr');
            toggleEditMode(row, true);
        });
    });

    saveButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const row = button.closest('tr');
            saveChanges(row);
        });
    });

    cancelButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const row = button.closest('tr');
            toggleEditMode(row, false);
        });
    });
    
    function toggleEditMode(row, isEditing) {
        const fields = row.querySelectorAll('.editable');
        fields.forEach(field => {
            const fieldType = field.getAttribute('data-type');
            const fieldName = field.getAttribute('data-field');
            
            if (isEditing) {
                if (fieldType === 'varchar' || fieldType === 'text') {
                    const input = document.createElement(fieldType === 'text' ? 'textarea' : 'input');
                    input.type = 'text';
                    input.value = field.textContent.trim();
                    input.name = fieldName;
                    field.innerHTML = '';
                    field.appendChild(input);
                } else if (fieldType === 'decimal' || fieldType === 'integer') {
                    const input = document.createElement('input');
                    input.type = fieldType === 'decimal' ? 'number' : 'number';
                    input.step = fieldType === 'decimal' ? '0.01' : '1';
                    input.value = field.textContent.trim();
                    input.name = fieldName;
                    field.innerHTML = '';
                    field.appendChild(input);
                }
            } else {
                field.innerHTML = field.querySelector('input, textarea').value;
            }
        });

        // Pour l'image, on va ajouter un bouton "Parcourir"
        const imageField = row.querySelector('td img');
        if (isEditing) {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/png, image/jpeg';
            fileInput.name = 'image';
            imageField.closest('td').innerHTML = '';
            imageField.closest('td').appendChild(fileInput);
        } else {
            const imageName = imageField.closest('td').querySelector('input').value;
            imageField.closest('td').innerHTML = `<img src="../../images/${imageName}" width="50" />`;
        }

        // Toggle visibility des boutons
        row.querySelector('.btn-edit').style.display = isEditing ? 'none' : 'inline-block';
        row.querySelector('.btn-save').style.display = isEditing ? 'inline-block' : 'none';
        row.querySelector('.btn-cancel').style.display = isEditing ? 'inline-block' : 'none';
    }

    function saveChanges(row) {
        const productId = row.getAttribute('data-product-id');
        const formData = new FormData();

        row.querySelectorAll('.editable input, .editable textarea').forEach(input => {
            formData.append(input.name, input.value);
        });

        const fileInput = row.querySelector('input[type="file"]');
        if (fileInput && fileInput.files.length > 0) {
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
            } else {
                alert('Erreur lors de la sauvegarde');
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});
