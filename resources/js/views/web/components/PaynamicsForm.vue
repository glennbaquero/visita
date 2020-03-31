<template>
	<form ref="form" :action="url" method="POST" name="form1">
	    <input type="hidden" name="paymentrequest" :value="signature">
	</form>
</template>

<script>
export default {
	methods: {
		submit() {
			setTimeout(() => {
				this.$refs.form.submit();
			}, 500);
		},

		setVars(url, signature) {
			this.url = url;
			this.signature = signature;
		},
	},

	data() {
		return {
			url: null,
			signature: null,
		}
	},
}
</script>