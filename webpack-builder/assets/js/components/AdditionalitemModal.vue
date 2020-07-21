<template>
	<transition name="modal">
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
	</transition>
</template>

<script>
export default {
	props: {
		data: Object
	}
	, data() {
		return {
			title: ''
			, content: ''
			, show: false
		}
	}
	, mounted() {
		let links = document.querySelectorAll('.additionalitem__link');

		console.log(links);

		for (const link of links) {
			link.addEventListener('click', (e) => {
				e.preventDefault();
				this.showModal(e.target.dataset.id);
			});
		}
	}
	, methods: {

	    showModal(id) {
	    	
	    	console.log('here');

			let bio = this.data[id];
			this.content = bio.content;
			this.title = bio.title;
			this.show = true;

			// Prevent background scrolling
			document.body.style.overflow = 'hidden';
		}
		, hideModal() {
			this.show = false;
			document.body.style.overflow = 'auto';
		}
      
		
	}
}
</script>