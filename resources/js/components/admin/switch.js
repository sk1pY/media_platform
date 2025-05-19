    document.querySelectorAll('.js-switch').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {

            let status = this.checked ? 1 : 0;
            let url = this.dataset.url;

            axios.put(url, {
                status: status,
            })
                .then(response => {
                    console.log('status update success')
                })
                .catch(error => {
                    console.error('Error updating status.', error);
                });
        });
    });


