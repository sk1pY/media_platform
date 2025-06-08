const searchInput = document.getElementById('search');
const resultsBox = document.getElementById('search-cards');

const categorySlug = document.getElementById('category-slug')?.value ||
    document.getElementById('special_category_slug')?.value || '';
const userId = document.getElementById('user-id')?.value || '';
if (searchInput) {
    searchInput.addEventListener('keyup', function () {
        const value = this.value.trim();

        axios.get('/search', {
            params: {search: value, category_slug: categorySlug, user_id: userId}
        }).then(res => {
            resultsBox.innerHTML = res.data.html;
        });
    });
}

