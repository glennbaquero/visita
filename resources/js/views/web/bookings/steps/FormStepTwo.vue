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
						<p class="frm-header bold s-margin-b clr--gray">First Name*</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" v-model="stepData.main.first_name" @keypress="regexString();" @keyup="capitalize(stepData.main.first_name)">
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray">Last Name*</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" v-model="stepData.main.last_name" @keypress="regexString()">
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray">Nationality*</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.nationality">
								<option v-for="country in countries" :value="country.citizenship"> {{ country.citizenship }} </option>
							</select>
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray">Email Address*</p>
						<div class="frm-inpt m-margin-b">
							<input type="email" v-model="stepData.main.email">
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray">Contact No.*</p>
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
									<input type="text" name="" maxlength="10" placeholder="" v-model="stepData.main.contact_number" @keypress="regexNumber()">
								</div>
							</div>
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray">Emergency Contact*</p>
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
									<input type="text" name="" placeholder="" maxlength="10" v-model="stepData.main.emergency_contact_number" @keypress="regexNumber()">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray">Birthdate*</p>
						<div class="frm-inpt m-margin-b">
							<input type="text" id="birthdate" v-model="stepData.main.birthdate">
						</div>
					</div>
				</div
				><div class="width--50">
					<div class="width--95 margin-l-a">
						<p class="frm-header bold s-margin-b clr--gray">Gender*</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.gender">
								<option v-for="gender in genders" :value="gender.name"> {{ gender.name }} </option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent align-l">
				<div class="width--50">
					<div class="width--95">
						<p class="frm-header bold s-margin-b clr--gray">Visitor Type*</p>
						<div class="frm-inpt m-margin-b">
							<select v-model="stepData.main.visitor_type_id">
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

		mixins: [ RegexMixin ],

		computed: {
			showFileInput() {
				if(this.stepData.main.special_fee_id != 0) { return true }
				return false;
			}
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
		}
	}
</script>