<template>
	<div>
		<div class="rqst-frm1__step-2-content">
			<div class="align-l m-margin-b">
				<h5 class="frm-title small clr--gray">Main Contact Person</h5>
			</div>
			<hr>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray" :style=" { 'color' : errors.firstName }">First Name*</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" v-model="stepData.main.first_name" @keypress="regexString();" @keyup="capitalize(stepData.main.first_name)" @blur="isNull(stepData.main.first_name, 'firstName')">
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray" :style=" { 'color' : errors.lastName }">Last Name*</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" v-model="stepData.main.last_name" @keypress="regexString()" @blur="isNull(stepData.main.last_name, 'lastName')">
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray" :style=" { 'color' : errors.nationality }">Nationality*</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.nationality" @blur="isNull(stepData.main.nationality, 'nationality')">
								<option v-for="country in countries" :value="country.citizenship"> {{ country.citizenship }} </option>
							</select>
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray" :style="{ 'color': color }">Email Address*</p>
						<div class="frm-inpt m-margin-b">
							<input type="email" v-model="stepData.main.email" @keyup="emailKeyPressed">
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray"  :style=" { 'color' : errors.contactNumber }" @blur="isNull(stepData.main.contact_number, 'contactNumber')">Contact No.*</p>
						<div class="inlineBlock-parent">
							<div class="width--30">
								<div class="width--90">
									<div class="frm-inpt align-c m-margin-b">
										<input type="text" name="" value="+63" disabled>
									</div>
								</div>
							</div
							><div class="width--70">
								<div class="frm-inpt align-c m-margin-b">
									<input type="text" name="" maxlength="10" placeholder="" v-model="stepData.main.contact_number" @keypress="regexNumber()" @blur="isNull(stepData.main.contact_number, 'contactNumber')">
								</div>
							</div>
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray"  :style=" { 'color' : errors.emergencyContactNumber }">Emergency Contact*</p>
						<div class="inlineBlock-parent">
							<div class="width--30">
								<div class="width--90">
									<div class="frm-inpt align-c m-margin-b">
										<input type="text" name="" value="+63" disabled>
									</div>
								</div>
							</div
							><div class="width--70">
								<div class="frm-inpt align-c m-margin-b">
									<input type="text" name="" placeholder="" maxlength="10" v-model="stepData.main.emergency_contact_number" @keypress="regexNumber()" @blur="isNull(stepData.main.emergency_contact_number, 'emergencyContactNumber')">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray"  :style=" { 'color' : errors.birthdate }">Birthdate*</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" id="birthdate" v-model="stepData.main.birthdate" @blur="isNull(stepData.main.birthdate, 'birthdate')">
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray" :style=" { 'color' : errors.gender }">Gender*</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.gender" @blur="isNull(stepData.main.gender, 'gender')">
								<option v-for="gender in genders" :value="gender.name"> {{ gender.name }} </option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray"  :style=" { 'color' : errors.visitorType }">Visitor Type*</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.visitor_type_id" @blur="isNull(stepData.main.visitor_type_id, 'visitorType')">
								<option v-for="type in visitorTypes" :value="type.id">{{ type.name }}</option>
							</select>
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray">Special Fees</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.special_fee_id">
								<option value="0">None</option>
								<option v-for="fee in specialFees" :value="fee.id"> {{ fee.name }} </option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray">Agency Code</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" v-model="stepData.main.agency_code">
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a" v-if="showFileInput">
						<p class="frm-header bold s-margin-b clr--gray">Health Certificate/Letter of Consent*</p>
						<div class="frm-inpt m-margin-b">
							<input type="file" @change="proofForSpecialFee">
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="inlineBlock-parent width--100 align-l">
			<p class="frm-header bold clr--green">NOTE:</p>
			<p class="frm-header clr--gray">Contact Person should be 18 years old and above.</p>
		</div>
	</div>
</template>

