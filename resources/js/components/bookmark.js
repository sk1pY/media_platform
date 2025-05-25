document.querySelectorAll('.bookmark-button').forEach(button => {
    button.addEventListener('click', function () {
        let postId = this.dataset.postId;

        let bookmarkButton = this;
        let url = this.dataset.url;
        axios.post(url, {post_id: postId})
            .then(response => {
                if (response.data.success) {
                    let icon = bookmarkButton.querySelector('i');
                    const cardPost = document.getElementById(`card-${postId}`);
                    const toastLiveExample = document.getElementById('liveToastBookmark')
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                    if (response.data.bookmarkStore) {
                        icon.classList.remove('bi-bookmark');
                        icon.classList.add('bi-bookmark-fill');
                        // const toastTrigger = document.getElementById('liveToastBtn')
                        toastBootstrap.show()

                    } else {
                        if (window.location.pathname === '/profile/bookmarks') {
                            cardPost.remove();
                        }
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

