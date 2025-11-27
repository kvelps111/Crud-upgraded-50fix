document.addEventListener('DOMContentLoaded', () => {
    const tagInput = document.getElementById('new-tag-name');
    const addTagBtn = document.getElementById('add-tag-btn');
    const tagList = document.getElementById('product-tags');

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    addTagBtn.addEventListener('click', () => {
        const name = tagInput.value.trim();
        if (!name) return alert('Ievadiet birku');

        fetch(addTagBtn.dataset.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.tag) {
                alert("Servera kļūda!");
                return;
            }

            const li = document.createElement('li');
            li.textContent = data.tag.name;
            tagList.appendChild(li);

            tagInput.value = '';
        })
        .catch(err => console.error(err));
    });
});
