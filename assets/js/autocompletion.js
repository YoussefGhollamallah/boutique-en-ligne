let debounceTimeout;

const searchKeywords = async () => {
    const suggestionBox = document.querySelector("#suggestion");
    let keyword = document.getElementById('search').value;

    if (!keyword.trim()) {
        suggestionBox.innerHTML = '';
        suggestionBox.style.display = 'none';
        return;
    }

    if (debounceTimeout) clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(async () => {
        try {
            const req = await fetch(`${window.location.origin}/boutique-en-ligne/config/search.php?search=${encodeURIComponent(keyword)}`);
            if (!req.ok) {
                throw new Error(`HTTP error! status: ${req.status}`);
            }

            const contentType = req.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const text = await req.text();
                console.error('Received non-JSON response:', text);
                throw new Error(`Expected JSON, got ${contentType}`);
            }

            const json = await req.json();
            suggestionBox.innerHTML = '';

            const formatProductName = (name) => {
                return name
                    .replace(/_/g, ' ') // Remplace les underscores par des espaces
                    .replace(/\b\w/g, char => char.toUpperCase()); // Met en majuscule la première lettre de chaque mot
            };

            if (json.length > 0) {
                json.forEach((element) => {
                    const div = document.createElement("div");
                    div.classList.add("suggestion-item");
                    div.textContent = formatProductName(element.nom); // Applique la transformation

                    div.addEventListener('click', () => {
                        document.getElementById('search').value = formatProductName(element.nom); // Applique aussi lors du clic
                        suggestionBox.innerHTML = '';
                        suggestionBox.style.display = 'none';
                        window.location.href = `${window.location.origin}/boutique-en-ligne/detail/${element.id}`;
                    });

                    suggestionBox.appendChild(div);
                });
                suggestionBox.style.display = 'block';
            } else {
                suggestionBox.innerHTML = "<div>Aucun résultat trouvé</div>";
                suggestionBox.style.display = 'block';
            }
        } catch (error) {
            console.error('Error fetching and parsing data', error);
            suggestionBox.innerHTML = "<div>Une erreur est survenue</div>";
            suggestionBox.style.display = 'block';
        }
    }, 300);
}

document.getElementById('search').addEventListener('input', searchKeywords);

