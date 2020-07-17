<template>
	

	<div class="panel content content__generic-search">

		<div class="container">

			<div class="generic-dialog">


	        		<div class="generic-dialog__group generic-dialog__group__keywords">
	        			
	        			
			             <input type="text" 
		                	id="s"
		                	class="generic-dialog__group__input"
							name="search"
							v-model="params.search"
						>
						<label class="generic-dialog__group__label" for="search">Keywords</label>

	        		</div>

	        		<div class="generic-dialog__group generic-dialog__group__select">
	        			
			            <select id="category" name="category" class="search-dialog__group__select" v-model="params.selected_news_categories">
							<option value="0">All Categories</option>
							<option v-for="category in categories" :key="category.id" :value="category.id"><span v-if="category.parent">&nbsp;&nbsp;&nbsp;&nbsp;</span>{{ category.name }}</option>
						</select>

	

	        		</div>

	        		<div class="generic-dialog__group generic-dialog__group__button generic-dialog__group__button--search">

	        			<button class="generic-dialog__group__search-button"
							:class="{'search-button-spinner': loading}"
							:disabled="loading"
							@click="search"
						>Search news</button>

	        		</div>


	        		

	        		<div class="generic-dialog__group generic-dialog__group__button generic-dialog__group__button--clear">
	        			<button type="reset" class="generic-dialog__group__clear-button" @click="clear">Reset form</button>
	        		</div>

	        		

	        	</div>


	    </div>

	</div>



</template>

<script>

export default {
	props: {
		params: {
			type: Object
			, default: {}
		}
		, loading: {
			type: Boolean
			, default: false
		}
	}
	, data() {
		return {
			categories: []
		}
	}
	, mounted() {
		this.getCategories();
	}
	, methods: {
		search() {
			this.$emit('search', this.params);
		}
		, clear() {
			this.$emit('clear');
		}
		, getCategories() {

			ajax.get('categories', {
				params: { orderby: 'term_group',  hide_empty: 1 },
			}).then(response => {
					this.categories = response.data;
				});
		}
	}
}
</script>