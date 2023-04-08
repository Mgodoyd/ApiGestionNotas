import './bootstrap';


Vue.component(
	'passport-personal-access-tokens',
	require('./components/passport/PersonalAccessTokens.vue'));

Vue.component(
	'passport-clients',
	require('./components/passport/Clients.vue'));

Vue.component(
	'passport-authorized-clients',
	require('./components/passport/AuthorizedClients.vue'));

const app = new Vue({
    el: '#app'
});