<template>
	<div>
		<div class="inlineBlock-parent">
			<div class="width--60">
				<h5 class="frm-title small clr--gray">Guest {{ headCount }} Details</h5>
			</div
			><div class="width--40 align-r inlineBlock-parent">
				
			</div>
		</div>
		<hr>
		<div class="inlineBlock-parent align-l">
			<div class="width--50">
				<div class="width--95">
					<p class="frm-header bold s-margin-b clr--gray">First Name*</p>
					<div class="frm-inpt m-margin-b">
						<input type="text" v-model="guest.first_name" @keypress="regexString($evt)">
					</div>
				</div>
			</div
			><div class="width--50">
				<div class="width--95 margin-l-a">
					<p class="frm-header bold s-margin-b clr--gray">Last Name*</p>
					<div class="frm-inpt m-margin-b">
						<input type="text" v-model="guest.last_name" @keypress="regexString($evt)">
					</div>
				</div>
			</div>
		</div>

		<div class="inlineBlock-parent align-l">
			<div class="width--50">
				<div class="width--95">
					<p class="frm-header bold s-margin-b clr--gray">Nationality*</p>
					<div class="frm-inpt m-margin-b">
						<select v-model="guest.nationality">
							<option v-for="country in countries" :value="country.citizenship">{{ country.citizenship }}</option>
						</select>
					</div>
				</div>
			</div
			><div class="width--50">
				<div class="width--95 margin-l-a">
					<p class="frm-header bold s-margin-b clr--gray">Email Address*</p>
					<div class="frm-inpt m-margin-b">
						<input type="email" v-model="guest.email">
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
								<input type="number" name="" placeholder="" v-model="guest.contact_number" @keypress="regexNumber($evt)">
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
								<input type="number" name="" placeholder="" v-model="guest.emergency_contact_number" @keypress="regexNumber($evt)">
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
						<input type="text" id="birthdate-guests" v-model="guest.birthdate">
					</div>
				</div>
			</div
			><div class="width--50">
				<div class="width--95 margin-l-a">
					<p class="frm-header bold s-margin-b clr--gray">Gender*</p>
					<div class="frm-inpt m-margin-b">
						<select v-model="guest.gender">
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
						<select v-model="guest.visitor_type_id">
							<option v-for="type in visitorTypes" :value="type.id"> {{ type.name }} </option>
						</select>
					</div>
				</div>
			</div
			><div class="width--50">
				<div class="width--95 margin-l-a">
					<p class="frm-header bold s-margin-b clr--gray">Special Fees</p>
					<div class="frm-inpt m-margin-b">
						<select v-model="guest.special_fee_id">
							<option value="0">None</option>
							<option v-for="fee in specialFees" :value="fee.id">{{ fee.name }}</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="inlineBlock-parent align-l" v-if="showFileInput">
			<div class="width--50">
				<div class="width--95">
					<p class="frm-header bold s-margin-b clr--gray">Health Certificate/Letter of Consent (Optional)</p>
					<div class="frm-inpt m-margin-b">
						<input type="file" @change="proofForSpecialFee">
					</div>
				</div>
			</div>
		</div>

		<div class="align-l">
			<button class="frm-btn green" @click="$emit('submitGuestDetails', guestKey, guest)" v-if="showSubmit">Submit</button>
		</div>
	</div>
</template>

<script>
	/* Flatpickr Documentation: https://flatpickr.js.org/options/ */
	import flatpickr from 'flatpickr';
	import 'flatpickr/dist/flatpickr.css';
	import RegexMixin from 'Mixins/regex.js';

	export default{
		props: {
			guestKey: Number,
			stepData: Object,
			countries: Array,
			genders: Array,
			visitorTypes: Array,
			specialFees: Array
		},

		mixins: [ RegexMixin ],
		
		data() {
			return {
				guest: {},
				headCount: this.guestKey + 1,
			}
		},	

		computed: {
			showFileInput() {
				if(this.guest.special_fee_id != 0) { return true }
				return false;
			},

			showSubmit() {
				if(this.guest.first_name != '' && this.guest.gender != '' && 
					this.guest.nationality != '' && this.guest.last_name != '' && 
					this.guest.email != '' && this.guest.birthdate != '' && 
					this.guest.contact_number != '' && this.guest.emergency_contact_number != '' &&
					this.guest.visitor_type_id != 0) return true;

				return false;				
			}
		},

		mounted() {
			flatpickr('#birthdate-guests', { maxDate: 'today' });
			this.setupGuestData();
		},

		methods: {
			setupGuestData() {
				if(this.stepData.first_name != null) {
					this.guest = this.stepData;
				} else {
					this.guest = {
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
						paths: null
					}
				}
			},

			proofForSpecialFee(e) {
	            var files = e.target.files || e.dataTransfer.files;

	            if(!files.length)
	                return;

	            this.guest.paths = files[0];
	        },
		}
	}
</script>