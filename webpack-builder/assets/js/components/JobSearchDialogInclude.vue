<template>

	<div class="wrapper-small">	
		<job-search-form :params="params" :loading="loading" @search="search" @clear="clear"></job-search-form>
	</div>

</template>

<script>
import JobSearchForm from './JobSearchForm.vue';

export default {
	components: {
		JobSearchForm
	}
	, data() {
		return {
			default_params: {
				selected_nsm_job_locations: 0
				, selected_nsm_job_types: 0
				, selected_nsm_job_functions: 0
			}
			, params: {
				page: 1
				, per_page: 5
			}
		}
	}
	, mounted() {
		let params = {};

		if (sessionStorage.getItem('params-jobs')) {
			params = JSON.parse(sessionStorage.getItem('params-jobs'));
		}

		this.params = {...this.default_params, ...params};
	}
	, methods: {
		search(params) {
			
		
			if (this.params.selected_nsm_locations!=0) {
				this.params.nsm_locations = this.params.selected_nsm_locations;
			} else {
				delete this.params.nsm_locations;
			}

			if (this.params.selected_nsm_job_functions!=0) {
				this.params.nsm_job_functions = this.params.selected_nsm_job_functions;
			} else {
				delete this.params.nsm_job_functions;
			}

			if (this.params.selected_nsm_job_types!=0) {
				this.params.nsm_job_types = this.params.selected_nsm_job_types;
			} else {
				delete this.params.nsm_job_types;
			}
			

			if (params !== undefined) {
				// Merge params from search form to app params.
				this.params = {...this.params, ...params};
				this.params.page = 1;
				sessionStorage.setItem('params-jobs', JSON.stringify(this.params));
				this.params = {...this.default_params, ...params};
			}

			
			sessionStorage.removeItem('params-jobs');
			sessionStorage.setItem('params-jobs', JSON.stringify(this.params));
			window.location.href = "/search-jobs/";

		}
		, clear() {
			sessionStorage.removeItem('params-jobs');
			this.params = {...this.default_params};
			window.location.href = "/search-jobs/";
		}
		
	}
}
</script>