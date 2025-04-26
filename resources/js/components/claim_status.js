document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.claim-update').forEach(select => {
        select.addEventListener('change', function () {
            let selectedStatus = this.value;
            let url = this.dataset.url;

            axios.put(url, { status: selectedStatus })
                .then(response => {
                    console.log('Role updated successfully.', response.data);
                })
                .catch(error => {
                    console.error('Error updating status.', error);
                });
        });
    });
});
