<template>

	<div class="wrapper-small">	

		<case-studies-search-form :params="params" :loading="loading" @search="search" @clear="clear"></case-studies-search-form>
		
		<section class="panel content content__generic-results">

			<div class="container">

				<div id="job-results">

					<case-studies-search-results :news="news"></case-studies-search-results>

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
import CaseStudiesSearchForm from './CaseStudiesSearchForm.vue';
import CaseStudiesSearchResults from './CaseStudiesSearchResults.vue';
import Pagination from './Pagination.vue';

export default {
	components: {
		CaseStudiesSearchForm
		, CaseStudiesSearchResults
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

		if (sessionStorage.getItem('params-case-studies')) {
			params = JSON.parse(sessionStorage.getItem('params-case-studies'));
		}

		this.params = {...this.default_params, ...params};

		

		this.search();
	}
	, methods: {
		search(params) {
			
		
			if (this.params.selected_news_categories!=0) {
				this.params.nsm_cs_categories = this.params.selected_news_categories;
			} else {
				delete this.params.nsm_cs_categories;
			}
			

			if (params !== undefined) {
				// Merge params from search form to app params.
				this.params = {...this.params, ...params};
				this.params.page = 1;
				sessionStorage.setItem('params-case-studies', JSON.stringify(this.params));
				this.params = {...this.default_params, ...params};
			}


			this.loading = true;
			ajax.get('nsm_case_study_post', {
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
			sessionStorage.removeItem('params-case-studies');
			this.params = {...this.default_params};
			this.search();
		}
		, paginationCallback(page_number) {
			this.params.page = page_number;
			sessionStorage.setItem('params-case-studies', JSON.stringify(this.params));
			this.search();

			// Jump to search results.
			// let top = document.getElementById('job-results').offsetTop;
			// window.scrollTo(0, top);
		}
		
	}
}
</script>