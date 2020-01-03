<template>
	<div>
		<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="remodal" >
			<div class="width--90 margin-a">
				<img :src="icon" class="gnrl-rmdl__img-icon">
				<div class="frm-description no-height clr--gray m-margin-b">
					<p v-html="message"></p>
				</div>
				<button data-remodal-action="close" class="frm-btn" :class="btnColor">{{ btnLabel }}</button>
			</div>
		</div>	
	</div>
</template>
<script>
	export default{
		props: {
			icon: {
				default: 'images/success-icon.png',
				type: String
			},
			message: String,
			btnColor: {
				default: 'green',
				type: String
			},
			btnLabel: {
				default: 'Okay, got it.',
				type: String
			}
		}
	}
</script>