document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.like-button').addEventListener('click', function () {
        let postId = this.dataset.postId;
        let url = this.dataset.url;

        axios.post(url, {post_id: postId})
            .then(response => {
                if (response.data.success) {
                    let likeCount = this.querySelector('.like-count');
                    likeCount.textContent = response.data.likes;
                    let icon = this.querySelector('i');
                    if (response.data.liked) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                    console.log(da);
                } else {
                    console.log(net);
                    document.getElementById('message').textContent = response.data.message;
                    document.getElementById('message').style.color = 'red';
                }
            })
            .catch(error => console.error('Ошибка:', error));
    });
});
