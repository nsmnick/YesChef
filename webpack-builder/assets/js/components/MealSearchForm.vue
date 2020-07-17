<template>
	

	<div class="panel content content__panel no-bottom small-top">

		<div class="container">
	            

	        	<div class="search-dialog">


	        		
	        		<div class="search-dialog__group">
	        			<label class="search-dialog__group__label" for="skill_level">Skill Level</label>
			            <select id="skill_level" name="skill_level" class="search-dialog__group__select" v-model="params.selected_nsm_meal_skill_level" @change="search">
							<option value="0">All Skill Levels</option>
							<option v-for="skill_level in meal_skill_level" :key="skill_level.id" :value="skill_level.id"><span v-if="skill_level.parent">&nbsp;&nbsp;&nbsp;&nbsp;</span>{{ skill_level.name }}</option>
						</select>

	        		</div>

	        		

	        		<div class="search-dialog__group">

	        			<label class="search-dialog__group__label" for="meal_type">Meal Type</label>

	                    <select id="meal_type" name="meal_type" class="search-dialog__group__select" v-model="params.selected_nsm_meal_type" @change="search">
							<option value="0">All Meal Types</option>
							<option v-for="meal_type in meal_type" :key="meal_type.id" :value="meal_type.id">{{ meal_type.name }}</option>
						</select>

	        		</div>


	        		<div class="search-dialog__group">
	        			
	        			<label class="search-dialog__group__label" for="food_type">Food Type</label>
	                    <select id="food_type" name="food_type" class="search-dialog__group__select" v-model="params.selected_nsm_meal_food_type" @change="search">
							<option value="0">All Food Types</option>
							<option v-for="food_type in meal_food_type" :key="food_type.id" :value="food_type.id">{{ food_type.name }}</option>
						</select>

	

	        		</div>


	        		<div class="search-dialog__group">

	        			<label class="search-dialog__group__label" for="calories">Calories</label>
	                    <select id="calories" name="calories" class="search-dialog__group__select" v-model="params.selected_nsm_meal_calories" @change="search">
							<option value="0">All Calories</option>
							<option v-for="meal_calories in meal_calories" :key="meal_calories.id" :value="meal_calories.id">{{ meal_calories.name }}</option>
						</select>

	        		</div>

	        		


	        	</div>


    			<div class="search-dialog__loader"
					:class="{'search-button-spinner': loading}"
					:disabled="loading"
				></div>



	         
	            
	        <!-- </form> -->
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
			meal_skill_level: []
			,meal_food_type: []
			,meal_type: []
			,meal_calories: []
		}
	}
	, mounted() {
		this.getMealSkillLevels();
		this.getMealFoodTypes();
		this.getMealTypes();
		this.getMealCalories();
	}
	, methods: {
		search() {
			this.$emit('search', this.params);
		}
		, clear() {
			this.$emit('clear');
		}
		, getMealSkillLevels() {

			ajax.get('nsm_meal_skill_level', {
				params: { orderby: 'term_group',  hide_empty: 1 },
			}).then(response => {
					this.meal_skill_level = response.data;
				});
		}
		, getMealFoodTypes() {
			
			ajax.get('nsm_meal_food_type', {
				params: { hide_empty: 1 },
			}).then(response => {
					this.meal_food_type = response.data;
				});
		}
		, getMealTypes() {
			
			ajax.get('nsm_meal_type', {
				params: { hide_empty: 1 },
			}).then(response => {
					this.meal_type = response.data;
				});
		}, getMealCalories() {
			
			ajax.get('nsm_meal_calories', {
				params: { hide_empty: 1 },
			}).then(response => {
					this.meal_calories = response.data;
				});
		}
		
	}
}
</script>