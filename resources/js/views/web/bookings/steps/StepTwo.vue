<template>
	<div>
		<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
			<div class="align-l">
				<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
				<hr>
				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray">Date:</p>
					<p class="frm-header clr--gray">{{ toDate(stepData.visitDate) }}</p>
				</div>
				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray">Experience:</p>
					<p class="frm-header clr--gray">{{ allocation.allocation_name }}</p>
				</div>
				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray">No. of guests:</p>
					<p class="frm-header clr--gray">{{ stepData.numberOfGuests }}</p>
				</div>
				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray">Time:</p>
					<p class="frm-header clr--gray">{{ toTime(stepData.timeSelected, 'hh:mm A') }}</p>
				</div>
			</div>
		</div>
		<hr>
		<div class="inlineBlock-parent">
			<div class="width--45">
				<div class="width--95">
					<button
					  	class="frm-btn gray"
					  	@click="$emit('returnStep1')"
					>Back</button>
				</div>
			</div
			><div class="width--45">
				<div class="width--95">
					<button 
						v-if="detailsComplete"
					  	class="frm-btn green"
					  	@click="$emit('showStep3')"
					>Next</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import DateMixin from 'Mixins/date.js';
	import {EventBus} from 'Root/EventBus.js';
	
	export default {
		props: {
			stepData: Object,
			items: Array,
			allocation: Object
		},

		data() {
			return {
				reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
				hasFile: false,
			}
		},

		mixins: [ DateMixin ],

		computed: {
			detailsComplete() {
				if(this.stepData.main.first_name != '' && this.stepData.main.gender != '' && 
					this.stepData.main.nationality != '' && this.stepData.main.last_name != '' && 
					this.stepData.main.email != '' && this.stepData.main.birthdate != '' && 
					this.stepData.main.contact_number != '' && this.stepData.main.emergency_contact_number != '' &&
					this.stepData.main.visitor_type_id != 0 && this.reg.test(this.stepData.main.email) && 
					this.stepData.main.emergency_contact_number.length === 10 && this.stepData.main.contact_number.length === 10) {

					// if(this.stepData.main.special_fee_id > 0 && _.isEmpty(this.stepData.main.paths)) {
					// 	return false;
					// }
					if(this.stepData.main.special_fee_id != 0) {
						if(this.hasFile) {
							return true
						} else {
							return false
						}
					}
					return true;
				}

				return false;
			},
		},

		created() {
			EventBus.$on('hasFile', (data) => {
				this.hasFile = data;
			});
		},

		methods: {
			// isEmailValid() {
		 //      	return (this.stepData.main.email == "")? "" : (this.reg.test(this.stepData.main.email)) ? 'has-success' : 'has-error';
		 //    }
		}
	}
</script>