import Vue from 'vue';
import JobSearch from './components/JobSearchDialogInclude.vue';

console.log('here1');
if (document.getElementById('jobs-search-dialog-include') !== null)
{
	console.log('here2');
	window.axios = require('axios');
	window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	window.ajax = axios.create({
		baseURL: '/wp-json/wp/v2/'
	});

	const job_search = new Vue({
		el: '#jobs-search-dialog-include'
		, render(h) {
			return h(JobSearch);
		}
	});
}