Vue.component('dialog-container', require('./components/dialogs/DialogContainer.vue').default);

Vue.component('article-list', require('./views/web/articles/ArticleList.vue').default);
Vue.component('selected-article', require('./views/web/articles/SelectedArticle.vue').default);

/*
* User Destination
*/
Vue.component('user-inquiry', require('./views/web/inquiries/Inquiry.vue').default);

/*
* User Destination
*/

Vue.component('user-destination', require('./views/web/destinations/Destination.vue').default);

/*
* User Booking
*/
Vue.component('user-booking', require('./views/web/bookings/Booking.vue').default);

/*
* User Profile
*/
Vue.component('profile', require('./views/web/auth/Profile.vue').default);
