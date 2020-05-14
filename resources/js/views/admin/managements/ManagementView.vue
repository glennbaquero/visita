<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header>Frontliner Information</template>
			<div class="row">
				<selector class="col-sm-6"
				v-model="item.role_id"
				name="role_id"
				label="Role"
				:items="roles"
				item-value="id"
				item-text="name"
				placeholder="Select Role"
				></selector>

				<selector class="col-sm-6"
				v-model="item.destination_id"
				name="destination_id"
				label="Destination"
				:items="destinations"
				item-value="id"
				item-text="name"
				placeholder="Select Destination"
				></selector>
			</div>
			<div class="row">

				<div class="form-group col-sm-12 col-md-4">
					<label>Firstname</label>
					<input v-model="item.first_name" name="first_name" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Lastname</label>
					<input v-model="item.last_name" name="last_name" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Email</label>
					<input v-model="item.email" name="email" type="text" class="form-control" :readonly="readOnly">
				</div>
				
				<div class="form-group col-sm-12 col-md-4">
					<label>Username</label>
					<input v-model="item.username" name="username" type="text" class="form-control" :readonly="readOnly">
				</div>
				
				<div class="form-group col-sm-12 col-md-4">
					<label>Contact #</label>
					<input v-model="item.contact_number" name="contact_number" type="number" class="form-control">
				</div>
			</div>

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
                :message="'Are you sure you want to archive Frontliner Account #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Frontliner Account #' + item.id + '?'"
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

export default {
	props: {
		readOnly: {
			default: false,
			type: Boolean
		}
	},

	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.destinations = data.destinations ? data.destinations : this.destinations;
			this.roles = data.roles ? data.roles : this.roles;
		},
	},

	data() {
		return {
			item: [],
			destinations: [],
			roles: [],
		}
	},

	components: {
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
		'date-picker': Datepicker,
		'time-picker': TimePicker,
	},

	mixins: [ CrudMixin ],
}
</script>