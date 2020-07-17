import Vue from 'vue';
import NewsSearch from './components/NewsSearch.vue';

if (document.getElementById('news-search') !== null)
{
	window.axios = require('axios');
	window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	window.ajax = axios.create({
		baseURL: '/wp-json/wp/v2/'
	});

	const news_search = new Vue({
		el: '#news-search'
		, render(h) {
			return h(NewsSearch);
		}
	});
}