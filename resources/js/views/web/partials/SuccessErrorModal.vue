<template>
	<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="success-modal">
		<div class="width--90 margin-a">
			<img 
			  class="gnrl-rmdl__img-icon"
			  :src="icon" 
			>
			<div class="frm-description no-height clr--gray m-margin-b">
				<p v-html="message"></p>
			</div>
			<button class="frm-btn green" @click="close">Close</button>
		</div>
	</div>
</template>
<script>
	export default {
		props: {
			message: String,
			icon: {
				default: 'images/success-icon.png',
				type: String
			}
		},

		methods: {
			close() {
				var showSuccessModal = $('[data-remodal-id=success-modal]').remodal();
    			showSuccessModal.close();
			}
		}
	}
</script>