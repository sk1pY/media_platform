document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.bookmark-button').forEach(button => {
        button.addEventListener('click', function () {
            let bookmarkId = this.dataset.bookmarkId;
            let bookmarkButton = this;
            let url = this.dataset.url;


            axios.post(url, {bookmark_id: bookmarkId})
                .then(response => {
                    if (response.data.success) {
                        let icon = bookmarkButton.querySelector('i');

                        if (response.data.bookmark) {
                            icon.classList.remove('bi-bookmark');
                            icon.classList.add('bi-bookmark-fill');
                        } else {
                            icon.classList.remove('bi-bookmark-fill');
                            icon.classList.add('bi-bookmark');
                        }
                    } else {
                        document.getElementById('message').textContent = response.data.message;
                        document.getElementById('message').style.color = 'red';
                    }

                })
                .catch(error => console.error('Ошибка:', error));
        });
    });
});
