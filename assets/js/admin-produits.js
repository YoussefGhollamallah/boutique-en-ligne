document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    const table = document.querySelector('.product-table');

    table.addEventListener('click', function(e) {
        const target = e.target;
        const row = target.closest('tr');

        if (target.classList.contains('btn-edit')) {
            enableEditing(row);
        } else if (target.classList.contains('btn-save')) {
            saveChanges(row);
        } else if (target.classList.contains('btn-cancel')) {
            cancelEditing(row);
        }
    });

    function enableEditing(row) {
        row.querySelectorAll('.editable').forEach(cell => {
            const value = cell.textContent.trim();
            const type = cell.dataset.type;

            switch(type) {
                case 'varchar':
                    cell.innerHTML = `<input type="text" value="${value}" maxlength="255">`;
                    break;
                case 'text':
                    cell.innerHTML = `<textarea>${value}</textarea>`;
                    break;
                case 'decimal':
                    cell.innerHTML = `<input type="number" value="${value}" step="0.01" min="0">`;
                    break;
                case 'integer':
                    cell.innerHTML = `<input type="number" value="${value}" step="1" min="0">`;
                    break;
            }
        });
        row.querySelector('.btn-edit').style.display = 'none';
        row.querySelector('.btn-save').style.display = 'inline-block';
        row.querySelector('.btn-cancel').style.display = 'inline-block';
    }

    function cancelEditing(row) {
        row.querySelectorAll('.editable').forEach(cell => {
            const input = cell.querySelector('input, textarea');
            cell.textContent = input.defaultValue;
        });
        row.querySelector('.btn-edit').style.display = 'inline-block';
        row.querySelector('.btn-save').style.display = 'none';
        row.querySelector('.btn-cancel').style.display = 'none';
    }

    function saveChanges(row) {
        const productId = row.dataset.productId;
        const updatedData = {};

        row.querySelectorAll('.editable').forEach(cell => {
            const field = cell.dataset.field;
            const input = cell.querySelector('input, textarea');
            updatedData[field] = input.value;
            cell.textContent = input.value;
        });

        fetch('/update-product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: productId, ...updatedData }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produit mis à jour avec succès !');
            } else {
                alert('Erreur lors de la mise à jour du produit.');
                cancelEditing(row);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour du produit.');
            cancelEditing(row);
        });

        row.querySelector('.btn-edit').style.display = 'inline-block';
        row.querySelector('.btn-save').style.display = 'none';
        row.querySelector('.btn-cancel').style.display = 'none';
    }
});
