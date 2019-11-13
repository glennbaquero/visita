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
					<input v-model="item.id" name="id" type="text" class="form-control" v-show="hide">
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
					<input v-model="item.contact_number" name="contact_number" type="text" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Emergency Contact #</label>
					<input v-model="item.emergency_contact_number" name="emergency_contact_number" type="text" class="form-control">
				</div>
				<date-picker
				v-model="item.birthdate"
				:enableTime="false"
				class="form-group col-sm-12 col-md-4"
				label="Birthday"
				name="birthdate"
				placeholder="Choose a Birthday"
				maxDate="today"
				></date-picker>

				<selector class="col-sm-4"
				v-model="item.gender"
				name="gender"
				label="Gender"
				:items="genders"
				item-value="name"
				item-text="name"
				placeholder="Select Gender"
				></selector><!-- 

				<selector class="col-sm-4"
				v-model="item.payment_type"
				name="payment_type"
				label="Payment"
				:items="payments"
				item-value="id"
				item-text="name"
				placeholder="Select Payment"
				></selector> -->

			</div>
		</card>

		<card>
			<template v-slot:header>Guest Details <button type="button" class="btn btn-primary" @click="addGuest()"><i class="fas fa-plus"></i></button></template>
			
			<br>
			
			<template v-for="(guest, index) in total_guest">
				<guest-details :key="'guest-' + index" :guest="guest" :nationalities="nationalities" :genders="genders" :index="index <= 0 ? parseInt(index)+1 : parseInt(index)"></guest-details>
			</template>

			<template v-slot:footer>
				<action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
            
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
			return this.total_guest.length + 1;
		}
	},

	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.total_guest = data.item ? data.item.total_guests : this.total_guest;
			this.experiences = data.experiences ? data.experiences : this.experiences;
			this.nationalities = data.nationalities ? data.nationalities : this.nationalities;
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
			experiences: [],
			guest: 1,
			genders: [
				{
					name: 'Female'
				},
				{
					name: 'Male'
				},
			],

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