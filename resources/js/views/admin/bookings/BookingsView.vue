<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
		<card>
			<template v-slot:header>Schedule</template>
			<div class="row">
				<date-picker
				v-model="item.scheduled_at"
				class="form-group col-sm-12 col-md-4"
				label="Scheduled Date"
				name="scheduled_at"
				placeholder="Choose dates"
				minDate="today"
				:disabledDates="blocked_dates"
				></date-picker>

				<selector class="col-sm-4"
				v-model="item.allocation_id"
				name="allocation_id"
				label="Experience"
				:items="experiences"
				item-value="id"
				item-text="name"
				placeholder="Select Experience"
				></selector>
				
				<div class="form-group col-sm-12 col-md-4" v-show="hide">
					<label>Number of Guests</label>
					<input name="total_guest" type="number" class="form-control" :value="totalGuest">
				</div>

			</div>
		</card>
		<card>
			

			<template v-slot:header>Point Person Information</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-4">
					<label>Firstname</label>
					<input v-model="item.first_name" name="first_name" type="text" class="form-control">
					<input v-model="item.main_id" name="main_id" type="text" class="form-control" v-show="hide">
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Lastname</label>
					<input v-model="item.last_name" name="last_name" type="text" class="form-control">
				</div>
				<selector class="col-sm-4"
				v-model="item.nationality"
				name="nationality"
				label="Nationality"
				:items="nationalities"
				item-value="citizenship"
				item-text="citizenship"
				placeholder="Select Nationality"
				></selector>
				<div class="form-group col-sm-12 col-md-4">
					<label>Email</label>
					<input v-model="item.email" name="email" type="email" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Contact #</label>
					<input v-model="item.contact_number" name="contact_number" type="number" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Emergency Contact #</label>
					<input v-model="item.emergency_contact_number" name="emergency_contact_number" type="number" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Birthday</label>
					<input name="birthdate" v-model="item.main_birthdate" type="text" id="main_birthdate" class="form-control">
				</div>
				<!-- <date-picker
				v-model="item.birthdate"
				:enableTime="false"
				class="form-group col-sm-12 col-md-4"
				label="Birthday"
				name="birthdate"
				placeholder="Choose a Birthday"
				maxDate="today"
				date-format="Y-m-d"
				></date-picker> -->

				<selector class="col-sm-4"
				v-model="item.gender"
				name="gender"
				label="Gender"
				:items="genders"
				item-value="name"
				item-text="name"
				placeholder="Select Gender"
				></selector>

				<selector class="col-sm-4"
				v-model="item.visitor_type_id"
				name="visitor_type_id"
				label="Visitor Type"
				:items="visitor_types"
				item-value="id"
				item-text="name"
				placeholder="Select Type of Visitor"
				></selector>

				<selector class="col-sm-4"
				v-model="item.special_fee_id"
				name="special_fee_id"
				label="Special Fees"
				:items="special_fees"
				item-value="id"
				item-text="name"
				placeholder="Select Special Fee"
				></selector>


				<image-picker
				:value="item.specialFeeImagePath"
				class="form-group col-sm-12 col-md-12"
	            label="Image"
	            name="special_fee_path"
	            placeholder="Choose a File"
				></image-picker>

			</div>
		</card>

		<card>
			<template v-slot:header>Guest Details <!-- <button type="button" class="btn btn-primary" @click="addGuest()"><i class="fas fa-plus"></i></button> --></template>
			
			<br>
			
			<template v-for="(guest, index) in total_guest">
				<guest-details 
					:key="'guest-' + index" 
					:guest="guest" 
					:special-fees="special_fees" 
					:visitor-types="visitor_types" 
					:nationalities="nationalities" 
					:genders="genders" 
					:index="parseInt(index)+1" 
					>
					<!-- @removeGuest="removeGuest(index)" -->
				</guest-details>
			</template>

			<template v-slot:footer>
                <action-button
                v-if="item.archiveUrl && item.restoreUrl"
                color="btn-danger"
                alt-color="btn-warning"
                :action-url="item.archiveUrl"
                :alt-action-url="item.restoreUrl"
                label="Archive"
                alt-label="Restore"
                :show-alt="item.deleted_at"
                confirm-dialog
                title="Archive Item"
                alt-title="Restore Item"
                :message="'Are you sure you want to archive Destination #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Destination #' + item.id + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                @error="fetch"
                ></action-button>
                
				<action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</form-request>
</template>

<script type="text/javascript">
import { EventBus }from '../../../EventBus.js';
import CrudMixin from '../../../mixins/crud.js';

import ActionButton from '../../../components/buttons/ActionButton.vue';
import Select from '../../../components/inputs/Select.vue';
import ImagePicker from '../../../components/inputs/ImagePicker.vue';
import TextEditor from '../../../components/inputs/TextEditor.vue';
import Datepicker from '../../../components/datepickers/Datepicker.vue';
import TimePicker from '../../../components/timepickers/Timepicker.vue';
import GuestDetails from './GuestDetails.vue';

export default {
	computed: {
		totalGuest() {
			var totalGuests = 0;
			if(this.item.total_guest) {
				totalGuests = this.item.total_guest;
			}
			return totalGuests  + this.total_guest.length;
		}
	},

	mounted() {
		var validDate = moment().add(1,'days').subtract(18,'years').format('YYYY-MM-DD');
		var todayAndFutureDate = moment().add(1000,'years').format('YYYY-MM-DD');

		// flatpickr('#main_birthdate', { maxDate: new Date().fp_incr(-6570), disableMobile: 'true' });
		flatpickr('#main_birthdate', { maxDate: new Date().fp_incr(-6570), disable: [
					{ 
						from: validDate,
						to: todayAndFutureDate
					}
				], disableMobile: 'true' });
	},

	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.total_guest = data.item ? data.item.total_guests : this.total_guest;
			this.experiences = data.experiences ? data.experiences : this.experiences;
			this.nationalities = data.nationalities ? data.nationalities : this.nationalities;
			this.special_fees = data.special_fees ? data.special_fees : this.special_fees;
			this.visitor_types = data.visitor_types ? data.visitor_types : this.visitor_types;
			this.blocked_dates = data.blocked_dates ? data.blocked_dates : this.blocked_dates;
			this.genders = data.genders ? data.genders : this.genders;
		},

		addGuest() {
			var obj = {
				guest_first_name: null,
				guest_last_name: null,
				guest_email: null,
				guest_first_name: null,
			}

			this.total_guest.push(obj);
		},

		removeGuest(index) {
			if(this.total_guest.length === 1) { this.total_guest = []; }
			if(index === 0) { this.total_guest.splice(0, 1) }
			this.total_guest.splice(index, index);
		}
	},

	data() {
		return {
			item: [],
			nationalities: [],
			special_fees: [],
			visitor_types: [],
			blocked_dates: [],
			experiences: [],
			guest: 1,
			genders: [],
			total_guest: [],
			hide: false
		}
	},

	components: {
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
		'date-picker': Datepicker,
		'time-picker': TimePicker,
		GuestDetails
	},

	mixins: [ CrudMixin ],
}
</script>