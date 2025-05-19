    document.querySelectorAll('.sub-button').forEach(button => {
        button.addEventListener('click', function () {
            let authorId = this.dataset.authorId;
            let url = this.dataset.url;
            let buttonElement = this.querySelector('button');
            axios.post(url, {author_id: authorId})
                .then(response => {
                    if (response.data.success) {
                        const subCardUser = document.getElementById(`subscribe-card-user-${authorId}`);
                        if (response.data.sub) {
                            buttonElement.textContent = 'Отписаться'
                            buttonElement.classList.add('btn-outline-secondary');
                            buttonElement.classList.remove('btn-secondary');

                        } else {
                            subCardUser.remove();
                            buttonElement.textContent = 'Подписаться'
                            buttonElement.classList.add('btn-secondary');
                            buttonElement.classList.remove('btn-outline-secondary');
                        }
                    } else {
                        document.getElementById('message').textContent = response.data.message;
                        document.getElementById('message').style.color = 'red';
                    }
                })
                .catch(error => console.error('Ошибка:', error));
        });
    });


