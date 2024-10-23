document.addEventListener('DOMContentLoaded', function () {
    console.log('Loaded');

    function displayMessage(message, isSuccess = true) {
        console.log('Displaying message:', message);

        const existingMessage = document.querySelector('.message');
        if (existingMessage) {
            existingMessage.remove();
        }

        const messageElement = document.createElement('section');
        messageElement.textContent = message;
        messageElement.classList.add('message');

        if (isSuccess) {
            messageElement.classList.add('success-message');
        } else {
            messageElement.classList.add('error-message');
        }

        console.log('Appending message to the DOM');
        document.body.appendChild(messageElement);
    }

    async function sendData() {
        const nom = document.querySelector('#nom').value.trim();
        const desc = document.querySelector('#desc').value.trim();

        if (nom.length === 0 || desc.length === 0) {
            displayMessage('Veuillez fournir un nom et une description.', false);
            return;
        }

        console.log('Envoi des données:', { nom, desc });

        const formData = new URLSearchParams();
        formData.append('nom', nom);
        formData.append('desc', desc);
        console.log('Données envoyées à PHP:', formData.toString());

        try {
            const response = await fetch('../../src/controllers/AdminTreatments.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString(),
            });

            if (response.ok) {
                const data = await response.text();
                const trimmedData = data.trim();
                console.log('Réponse reçue:', trimmedData);
            
                if (trimmedData === "Catégorie ajoutée avec succès !") {
                    displayMessage('Catégorie ajoutée avec succès !', true);
                    setTimeout(function () {
                        window.location.href = '../views/admin-sub-category.php';
                    }, 4000);
                } else if (trimmedData === "Cette catégorie existe déjà !") {
                    displayMessage('Cette catégorie existe déjà !', false);
                } else {
                    displayMessage(`Réponse inattendue : ${trimmedData}`, false);
                }
            } else {
                displayMessage(`Erreur serveur : ${response.statusText}`, false);
            }
        } catch (error) {
            console.error('Erreur de fetch :', error);
            displayMessage(`Erreur réseau : ${error.message}`, false);
        }
    }

    document.querySelector('.btn-ajouter').addEventListener('click', function (e) {
        e.preventDefault();
        sendData();
    });

    let form = document.getElementById('categoryForm');
    let hiddenForm = document.getElementById('hiddenForm');

    let modify = document.querySelector('#modify');
    modify.addEventListener('click', function () {
        console.log('Modification clique');
        
        form.style.display = 'none';
        hiddenForm.style.display = 'block';
    });

    let add = document.querySelector('#Add');
    add.addEventListener('click', function () {
        form.style.display = 'block';
        hiddenForm.style.display = 'none';
    });
});
