import Vue from 'vue';
import MealSearch from './components/MealSearch.vue';

if (document.getElementById('meal-search') !== null)
{
	window.axios = require('axios');
	window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	window.ajax = axios.create({
		baseURL: '/wp-json/wp/v2/'
	});

	const meal_search = new Vue({
		el: '#meal-search'
		, render(h) {
			return h(MealSearch);
		}
	});
}