<script>
	/* Flatpickr Documentation: https://flatpickr.js.org/options/ */
	import flatpickr from 'flatpickr';
	import 'flatpickr/dist/flatpickr.css';
	import RegexMixin from 'Mixins/regex.js';

	export default {
		props: {
			visitorTypes: Array,
			specialFees: Array,
			stepData: Object,
			countries: Array,
			genders: Array,
		},

		data() {
			return {
				color: null,
				reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
				errors: {
					firstName: null,
					lastName: null,
					contactNumber: null,
					emergencyContactNumber: null,
					gender: null,
					nationality: null,
					visitorType: null,
					birthdate: null,
				}
			}
		},

		mixins: [ RegexMixin ],

		computed: {
			showFileInput() {
				if(this.stepData.main.special_fee_id != 0) { return true }
				return false;
			},

			firstNameNull() {
				if(this.stepData.main.first_name == null) return '#d43f3f';

				return null;
			},

			lastNameNull() {
				if(this.stepData.main.last_name == null) return '#d43f3f';

				return null;
			},

			contactNumberNull() {
				if(this.stepData.main.contact_number == null) return '#d43f3f';

				return null;
			},

			emergencyContactNumberNull() {
				if(this.stepData.main.emergency_contact_number == null) return '#d43f3f';

				return null;
			},
		},

		mounted() {
			flatpickr('#birthdate', { maxDate: new Date().fp_incr(-6570), disableMobile: 'true' });
		},

		methods: {
			proofForSpecialFee(e) {
	            var files = e.target.files || e.dataTransfer.files;

	            if(!files.length)
	                return;

	            this.stepData.main.paths = files[0];
	        },

	        emailKeyPressed() {
	        	if(!this.reg.test(this.stepData.main.email)) {
	        		this.color = '#d43f3f';
	        	} else {
	        		this.color = null;
	        	}
	        },

	        isNull(model, error) {
	        	if(model == null || model == '') {
	        		if(error === 'firstName') {
	        			this.errors.firstName = '#d43f3f';
	        		} 

	        		if(error === 'lastName') {
	        			this.errors.lastName = '#d43f3f';
	        		} 

	        		if(error === 'nationality') {
	        			this.errors.nationality = '#d43f3f';
	        		} 

	        		if(error === 'contactNumber') {
	        			this.errors.contactNumber = '#d43f3f';
	        		} 

	        		if(error === 'emergencyContactNumber') {
	        			this.errors.emergencyContactNumber = '#d43f3f';
	        		} 

	        		if(error === 'birthdate') {
	        			this.errors.birthdate = '#d43f3f';
	        		} 

	        		if(error === 'gender') {
	        			this.errors.gender = '#d43f3f';
	        		} 

					if(error === 'visitorType') {
	        			this.errors.visitorType = '#d43f3f';
	        		} 	        		
	        	} else {
	        		if(error === 'firstName') {
	        			this.errors.firstName = null;
	        		} 

	        		if(error === 'lastName') {
	        			this.errors.lastName = null;
	        		} 

	        		if(error === 'nationality') {
	        			this.errors.nationality = null;
	        		}

	        		if(error === 'contactNumber') {
	        			this.errors.contactNumber = null;
	        			if(model.length < 10) {
	        				this.errors.contactNumber = '#d43f3f';
	        			}
	        		} 

	        		if(error === 'emergencyContactNumber' && model.length >= 10) {
	        			this.errors.emergencyContactNumber = null;
	        			if(model.length < 10) {
	        				this.errors.emergencyContactNumber = '#d43f3f';
	        			}
	        		} 

	        		if(error === 'birthdate') {
	        			this.errors.birthdate = null;
	        		} 

	        		if(error === 'gender') {
	        			this.errors.gender = null;
	        		} 

					if(error === 'visitorType') {
	        			this.errors.visitorType = null;
	        		}
	        	}
	        }
		}
	}
</script>