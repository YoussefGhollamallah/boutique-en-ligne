document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0]
            const productId = this.id.split('-')[1]
            if (file) {
                console.log(`File selected for product ${productId}:`, file.name)
            }
        });
    });

    async function getData() {
        try {
            const formData = new URLSearchParams();
            formData.append('nom', document.querySelector('#categories').value)
            formData.append('desc', document.querySelector('#desc').value)

            const response = await fetch('../controllers/admin-treatments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            console.log(response)
            if (response.ok) {
                const data = await response.text()
                console.log('Data received:', data)

                const messageElement = document.createElement('div')
                if (data.trim() === "Category Added") {
                    messageElement.textContent = "Added Successfully"
                } else {
                    messageElement.textContent = `Something went wrong: ${data}`
                }
                document.body.appendChild(messageElement)
            } else {
                console.error('Error fetching page:', response.statusText)
            }
        } catch (error) {
            console.error('Fetch error:', error)
        }
    }

    document.querySelector('.btn-ajouter').addEventListener('click', function(e) {
        e.preventDefault()
        let name = document.querySelector('#categories').value
        let desc = document.querySelector('#desc').value

        if (name.length > 0 && desc.length > 0) {
            getData()
        } else {
            console.error('Name and description must be filled out.')
        }
    })
})
