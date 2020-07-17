
import Vue from 'vue';
import AdditionalItemSearch from './components/AdditionalitemSearch.vue';

if (document.getElementById('additionalitem-search') !== null)
{
	window.axios = require('axios');
	window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	window.ajax = axios.create({
		baseURL: '/wp-json/wp/v2/'
	});

	const additionalitem_search = new Vue({
		el: '#additionalitem-search'
		, render(h) {
			return h(AdditionalItemSearch);
		}
	});
}