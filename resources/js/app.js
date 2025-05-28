import './bootstrap.js';


if (window.location.pathname.startsWith('/admin')) {
    Promise.all([
        import('./components/admin/table.js'),
        import('./components/admin/user_role_update.js'),
        import('./components/admin/role_permissions_update.js'),
        import('./components/admin/switch.js'),
        import('./components/admin/claim_status.js')
    ]).then(response => {
        console.log('loaded')
    });
} else {
    import('./components/like.js');
    import('./components/like_comment.js');
    import('./components/subscribe.js');
    import('./components/view.js');
    import('./components/bookmark.js');
    import('./components/search.js');
}
