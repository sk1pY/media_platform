document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.sub-button').forEach(button => {
        button.addEventListener('click', function () {
            let authorId = this.dataset.authorId;
            let url = this.dataset.url;
            let buttonElement = this.querySelector('button');
            axios.post(url, {author_id: authorId})
                .then(response => {
                    if (response.data.success) {
                        if (response.data.sub) {
                            buttonElement.textContent = 'Отписаться'
                        } else {
                            buttonElement.textContent = 'Подписаться'
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


