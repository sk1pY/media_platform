if (/^\/posts\/[^\/]+$/.test(window.location.pathname)) {
    let parts = window.location.pathname.split('/');
    let slug = parts[parts.length - 1];
    setTimeout(() =>
            axios.post(`/posts/${slug}/increment-views`)
                .then(response => {

                        if (response.data.success) {
                            let viewCount = document.querySelector('.view-count');
                            viewCount.textContent = response.data.views;

                        } else {
                            document.getElementById('message').textContent = response.data.message;
                            document.getElementById('message').style.color = 'red';
                        }
                    }
                ),
        1000);

}
