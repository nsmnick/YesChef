<template>
	
	<transition-group
		name="stagged-fade"
		tag="div"
		class="search-results__list"
		@before-enter="beforeEnter"
		@enter="enter"
		@leave="leave"
	>

		<div class="search-dialog__loader"
			:class="{'search-button-spinner': loading}"
			:disabled="loading"
		></div>

		<article class="search-results__list__result"
			v-for="(meal, index) in this.meals"
			:key="meal.id"
			:data-index="index"
		>	

		<div class="meal-panel">

	        <div class="meal-panel__image">
	 			<img v-bind:src="meal.featured_image">
	 		</div>

		 		<div class="meal-panel__stats">
					
					<div class="meal-panel__stats__col">
						

						<div class="stat-container">

							<div class="stat-container__col1">
								<img v-if="meal.skill_level=='Easy'" src="/wp-content/themes/yeschef/assets/images/icon_skill_easy.svg">
								<img v-else-if="meal.skill_level=='Medium'" src="/wp-content/themes/yeschef/assets/images/icon_skill_medium.svg">
								<img v-else-if="meal.skill_level=='Hard'" src="/wp-content/themes/yeschef/assets/images/icon_skill_hard.svg">
							</div>

							<div class="stat-container__col2 stat-container__col2--border">
								
								<div class="stat-info-container">

									<div class="stat-info-container__col1">
										EFFORT
									</div>

									<div class="stat-info-container__col2">
										{{meal.skill_level}}
									</div>

								</div>
							</div>

						</div>


					</div>

					<div class="meal-panel__stats__col">
						
						<div class="stat-container">
							<div class="stat-container__col1">
								<img src="/wp-content/themes/yeschef/assets/images/icon_prep.svg">
							</div>

							<div class="stat-container__col2 stat-container__col2--border">
								
								<div class="stat-info-container">

									<div class="stat-info-container__col1">
										PREP TIME
									</div>

									<div class="stat-info-container__col2">
										{{meal.prep_time}} MINS
									</div>

								</div>
							</div>
						</div>

					</div>

					<div class="meal-panel__stats__col">
						
						<div class="stat-container">
							<div class="stat-container__col1">
									<img src="/wp-content/themes/yeschef/assets/images/icon_cook.svg">
							</div>

							<div class="stat-container__col2">
								
								<div class="stat-info-container">

									<div class="stat-info-container__col1">
										COOK TIME
									</div>

									<div class="stat-info-container__col2">
										{{meal.cook_time}} MINS
									</div>

								</div>
							</div>
						</div>

					</div>


				</div>

		 		<div class="meal-panel__content">
		 			<h2 v-html="meal.title.rendered"></h2>
					<p class="summary">{{meal.summary}}</p>
				</div>

				

				<div class="meal-panel__cta">
					<a :href="meal.link" class="button button--view-details">
					View Details
					</a>
				</div>


			</div>


		

        </article>

	</transition-group>

</template>



<script>
	export default {
		props: {
			meals: Array
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
			getmeals() {
				let meals = [...this.meals];
				return meals;
			}
		}
		, methods: {
			
			beforeEnter(el) {
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