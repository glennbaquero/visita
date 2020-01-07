<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header>About Tabbing Information</template>

			<div class="row">
				<selector class="col-sm-12 col-md-6"
				v-model="item.destination_id"
				name="destination_id"
				label="Destination"
				:items="destinations"
				item-value="id"
				item-text="name"
				placeholder="Please select destination"
				></selector>
				<div class="form-group col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>
			</div>
			<div class="row">
				<selector class="col-sm-12 col-md-6"
				v-model="item.mode"
				name="mode"
				label="Select mode"
				:items="modes"
				item-value="name"
				item-text="name"
				empty-text="None"
				placeholder="Please select mode"
				></selector>
				
				<date-picker
				v-if="item.mode == 'single'"
				v-model="dates"
				:enableTime="false"
				class="form-group col-sm-12 col-md-6"
				label="Date"
				name="dates[]"
				placeholder="Choose a date"
				mode="single"
				></date-picker>

				<date-picker
				v-if="item.mode == 'multiple or range'"
				v-model="dates"
				:enableTime="false"
				class="form-group col-sm-12 col-md-6"
				label="Date"
				name="dates[]"
				placeholder="Choose a date"
				mode="multiple"
				:default-date="dates"
				></date-picker>

				<!-- <date-picker
				v-if="item.mode == 'range'"
				v-model="dates"
				:enableTime="false"
				class="form-group col-sm-12 col-md-6"
				label="Date"
				name="dates[]"
				placeholder="Choose a date"
				mode="range"
				></date-picker> -->
			</div>

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
                :message="'Are you sure you want to archive Blocked Date #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Blocked Date #' + item.id + '?'"
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
import Datepicker from '../../../components/datepickers/Datepicker.vue';
import TimePicker from '../../../components/timepickers/Timepicker.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.dates = data.dates ? data.dates : this.dates;
			this.destinations = data.destinations ? data.destinations : this.destinations;
		},
	},

	data() {
		return {
			item: [],
			dates: [],
			destinations: [],
			modeSelected: 'single',
			modes: [
				{
					id: 1,
					name: 'single'
				},
				{
					id: 2,
					name: 'multiple or range'
				},
				// {
				// 	id: 3,
				// 	name: 'range'
				// },
			]
		}
	},

	components: {
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'date-picker': Datepicker,
		'time-picker': TimePicker,
	},

	mixins: [ CrudMixin ],
}
</script>