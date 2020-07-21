<template>
	
	<transition-group
		name="stagged-fade"
		tag="div"
		class="search-results__list"
		@before-enter="beforeEnter"
		@enter="enter"
		@leave="leave"
	>



		<article class="search-results__list__result"
			v-for="(additionalitem, index) in this.additionalitems"
			:key="additionalitem.id"
			:data-index="index"
		>	

		<div class="meal-panel">

	        <div class="meal-panel__image with-margin">
	 			<img v-bind:src="additionalitem.featured_image">
	 		</div>

		 		
		 		<div class="meal-panel__content">
		 			<h2 v-html="additionalitem.title.rendered"></h2>
					<p class="price">{{additionalitem.price}}</p>

				</div>

			

				<div class="meal-panel__cta">
					<a href="#" :data-id="additionalitem.id" class="button button--view-details" @click="callmodal($event,additionalitem.title.rendered,additionalitem.content.rendered)">
					View Details
					</a>
				</div>


			</div>


		

        </article>


       


        


	</transition-group>




	

</template>



<script>
	import AdditionalitemModal from './AdditionalitemModal.vue';

	export default {
		components: {
			AdditionalitemModal	
		}
		,props: {
			additionalitems: Array
		}
		, loading: {
			type: Boolean
			, default: false
		}
		, data() {
			return {
				stagger_delay: 50
			}
		}
		, computed: {
			getAdditionalitems() {
				let additionalitems = [...this.additionalitems];
				return additionalitems;
			}
		}

		, methods: {
			callmodal(event,title,content) {
			//	console.log(title);

				this.$emit('showModalx', title, content);
			//	console.log('yes');
				event.preventDefault();
			}
			, beforeEnter(el) {
				el.style.opacity = 0;
			}
			, enter(el) {
				let delay = el.dataset.index * this.stagger_delay;
				setTimeout(() => {
					el.style.opacity = 1;
				}, delay);
			}
			, leave(el) {
				el.style.display = 'none';
			
			}
		}
	}
</script>