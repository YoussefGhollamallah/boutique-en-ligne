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
        const currentImage = imageCell.querySelector('.current-image');
        const imageEditContainer = imageCell.querySelector('.image-edit-container');
        const fileInput = imageEditContainer.querySelector('input[type="file"]');
        const chooseImageBtn = imageEditContainer.querySelector('.btn-choose-image');
        const selectedFileName = imageEditContainer.querySelector('.selected-file-name');
        const imagePreview = imageEditContainer.querySelector('.image-preview');

        if (isEditing) {
            currentImage.style.display = 'none';
            imageEditContainer.style.display = 'block';
            imagePreview.src = currentImage.src;
            imagePreview.style.display = 'block';
        } else {
            currentImage.style.display = 'block';
            imageEditContainer.style.display = 'none';
            fileInput.value = ''; // Réinitialiser l'input file
            selectedFileName.textContent = ''; // Effacer le nom du fichier affiché
            imagePreview.style.display = 'none';
        }

        // Ajouter un gestionnaire d'événements pour le bouton "Choisir une image"
        chooseImageBtn.onclick = function() {
            fileInput.click();
        };

        // Ajouter un gestionnaire d'événements pour l'input file
        fileInput.onchange = function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
                selectedFileName.textContent = this.files[0].name;
            } else {
                selectedFileName.textContent = '';
                imagePreview.style.display = 'none';
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

        let isValid = true;
        let errorMessage = '';

        row.querySelectorAll('.editable input').forEach(input => {
            if (input.name === 'prix') {
                const price = parseFloat(input.value);
                if (isNaN(price) || price < 0.01) {
                    isValid = false;
                    errorMessage = 'Le prix doit être au minimum de 0,01 €';
                    return;
                }
            }
            formData.append(input.name, input.value);
        });

        if (!isValid) {
            alert(errorMessage);
            return;
        }

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
                    row.querySelector('.current-image').src = `assets/images/${data.newImage}`;
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
