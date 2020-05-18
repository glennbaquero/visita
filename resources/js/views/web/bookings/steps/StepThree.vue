<template>
	<div>
		<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
			<div class="width--100">
				<div class="align-l m-margin-b">
					<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
					<hr>
					<div class="inlineBlock-parent">
						<p class="frm-header bold clr--gray">Date:</p>
						<p class="frm-header clr--gray">{{ toDate(stepData.visitDate, 'MMMM D, YYYY') }}</p>
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
			<div class="width--100">
				<div class="align-l">
					<h5 class="frm-title x-small clr--gray">Contact Person</h5>
					<hr>

					<div class="inlineBlock-parent">
						<div class="width--50 align-t">
							<div class="width--95">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Name:</p>
									<p class="frm-header clr--gray">{{ stepData.main.first_name }} {{ stepData.main.last_name }}</p>
								</div>
							</div>
						</div
						><div class="width--50 align-t">
							<div class="width--95 margin-l-a">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Email:</p>
									<p class="frm-header clr--gray">{{ stepData.main.email }}</p>
								</div>
							</div>
						</div>
					</div>

					<div class="inlineBlock-parent">
						<div class="width--50 align-t">
							<div class="width--95">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Nationality:</p>
									<p class="frm-header clr--gray">{{ stepData.main.nationality }}</p>
								</div>
							</div>
						</div
						><div class="width--50 align-t">
							<div class="width--95 margin-l-a">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Birthdate:</p>
									<p class="frm-header clr--gray"> {{ toDate(stepData.main.birthdate, 'MMMM D, YYYY') }} </p>
								</div>
							</div>
						</div>
					</div>

					<div class="inlineBlock-parent">
						<div class="width--50 align-t">
							<div class="width--95">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Contact No.:</p>
									<p class="frm-header clr--gray">+63{{ stepData.main.contact_number }}</p>
								</div>
							</div>
						</div
						><div class="width--50 align-t">
							<div class="width--95 margin-l-a">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Emergency No.:</p>
									<p class="frm-header clr--gray">+63{{ stepData.main.emergency_contact_number }}</p>
								</div>
							</div>
						</div>
					</div>

					<div class="inlineBlock-parent">
						<div class="width--50 align-t">
							<div class="width--95">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Gender:</p>
									<p class="frm-header clr--gray">{{ stepData.main.gender }}</p>
								</div>
							</div>
						</div
						><div class="width--50 align-t">
							<div class="width--95 margin-l-a">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Visitor Type:</p>
									<p class="frm-header clr--gray">
										{{ stepData.main.visitor_type_id != 0 ? visitorType.name : '--' }}
									</p>
								</div>
							</div>
						</div>
					</div>

					<div class="inlineBlock-parent">
						<div class="width--50 align-t">
							<div class="width--95">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Special Fees:</p>
									<p class="frm-header clr--gray">
										{{ stepData.main.special_fee_id != 0 ? specialFee.name : '--' }}
									</p>
								</div>
							</div>
						</div
						><div class="width--50 align-t">
							<div class="width--95 margin-l-a">
								<div class="inlineBlock-parent">
									<p class="frm-header bold clr--gray">Agency Code:</p>
									<p class="frm-header clr--gray">
										{{ stepData.main.agency_code ? stepData.main.agency_code : '--' }}
									</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<hr>
		<div class="inlineBlock-parent">
			<div class="width--45">
				<div class="width--95">
					<button 
					  class="frm-btn gray"
					  @click="$emit('returnStep2')"
					>Back</button>
				</div>
			</div
			><div class="width--45">
				<div class="width--95" v-if="showNextButton">
					<button 
					  class="frm-btn green"
					  @click="$emit('showStep4')"
					>Next</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import DateMixin from 'Mixins/date.js';
	import { EventBus } from 'Root/EventBus.js';

	export default {
		props: {
			stepData: Object,
			allocation: Object,
			visitorTypes: Array,
		},

		data() {
			return {
				showNextButton: false,
			}
		},

		mixins: [ DateMixin ],

		computed: {

			guests() {
				return this.stepData.guests;
			},

			specialFee() {
				var result = null;
				_.forEach(this.allocation.special_fees, (value) => {
			    	if(value.id == this.stepData.main.special_fee_id){
			      		result = value;
			    	}
			  	});

			  	return result;
			},

			visitorType() {
				var result = null;
				_.forEach(this.visitorTypes, (value) => {
			    	if(value.id == this.stepData.main.visitor_type_id){
			      		result = value;
			    	}
			  	});

			  	return result;
			},
		},

		mounted() {
			EventBus.$emit('changed');
		},

		created() {
			EventBus.$on('guest_form_opened', () => {
				this.showNextButton = false;
			});

			EventBus.$on('changed', () => {
				this.$nextTick(() => {
					var guests = this.guests;
					for(var i = 0; i < guests.length; i++) {
						if(guests[i].first_name != null) {		
					       	if(guests[i].special_fee_id != '0' || guests[i].spespecial_fee_id != 0) {
					         	if(guests[i].paths != null || guests[i].paths.length) {
							     	this.showNextButton = true;
					        	} else {
							     	this.showNextButton = false;
					         	}
					       	} else {
							 	this.showNextButton = true;
					       	}
						} else {
							this.showNextButton = false;
						}
					}
				}, 200)
				
			})

			EventBus.$on('guestRemoved', () => {
				this.$nextTick(() => {
					var guests = this.guests;
					for(var i = 0; i < guests.length; i++) {
						if(guests[i].first_name != null) {
							this.showNextButton = true;
						} else {
							this.showNextButton = false;
						}
					}
				}, 200)
			});
		}
	}
</script>