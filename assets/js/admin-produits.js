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
        const chooseImageBtn = imageCell.querySelector('.btn-choose-image');
        const selectedFileName = imageCell.querySelector('.selected-file-name');

        if (isEditing) {
            img.style.display = 'none';
            chooseImageBtn.style.display = 'inline-block';
            selectedFileName.style.display = 'inline-block';
        } else {
            img.style.display = 'inline-block';
            chooseImageBtn.style.display = 'none';
            selectedFileName.style.display = 'none';
            fileInput.value = ''; // Réinitialiser l'input file
            selectedFileName.textContent = ''; // Effacer le nom du fichier affiché
        }

        // Ajouter un gestionnaire d'événements pour le bouton "Choisir un fichier"
        chooseImageBtn.onclick = function() {
            fileInput.click();
        };

        // Ajouter un gestionnaire d'événements pour l'input file
        fileInput.onchange = function() {
            if (this.files && this.files[0]) {
                selectedFileName.textContent = this.files[0].name;
            } else {
                selectedFileName.textContent = '';
            }
        };

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
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour du produit');
        });
    }
});
