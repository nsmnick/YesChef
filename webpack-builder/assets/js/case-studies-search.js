import Vue from 'vue';
import NewsSearch from './components/CaseStudiesSearch.vue';

if (document.getElementById('case-studies-search') !== null)
{
	window.axios = require('axios');
	window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	window.ajax = axios.create({
		baseURL: '/wp-json/wp/v2/'
	});

	const news_search = new Vue({
		el: '#case-studies-search'
		, render(h) {
			return h(NewsSearch);
		}
	});
}