import Vue from 'vue';

Vue.component('dashboard-analytics', require('./views/dashboards/DashboardAnalytics.vue').default);

Vue.component('admin-user-table', require('./views/admin/admin-users/AdminTable.vue').default);
Vue.component('admin-user-view', require('./views/admin/admin-users/AdminView.vue').default);

Vue.component('user-table', require('./views/admin/users/UserTable.vue').default);
Vue.component('user-view', require('./views/admin/users/UserView.vue').default);

Vue.component('role-table', require('./views/admin/roles/RoleTable.vue').default);
Vue.component('role-view', require('./views/admin/roles/RoleView.vue').default);

Vue.component('page-table', require('./views/admin/pages/PageTable.vue').default);
Vue.component('page-view', require('./views/admin/pages/PageView.vue').default);

Vue.component('page-item-table', require('./views/admin/pages/PageItemTable.vue').default);
Vue.component('page-item-view', require('./views/admin/pages/PageItemView.vue').default);

Vue.component('permission-list', require('./views/admin/permissions/PermissionList.vue').default);

Vue.component('article-table', require('./views/admin/articles/ArticleTable.vue').default);
Vue.component('article-view', require('./views/admin/articles/ArticleView.vue').default);

Vue.component('home-banners-table', require('./views/admin/home-banners/HomeBannersTable.vue').default);
Vue.component('home-banners-view', require('./views/admin/home-banners/HomeBannersView.vue').default);

Vue.component('about-infos-table', require('./views/admin/about-infos/AboutInfosTable.vue').default);
Vue.component('about-infos-view', require('./views/admin/about-infos/AboutInfosView.vue').default);