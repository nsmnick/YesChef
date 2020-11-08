<template>


		<div>

		
		<section class="panel content content__job-results small-top">

			<div class="container">

				<div id="job-results">
					<additionalitem-search-results :additionalitems="additionalitems" @showModalx="showModalx"></additionalitem-search-results>
				</div>

			</div>

		</section>


		<div id="additionalitem-modalxx">
			<div class="modal" v-if="show" @click="hideModal">
				<div class="modal__container" @click.stop>
					<a class="modal__close" href="#" @click.prevent="hideModal"></a>

					<div class="modal__wrapper">
						<div class="modal__additionalitem">
							
							<h3 class="modal__additionalitem__title">{{ title }}</h3>

						</div>

						<div class="modal__bio" v-html="content"></div>
					</div>

				</div>
			</div>
		</div>
		

	</div>


			



</template>

<script>
import AdditionalitemSearchResults from './AdditionalitemSearchResults.vue';


export default {
	components: {
		AdditionalitemSearchResults
	}
	, data() {
		return {
			additionalitems: []
			, default_params: {
				page: 1
				, per_page: 50
			}
			, params: {
				page: 1
				, per_page: 50
			}
			, total: 0
			, total_pages: 0
			, loading: false
			, show: false
			, title: ''
			, content: ''
		}
	}
	, computed: {
		// mealCount() {
		// 	return `${this.total} meal${this.total != 1? 's' : ''} found`;
		// }
	}
	, mounted() {
		let params = {};

		if (sessionStorage.getItem('params-additionalitem')) {
			params = JSON.parse(sessionStorage.getItem('params-additionalitem'));
		}

		this.params = {...this.default_params, ...params};

		

		this.search();
	}

	, methods: {
		search(params) {
			

			this.params.orderby = 'menu_order';
			this.params.order = 'asc';

			if (params !== undefined) {
				// Merge params from search form to app params.
				this.params = {...this.params, ...params};
				this.params.page = 1;
				sessionStorage.setItem('params-additionalitem', JSON.stringify(this.params));
				this.params = {...this.default_params, ...params};
			}


			this.loading = true;
			ajax.get('nsm_additional_items', {
				params: this.params
			})
			.then(response => {
				this.additionalitems = response.data;
				this.total = parseInt(response.headers['x-wp-total']);
				this.total_pages = parseInt(response.headers['x-wp-totalpages']);
				this.loading = false;

			

			});
		},
		showModalx(title,content)
		{
		//	console.log('parent yes');
			this.title = title;
			this.content = content;
			document.body.style.overflow = 'hidden';
			this.show = true;
		},
		hideModal()
		{
			document.body.style.overflow = 'auto';
			this.show = false;
		}

		
	}
}
</script>