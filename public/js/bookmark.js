document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.bookmark-button').forEach(function (button) {
        button.addEventListener('click', function () {
            let bookmarkId = this.dataset.bookmarkId;
            let bookmarkButton = this.querySelector('.bookmark_button');
            let url = this.dataset.url;
            console.log(url);
            axios.post(url, {bookmark_id: bookmarkId})
                .then(response => {
                    if (response.data.success) {
                        if (response.data.bookmark) {
                            bookmarkButton.classList.add('bi', 'bi-bookmark-fill', 'color_grey');
                            bookmarkButton.classList.remove('bi-bookmark');
                        } else {
                            bookmarkButton.classList.add('bi', 'bi-bookmark');
                            bookmarkButton.classList.remove('bi-bookmark-fill', 'color_grey');
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
