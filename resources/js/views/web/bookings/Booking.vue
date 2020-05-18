<template>
	<div>

	<div class="frm-cntnr align-c width--85">
		<!-- Header -->
		<div class="rqst-frm1__steps-header inlineBlock-parent">
			<div class="rqst-frm1__steps-header-col width--25 align-l align-t">
				<div class="rqst-frm1__breadcrumbs inlineBlock-parent">
					<p>Destinations</p>
					<p>></p>
					<p class="active">Request to visit</p>
				</div>
			</div
			><div class="rqst-frm1__steps-header-col width--50 inlineBlock-parent align-t">
				<div
				  class="rqst-frm1__steps-col"
				  :class="[activeStep1 ? 'active' : '', doneStep1 ? 'done' : '']"
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>1</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Experience & Schedule</h5>
					</div>
				</div
				><div 
				   class="rqst-frm1__steps-col"
				   :class="[activeStep2 ? 'active' : '', doneStep2 ? 'done' : '']"
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>2</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Contact Person</h5>
					</div>
				</div
				><div 
				   class="rqst-frm1__steps-col"
				   :class="[activeStep3 ? 'active' : '', doneStep3 ? 'done' : '']"   
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>3</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Guest Details</h5>
					</div>
				</div
				><div 
				   class="rqst-frm1__steps-col"
				   :class="[activeStep4 ? 'active' : '', doneStep4 ? 'done' : '']"   
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>4</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Review & Pay</h5>
					</div>
				</div
				>
			</div
			><div class="width--25 align-t rqst-frm1__steps-col">
				<img 
				  class="rqst-frm1__steps-header-logo"
				  :src="visitaLogo" 
				>
			</div>
		</div>
		<!--  -->

		<!-- Forms -->
		<div class="rqst-frm1__steps-form">
			<div class="inlineBlock-parent">
				<div class="width--60 align-t">
					<!-- Step 1 -->
					<StepOne v-if="step === 1" :destination="destination"></StepOne>
					<!--  -->
					<!-- Step 2 -->
					<div class="rqst-frm1__step-2" v-if="step === 2">
						<FormStepTwo
							:step-data="stepData"
							:visitor-types="visitorTypes"
							:special-fees="selectedAllocation.special_fees"
							:countries="countries"
							:genders="genders"
						></FormStepTwo>
					</div>
					<!--  -->
					<!-- Step 3 -->
					<div class="rqst-frm1__step-3" v-if="step === 3">
						<div class="rqst-frm1__step-3-content">
							
							<!-- Guest Details Card -->
							<div 
							  class="rqst-frm1__step-3-content-guest-card"
							  :class="guestCard ? 'hide' : ''"
							>
								<div class="align-l m-margin-b">
									<h5 class="frm-title small clr--gray">Guest Details</h5>
								</div>
								<hr>
								<GuestInfo
									v-if="!guestCard"
									:step-data="stepData"
									@openGuestForm="openGuestForm(...arguments)"
									@removeGuest="removeGuest(...arguments)"
								></GuestInfo>
								<div class="rqst-frm1__step-3-content-add-guest-holder inlineBlock-parent align-l">
									<img 
									  	class="rqst-frm1__step-3-content-add-guest-btn" 
									  	src="images/add-button.png" @click="addGuest()">
									<p class="frm-header bold clr--green rqst-frm1__step-3-content-add-guest-btn-label" @click="addGuest()">Add Guest</p>
								</div>
							</div>

							<!-- Guest Details Form -->
							<div 
							  class="rqst-frm1__step-3-content-guest-form align-l m-margin-b"
							  :class="guestForm ? 'show' : ''"
							>
								<template v-for="(guest, key) in stepData.guests">
									<FormStepThree
										v-if="key === guest_key"
										:step-data="guest"
										:main="stepData.main"
										:guest-key="key"
										:visitor-types="visitorTypes"
										:special-fees="selectedAllocation.special_fees"
										:countries="countries"
										:genders="genders"
										@submitGuestDetails="submitGuestDetails(...arguments)"
									></FormStepThree>
								</template>

							</div>

						</div>
					</div>
					<!--  -->
					<!-- Step 4 -->
					<div class="rqst-frm1__step-4 " v-if="step === 4">
						<FormStepFour
							:destination="destination"
							:step-data="stepData"
							:visitor-types="visitorTypes"
							:allocation="selectedAllocation"
							:info="info"
							:is-accepted="isAccepted"
							@terms_conditions_click="termsConditionClick()"
							@privacy_policy_click="privacyPolicyClick()"
							ref="formStepFour"
						></FormStepFour>
					</div>
					<!--  -->
				</div
				><div class="width--40 align-t">
					<div class="width--90 margin-l-a">
						<!-- Step 1 -->
						<FormStepOne 
							v-if="step === 1" 
							:destination="destination" 
							:items="items"
							@showStep2="showStep2()"
							@numberOfGuestsChanged="numberOfGuestsChanged()"
							:step-data="stepData"
							:checker-url="checkerUrl"
						></FormStepOne>
						<!--  -->
						<!-- Step 2 -->
						<div class="rqst-frm1__steps-form-cards" v-if="step === 2">
							<StepTwo
								:step-data="stepData"
								:items="items"
								:allocation="selectedAllocation"
								@returnStep1="returnStep1()"
								@showStep3="showStep3()"
							></StepTwo>
							
						</div>
						<!--  -->
						<!-- Step 3 -->
						<div class="rqst-frm1__steps-form-cards" v-if="step === 3">
							<StepThree
								:allocation="selectedAllocation"
								:step-data="stepData"
								:visitor-types="visitorTypes"
								@returnStep2="returnStep2()"
								@showStep4="showStep4()"
							></StepThree>
						</div>
						<!--  -->
						<!-- Step 4 -->
						<div class="rqst-frm1__steps-form-cards" v-if="step === 4">
							<StepFour
								:step-data="stepData"
								:allocation="selectedAllocation"
								:visitor-types="visitorTypes"
								:is-accepted="isAccepted"
							></StepFour>
							<hr>
							<div class="inlineBlock-parent">
								<div class="width--45">
									<div class="width--95">
										<button 
										  class="frm-btn gray"
										  @click="returnStep3()"
										>Back</button>
									</div>
								</div
								><div class="width--45">
									<div class="width--95" v-if="isAccepted.termsAndConditions && isAccepted.privacyPolicy">
										<button class="frm-btn green" data-remodal-target="confirmation-modal">Send Request</button>
									</div>
								</div>
							</div>
						</div>
						<!--  -->

					</div>
				</div>
			</div>
		</div>
		<!--  -->

		<!-- Modals -->
		<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="confirmation-modal">
			<div class="width--90 margin-a">
				<img 
				  class="gnrl-rmdl__img-icon"
				  :src="questionIcon" 
				>
				<div class="frm-description no-height clr--gray m-margin-b">
					<p>Are you sure the details you provided are correct?</p>
				</div>
				<!-- data-remodal-target="success-modal" -->
				<button class="frm-btn green m-margin-b"  @click="confirmedPayment()">Confirm</button>
				<button class="frm-btn gray" data-remodal-action="close">Cancel</button>
			</div>
		</div>
		<!--  -->

		<!-- Modals -->
		<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="success-modal">
			<div class="width--90 margin-a">
				<img 
				  class="gnrl-rmdl__img-icon"
				  :src="successIcon" 
				>
				<div class="frm-description no-height clr--gray m-margin-b">
					<p>Success! You have submitted your visit request to <strong>{{ destination.name }}</strong>. A confirmation will be sent to your email once your visit is confirmed and approved. You may check your dashboard for the status of your request.</p>
				</div>
				<a href="user/dashboard" class="frm-btn green">Dashboard</a>
			</div>
		</div>
		<!--  -->
	</div>
	
		<loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
	</div>
