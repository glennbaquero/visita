<template>
	<div>
		<div class="inlineBlock-parent align-l m-margin-b">
			<div class="rqst-frm1__step-3-content-col" v-for="(guest, key) in stepData.guests">
				<p class="frm-header s-margin-b">Guest {{ renderKey(key) }}:</p>
				<div class="rqst-frm1__step-3-content-card">
					<div class="width--90 margin-a inlineBlock-parent">
						<div class="width--40 inlineBlock-parent">
							<img 
							  	class="rqst-frm1__step-3-content-card-edit-btn" 
							  	src="images/edit-button.png"
							  	@click="$emit('openGuestForm', key)"
							>
							<p class="frm-header bold clr--light-gray">|</p>
							<img 
							  	class="rqst-frm1__step-3-content-card-remove-btn" 
							  	src="images/remove-button.png"
							  	@click="$emit('removeGuest', key)"
							>
						</div
						><div class="width--60">
							<p class="frm-header bold clr--green">
								{{ guestLabel(guest) }} 
							</p>
						</div>
					</div>
				</div>
			</div
			>
		</div>
	</div>
</template>
<script>
	export default{
		props: {
			stepData: Object,
		},

		mounted() {
			this.setupGuest();
		},

		methods: {
			setupGuest() {
				if(this.$parent.destination.agencyAvailableSeat) {
					if(this.stepData.numberOfGuests > this.$parent.destination.agencyAvailableSeat) {
						this.stepData.numberOfGuests = 0;
						this.stepData.guests = [];
					}
				}
			},

			guestLabel(guest) {
				var name = 'Register Guest';

				if(guest.first_name != null && guest.last_name != null) {
					name = guest.first_name + ' ' + guest.last_name;
				}  

				return name;
			},

			renderKey(key) {
				return key+1;
			}
		}
	}
</script>