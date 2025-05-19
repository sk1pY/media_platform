document.querySelectorAll('.like-comment').forEach(button => {
    button.addEventListener('click', function () {
        let commentId = this.dataset.commentId;
        let likeButton = this;
        let url = this.dataset.url;

        axios.post(url, {comment_id: commentId})
            .then(response => {
                if (response.data.success) {
                    let likeCount = likeButton.querySelector('.like-count');
                    likeCount.textContent = response.data.likes;
                    let icon = likeButton.querySelector('i');
                    if (response.data.liked) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                } else {
                    document.getElementById('message').textContent = response.data.message;
                    document.getElementById('message').style.color = 'red';
                }
            })
    });
});

