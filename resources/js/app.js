import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

if (window.location.pathname.startsWith('/admin')) {
    Promise.all([
        import('./components/admin/table.js'),
        import('./components/admin/user_role_update.js'),
        import('./components/admin/role_permissions_update.js'),
        import('./components/admin/switch.js'),
        import('./components/admin/claim_status.js')
    ]).then(r => console.log('loaded'));
} else {
    import('./components/like.js');
    import('./components/like_comment.js');
    import('./components/subscribe.js');
    import('./components/view.js');
    import('./components/bookmark.js');
    import('./components/search.js');
}