</template>

<script type="text/javascript">
	import flatpickr from 'flatpickr';
	import 'flatpickr/dist/flatpickr.css';

	import StepOne from './steps/StepOne.vue';
	import StepTwo from './steps/StepTwo.vue';
	import StepThree from './steps/StepThree.vue';
	import StepFour from './steps/StepFour.vue';
	import FormStepOne from './steps/FormStepOne.vue';
	import FormStepTwo from './steps/FormStepTwo.vue';
	import FormStepThree from './steps/FormStepThree.vue';
	import FormStepFour from './steps/FormStepFour.vue';
	import GuestInfo from './steps/GuestInfo.vue';

	import {EventBus} from 'Root/EventBus.js';

	export default {

		props: {
			destination: Object,
			items: Array,
			genders: Array,
			countries: Array,
			visitorTypes: Array,
			bookUrl: String,
			checkerUrl: String,
			info: Object,
		},	

		components: {
			StepOne,
			StepTwo,
			StepThree,
			StepFour,
			FormStepOne,
			FormStepTwo,
			FormStepThree,
			FormStepFour,
			GuestInfo,
	        Loading,
		},

		data() {
			return {
				stepData: {
					allocationSelected: null,
					numberOfGuests: 0,
					timeSelected: null,
					visitDate: null,

					main: {
						special_fee_id: 0,
						visitor_type_id: 0,
						first_name: null,
						gender: null,
						nationality: null,
						last_name: null,
						email: null,
						birthdate: null,
						contact_number: null,
						emergency_contact_number: null,
						main: true,
						agency_code: null,
						paths: [],
					},

					guests: [],
				},

				step: 1,
				activeStep1: true,
				activeStep2: false,
				activeStep3: false,
				activeStep4: false,
				doneStep1: false,
				doneStep2: false,
				doneStep3: false,
				doneStep4: false,
				guestForm: false,
				guestCard: false,
				visitaLogo: 'images/visita-logo.png',	
				infoIcon: 'images/info-icon.png',
				questionIcon: 'images/question-icon.png',
				successIcon: 'images/success-icon.png',
				editButton: 'images/edit-button.png',
				removeButton: 'images/remove-button.png',
				addButton: 'images/add-button.png',
				numberOfGuests: 0,
				guest_key: null,

				isLoading: false,
             	fullPage: true,
             	isAccepted: {
             		termsAndConditions: false,
             		privacyPolicy: false,
             	},
			}
		},

		computed: {
			selectedAllocation() {
				var result = null;
				_.forEach(this.items, (value) => {
			    	if(value.allocation_id == this.stepData.allocationSelected){
			      		result = value;
			    	}
			  	});
			  	return result;
			},
		},

		mounted() {
			var $document = $(document);
			$document.ready(function() {
				var $window = $(window);
			    	$window.scroll(function () {
			        if ($window.scrollTop() > 0) {
			          	$('.rqst-frm1__steps-header, .rqst-frm1__steps-form-cards').addClass('scroll');
			        } else {
			        	$('.rqst-frm1__steps-header, .rqst-frm1__steps-form-cards').removeClass('scroll');
			        }
			    });
			});	
		},

		methods: {
			showStep2() {
				this.step++;
				this.activeStep1 = false;
				this.activeStep2 = true;
				this.doneStep1 = true;
				window.scrollTo(0,0);
			},
			showStep3() {
				this.step++;
				this.activeStep2 = false;
				this.activeStep3 = true;
				this.doneStep2 = true;
				window.scrollTo(0,0);
			},
			showStep4() {
				this.step++;
				this.activeStep3 = false;
				this.activeStep4 = true;
				this.doneStep3 = true;
				window.scrollTo(0,0);
			},
			returnStep1() {
				this.step--;
				this.activeStep1 = true;
				this.activeStep2 = false;
				this.doneStep1 = false;
				window.scrollTo(0,0);
			},
			returnStep2() {
				this.step--;
				this.activeStep2 = true;
				this.activeStep3 = false;
				this.doneStep2 = false;
				window.scrollTo(0,0);
			},
			returnStep3() {
				this.step--;
				this.activeStep3 = true;
				this.activeStep4 = false;
				this.doneStep3 = false;
				window.scrollTo(0,0);
			},
			openGuestForm(key) {
				this.guest_key = key;
				this.guestForm = true;
				this.guestCard = true;
			},
			removeGuest(key) {
				this.stepData.guests.splice(key, 1);
				var totalGuests = parseInt(this.stepData.numberOfGuests) - 1;
				this.stepData.numberOfGuests = totalGuests;
				EventBus.$emit('guestRemoved');
			},

			numberOfGuestsChanged() {
				var details = {
					special_fee_id: 0,
					visitor_type_id: 0,
					first_name: null,
					gender: null,
					nationality: null,
					last_name: null,
					email: null,
					birthdate: null,
					contact_number: null,
					emergency_contact_number: null,
					main: false,
					paths: []
				}

				this.stepData.guests = [];
				for(var i = 0; i < parseInt(this.stepData.numberOfGuests); i++) {
					this.stepData.guests.push(details);
				}
			},

			addGuest() {
				var details = {
					special_fee_id: 0,
					visitor_type_id: 0,
					first_name: null,
					gender: null,
					nationality: null,
					last_name: null,
					email: null,
					birthdate: null,
					contact_number: null,
					emergency_contact_number: null,
					main: false,
					paths: []
				}
				var totalGuests = parseInt(this.stepData.numberOfGuests) + 1;
				this.stepData.numberOfGuests = totalGuests;
				this.stepData.guests.push(details);
				EventBus.$emit('changed');
			},

			submitGuestDetails(guest_key, guest_data) {

				EventBus.$emit('changed');
				this.guest_key = null;
				this.stepData.guests[guest_key] = guest_data;
				this.guestCard = false;
				this.guestForm = false;
				guest_key = null;
				guest_data = null;
			},

			confirmedPayment() {
				var guests = [];
				var confirmationModal = $('[data-remodal-id=confirmation-modal]').remodal();
				var successModal = $('[data-remodal-id=success-modal]').remodal();
				
				confirmationModal.close();

				this.isLoading = true;

				this.stepData.guests.push(this.stepData.main);

				var data = new FormData();

				_.each(this.stepData.guests, (guest, key) => {
					data.append('special_fee_path['+key+']', guest.paths);
				})

				data.append('transaction_fee', this.$refs.formStepFour.transactionFee);
				data.append('conservation_fee', this.$refs.formStepFour.conservationFeeTotal);
				data.append('platform_fee', this.$refs.formStepFour.platformFee);
				data.append('sub_total', this.$refs.formStepFour.subTotal);
				data.append('grand_total', this.$refs.formStepFour.grandTotal);
				data.append('is_paypal_payment', this.$refs.formStepFour.isPaypal == true ? 1 : 0);
				data.append('guests', JSON.stringify(this.stepData.guests));
				data.append('start_time', this.stepData.timeSelected);
				data.append('allocation_id', this.stepData.allocationSelected);
				data.append('destination_id', this.destination.id);
				data.append('scheduled_at', this.stepData.visitDate);
				data.append('total_guest', this.stepData.numberOfGuests);
				data.append('agency_code', this.stepData.main.agency_code);

				axios.post(this.bookUrl, data)
					.then(response => {
						this.isLoading = false;
						successModal.open();
					})
			},

			termsConditionClick() {
				this.isAccepted.termsAndConditions = !this.isAccepted.termsAndConditions;
			},

			privacyPolicyClick() {
				this.isAccepted.privacyPolicy = !this.isAccepted.privacyPolicy;
			}
		}
	}
</script>