<template>


		<div>

		<meal-search-form :params="params" :loading="loading" @search="search" @clear="clear"></meal-search-form>
		
		<section class="panel content content__job-results small-top">

			<div class="container">

				

				<div id="job-results">

					<meal-search-results :meals="meals"></meal-search-results>

					
				</div>

			</div>

		</section>

		</div>


</template>

<script>
import MealSearchForm from './MealSearchForm.vue';
import MealSearchResults from './MealSearchResults.vue';
import Pagination from './Pagination.vue';
//import config from '../configs/job-search-form-config.json';

export default {
	components: {
		MealSearchForm
		, MealSearchResults
		, Pagination
	}
	, props: {
		order_date: {
			type: String
			, default: ''
		}
	}
	, data() {
		return {
			meals: []
			, default_params: {
				page: 1
				, per_page: 50
				, selected_nsm_meal_skill_level: 0
				, selected_nsm_meal_type: 0
				, selected_nsm_meal_food_type: 0
				, selected_nsm_meal_calories: 0
			}
			, params: {
				page: 1
				, per_page: 50
			}
			, total: 0
			, total_pages: 0
			, loading: false
		}
	}
	, computed: {
		// mealCount() {
		// 	return `${this.total} meal${this.total != 1? 's' : ''} found`;
		// }
	}
	, mounted() {
		let params = {};

		if (sessionStorage.getItem('params-meals')) {
			params = JSON.parse(sessionStorage.getItem('params-meals'));
		}

		this.params = {...this.default_params, ...params};

		

		this.search();
	}
	, methods: {
		search(params) {
			
		
			if (this.params.selected_nsm_meal_skill_level!=0) {
				this.params.nsm_meal_skill_level = this.params.selected_nsm_meal_skill_level;
			} else {
				delete this.params.nsm_meal_skill_level;
			}

			if (this.params.selected_nsm_meal_food_type!=0) {
				this.params.nsm_meal_food_type = this.params.selected_nsm_meal_food_type;
			} else {
				delete this.params.nsm_meal_food_type;
			}

			if (this.params.selected_nsm_meal_type!=0) {
				this.params.nsm_meal_type = this.params.selected_nsm_meal_type;
			} else {
				delete this.params.nsm_meal_type;
			}

			if (this.params.selected_nsm_meal_calories!=0) {
				this.params.nsm_meal_calories = this.params.selected_nsm_meal_calories;
			} else {
				delete this.params.nsm_meal_calories;
			}
			

			if (params !== undefined) {
				// Merge params from search form to app params.
				this.params = {...this.params, ...params};
				this.params.page = 1;
				sessionStorage.setItem('params-meals', JSON.stringify(this.params));
				this.params = {...this.default_params, ...params};
			}


			this.loading = true;
			ajax.get('nsm_meals', {
				params: this.params
			})
			.then(response => {
				this.meals = response.data;
				this.total = parseInt(response.headers['x-wp-total']);
				this.total_pages = parseInt(response.headers['x-wp-totalpages']);
				this.loading = false;
			});
		}
		, clear() {
			sessionStorage.removeItem('params-meals');
			this.params = {...this.default_params};
			this.search();
		}
		, paginationCallback(page_number) {
			this.params.page = page_number;
			sessionStorage.setItem('params-meals', JSON.stringify(this.params));
			this.search();

			// Jump to search results.
			// let top = document.getElementById('job-results').offsetTop;
			// window.scrollTo(0, top);
		}
		
	}
}
</script>