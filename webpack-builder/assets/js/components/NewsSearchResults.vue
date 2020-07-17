<template>
	<transition-group
		name="stagged-fade"
		tag="div"
		class="generic-results__list"
		@before-enter="beforeEnter"
		@enter="enter"
		@leave="leave"
	>

		<article class="generic-results__list__article"
			v-for="(news, index) in this.news"
			:key="news.id"
			:data-index="index"
		>	

			<div class="generic-results__list__article__category">{{news.categories}}</div>

		 	<a class="generic-results__list__article__image"  :href="news.link" :style="{ backgroundImage: news.image }">
					</a> 

			<div class="generic-results__list__article__content">
				<a :href="news.link">
					<h3 class="generic-results__list__article__title" v-html="news.title.rendered"></h3>
				</a> 
				<p class="generic-results__list__article__date">{{ news.published_date }}</p>
				<div class="generic-results__list__article__excerpt" v-html="news.excerpt.rendered"></div>

				<a class="button button--yellow fit-content center" :href="news.link">Read more</a>
			</div>


        </article>

	</transition-group>
</template>

<script>
export default {
	props: {
		news: Array
	}
	, data() {
		return {
			stagger_delay: 50
		}
	}
	, computed: {
		getnews() {
			let news = [...this.news];
			return news;
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