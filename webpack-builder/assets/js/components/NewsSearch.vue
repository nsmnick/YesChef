<template>

	<div class="wrapper-small">	

		<news-search-form :params="params":loading="loading" @search="search" @clear="clear"></news-search-form>
		
		<section class="panel content content__generic-results">

			<div class="container">

				<div id="job-results">

					<news-search-results :news="news":loading="loading" ></news-search-results>

					<div class="job-list__pagination-wrapper">
						<pagination
							v-model="params.page"
							:page-count="total_pages"
							:page-range="3"
							:margin-pages="2"
							:click-handler="paginationCallback"
							:prev-text="''"
							:next-text="''"
							:container-class="'pagination'"
							:page-class="'pagination__item'"
							:next-link-class="'pagination__next'"
							:prev-link-class="'pagination__prev'"
						></pagination>
					</div>
				</div>

			</div>

		</section>


	</div>
</template>

<script>
import NewsSearchForm from './NewsSearchForm.vue';
import NewsSearchResults from './NewsSearchResults.vue';
import Pagination from './Pagination.vue';

export default {
	components: {
		NewsSearchForm
		, NewsSearchResults
		, Pagination
	}
	, data() {
		return {
			news: []
			, default_params: {
				page: 1
				, per_page: 5
				, selected_news_categories: 0
			}
			, params: {
				page: 1
				, per_page: 5
			}
			, total: 0
			, total_pages: 0
			, loading: false
		}
	}
	, mounted() {
		let params = {};

		if (sessionStorage.getItem('params-news')) {
			params = JSON.parse(sessionStorage.getItem('params-news'));
		}

		this.params = {...this.default_params, ...params};

		

		this.search();
	}
	, methods: {
		search(params) {
			
		
			if (this.params.selected_news_categories!=0) {
				this.params.categories = this.params.selected_news_categories;
			} else {
				delete this.params.categories;
			}
			

			if (params !== undefined) {
				// Merge params from search form to app params.
				this.params = {...this.params, ...params};
				this.params.page = 1;
				sessionStorage.setItem('params-news', JSON.stringify(this.params));
				this.params = {...this.default_params, ...params};
			}


			this.loading = true;
			ajax.get('posts', {
				params: this.params
			})
			.then(response => {
				this.news = response.data;
				this.total = parseInt(response.headers['x-wp-total']);
				this.total_pages = parseInt(response.headers['x-wp-totalpages']);
				this.loading = false;
			});
		}
		, clear() {
			sessionStorage.removeItem('params-news');
			this.params = {...this.default_params};
			this.search();
		}
		, paginationCallback(page_number) {
			this.params.page = page_number;
			sessionStorage.setItem('params-news', JSON.stringify(this.params));
			this.search();

			// Jump to search results.
			// let top = document.getElementById('job-results').offsetTop;
			// window.scrollTo(0, top);
		}
		
	}
}
</script>