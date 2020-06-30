<template>
	<div>
		<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
			<div class="width--100 pointer-events-none">
				<div class="align-l m-margin-b">
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
			<div class="width--100 pointer-events-none">
				<div class="align-l m-margin-b">
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
									<p class="frm-header clr--gray">{{ toDate(stepData.main.birthdate, 'MMMM D, YYYY') }}</p>
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
			<div class="width--100 pointer-events-none">
				<div class="align-l">
					<h5 class="frm-title x-small clr--gray">Guest Details</h5>
					<hr>

					<div class="m-margin-b" v-for="(guest, key) in stepData.guests">
						<p class="frm-header bold clr--green">Guest {{ key+1 }}:</p>
						<div class="inlineBlock-parent">
							<div class="width--50 align-t">
								<div class="width--95">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Name:</p>
										<p class="frm-header clr--gray">{{ guest.first_name }} {{ guest.last_name }}</p>
									</div>
								</div>
							</div
							><div class="width--50 align-t">
								<div class="width--95 margin-l-a">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Email:</p>
										<p class="frm-header clr--gray">{{ guest.email }}</p>
									</div>
								</div>
							</div>
						</div>

						<div class="inlineBlock-parent">
							<div class="width--50 align-t">
								<div class="width--95">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Nationality:</p>
										<p class="frm-header clr--gray">{{ guest.nationality }}</p>
									</div>
								</div>
							</div
							><div class="width--50 align-t">
								<div class="width--95 margin-l-a">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Birthdate:</p>
										<p class="frm-header clr--gray">{{ toDate(guest.birthdate, 'MMMM D, YYYY') }}</p>
									</div>
								</div>
							</div>
						</div>

						<div class="inlineBlock-parent">
							<div class="width--50 align-t">
								<div class="width--95">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Contact No.:</p>
										<p class="frm-header clr--gray">+63{{ guest.contact_number }}</p>
									</div>
								</div>
							</div
							><div class="width--50 align-t">
								<div class="width--95 margin-l-a">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Emergency No.:</p>
										<p class="frm-header clr--gray">+63{{ guest.emergency_contact_number }}</p>
									</div>
								</div>
							</div>
						</div>

						<div class="inlineBlock-parent">
							<div class="width--50 align-t">
								<div class="width--95">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Gender:</p>
										<p class="frm-header clr--gray">{{ guest.gender }}</p>
									</div>
								</div>
							</div
							><div class="width--50 align-t">
								<div class="width--95 margin-l-a">
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Visitor Type:</p>
										<p class="frm-header clr--gray">
											{{ renderGuestVisitorType(guest.visitor_type_id) }}
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
											{{ renderGuestSpecialFee(guest.special_fee_id) }}
										</p>
									</div>
								</div>
							</div
							><div class="width--50 align-t">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import DateMixin from 'Mixins/date.js';
 
	export default {
		props: {
			stepData: Object,
			allocation: Object,
			visitorTypes: Array,
			isAccepted: Object
		},

		mixins: [ DateMixin ],

		computed: {
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

		methods: {
			renderGuestVisitorType(id) {
				var result = null;
				
				if(id === 0) return '--';

				_.forEach(this.visitorTypes, (value) => {
			    	if(value.id == id){
			      		result = value;
			    	}
			  	});

			  	return result.name;
			},

			renderGuestSpecialFee(id) {
				var result = null;

				if(id === 0) return '--';
				
				_.forEach(this.allocation.special_fees, (value) => {
			    	if(value.id == id){
			      		result = value;
			    	}
			  	});

			  	return result.name;
			}
		}
	}
</script>