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
* Faqs
*/
// Vue.component('faqs', require('./views/web/faqs/Faqs.vue').default);

/*
* User Booking
*/
Vue.component('user-booking', require('./views/web/bookings/Booking.vue').default);

/*
* User Profile
*/
Vue.component('profile', require('./views/web/auth/Profile.vue').default);

/*
* Dashboard
*/
Vue.component('reservation-list-card', require('./views/web/auth/ReservationListCard.vue').default);

/*
* Request Visit
*/
Vue.component('destinations', require('./views/web/visit-requests/Destinations.vue').default);

Vue.component('destination-info', require('./views/web/destinations/DestinationInfo.vue').default);


