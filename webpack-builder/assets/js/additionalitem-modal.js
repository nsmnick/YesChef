
import Vue from 'vue';
import App from './components/AdditionalitemModal.vue';


if (document.getElementById('additionalitem-modal') !== null)
{

	const app = new Vue({
		el: '#additionalitem-modal'
		, render(h) {
			let data = {};

			if (document.getElementById('additionalitem-json') !== null) {

				data = JSON.parse(document.getElementById('additionalitem-json').innerHTML);
				//console.log(data);

			}

			return h(App, {
				props: {
					'data': data
				}
			});
		}
	});
}
