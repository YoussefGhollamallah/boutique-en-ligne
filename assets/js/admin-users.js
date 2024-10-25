document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');
    const modal = document.getElementById('userModal');
    const cancelButton = document.getElementById('cancel');
    const closeModal = document.querySelector('.close');
    const userForm = document.getElementById('userForm');

    // Récupérer les rôles pour les afficher dans le select
    

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = button.getAttribute('data-user-id');
            const row = button.closest('tr');
            const nom = row.querySelector('td:nth-child(2)').textContent.trim();
            const prenom = row.querySelector('td:nth-child(3)').textContent.trim();
            const email = row.querySelector('td:nth-child(4)').textContent.trim();
            const adresseComplete = row.querySelector('td:nth-child(5)').innerHTML.trim();
            const nom_role = row.querySelector('td:nth-child(6)').textContent.trim();

            // Découper l'adresse complète en différentes parties
            const adresseParts = adresseComplete.split('<br>');
            const adresse = adresseParts[0] || '';
            const adresse_complement = adresseParts[1] || '';
            const codeVillePays = adresseParts[2] ? adresseParts[2].split(', ') : ['', '', ''];
            const code_postal = codeVillePays[0] || '';
            const ville = codeVillePays[1] || '';
            const pays = codeVillePays[2] || '';

            // Remplir le formulaire avec les données de l'utilisateur
            document.getElementById('userId').value = userId;
            document.getElementById('nom').value = nom;
            document.getElementById('prenom').value = prenom;
            document.getElementById('email').value = email;
            document.getElementById('adresse').value = adresse;
            document.getElementById('adresse_complement').value = adresse_complement;
            document.getElementById('code_postal').value = code_postal;
            document.getElementById('ville').value = ville;
            document.getElementById('pays').value = pays;

            // Remplir le select des rôles
            const roleSelect = document.getElementById('nom_role');
            roleSelect.innerHTML = '';
            roles.forEach(role => {
                const option = document.createElement('option');
                option.value = role.id_role;
                option.textContent = role.id_role + ' - ' + role.nom_role;
                if (role.nom_role === nom_role) {
                    option.selected = true;
                }
                roleSelect.appendChild(option);
            });

            // Afficher le modal
            modal.style.display = 'block';
        });
    });

    // Fermer le modal
    closeModal.addEventListener('click', function ()  {
        modal.style.display = 'none';
    });

    cancelButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Fermer le modal si l'utilisateur clique en dehors
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Soumettre le formulaire
    userForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(userForm);

        fetch('admin-users.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
                alert('Utilisateur mis à jour avec succès');
                location.reload(); // Recharger la page pour voir les modifications
            }
        );
    });
});
