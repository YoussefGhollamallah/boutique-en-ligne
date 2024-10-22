document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé');

    const editButtons = document.querySelectorAll('.btn-edit');
    console.log('Nombre de boutons Modifier:', editButtons.length);

    editButtons.forEach((button) => {
        button.addEventListener('click', function() {
            console.log('Bouton Modifier cliqué');
            const row = button.closest('tr');
            toggleEditMode(row, true);
        });
    });

    const saveButtons = document.querySelectorAll('.btn-save');
    const cancelButtons = document.querySelectorAll('.btn-cancel');

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
        console.log('toggleEditMode appelé, isEditing:', isEditing);
        const fields = row.querySelectorAll('.editable');
        console.log('Nombre de champs éditables:', fields.length);

        fields.forEach(field => {
            const fieldName = field.getAttribute('data-field');
            console.log('Champ en cours de modification:', fieldName);
            
            if (isEditing) {
                const input = document.createElement('input');
                if (fieldName === 'prix') {
                    input.type = 'number';
                    input.step = '0.01';
                    input.min = '0.01';
                } else if (fieldName === 'quantite') {
                    input.type = 'number';
                    input.min = '0';
                } else {
                    input.type = 'text';
                }
                input.value = field.textContent.trim();
                input.name = fieldName;
                field.innerHTML = '';
                field.appendChild(input);
            } else {
                field.innerHTML = field.querySelector('input').value;
            }
        });

        // Gestion de l'image
        const imageCell = row.querySelector('td:nth-child(4)'); // Ajustez l'index si nécessaire
        const img = imageCell.querySelector('img');
        const fileInput = imageCell.querySelector('input[type="file"]');
        const changeImageBtn = imageCell.querySelector('.btn-change-image');

        if (isEditing) {
            img.style.display = 'none';
            fileInput.style.display = 'inline-block';
            changeImageBtn.style.display = 'inline-block';
        } else {
            img.style.display = 'inline-block';
            fileInput.style.display = 'none';
            changeImageBtn.style.display = 'none';
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
            formData.append('file', fileInput.files[0]);
        }

        formData.append('id', productId);

        fetch('src/models/update-product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toggleEditMode(row, false);
                if (data.newImage) {
                    row.querySelector('img').src = `assets/images/${data.newImage}`;
                }
                alert('Produit mis à jour avec succès');
            } else {
                alert('Erreur lors de la sauvegarde : ' + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});
