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

			let props = {};
		
			if (this.$el.attributes['data-order-date'])
			{
				props.order_date = this.$el.attributes['data-order-date'].value		
				console.log(props.order_date);
			}


			return h(MealSearch, {
				props: props
			});
		}
	});
}