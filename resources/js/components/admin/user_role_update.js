    document.querySelectorAll('.role-update').forEach(select => {
        select.addEventListener('change', function () {
            let selectedRole = this.value;
            let url = this.dataset.url;

            axios.post(url, { role: selectedRole })
                .then(response => {
                    console.log('Role updated successfully.', response.data);
                })
                .catch(error => {
                    console.error('Error updating role.', error);
                });
        });
    });
