<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header>About Tabbing Information</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-4">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>
				
				<div class="form-group col-sm-12 col-md-4">
					<label>Code</label>
					<input v-model="item.code" name="code" type="text" class="form-control">
				</div>

				<selector class="col-sm-4"
				v-model="item.add_ons"
				name="add_ons[]"
				label="Add Ons"
				:items="add_ons"
				item-value="id"
				item-text="name"
				multiple
				placeholder="Please select an item"
				></selector>

				<div class="form-group col-sm-12 col-md-6">
					<label>Capacity Per Day</label>
					<input v-model="item.capacity_per_day" name="capacity_per_day" type="number" min="1" class="form-control">
				</div>
				
				<time-picker
				v-model="item.operating_hours"
				class="form-group col-sm-12 col-md-6 time"
				label="Operating Hours"
				name="operating_hours"
				placeholder="Choose time slot"
				></time-picker>
				
			</div>
			
			<div class="row">

				<text-editor
				v-model="item.icon"
				class="col-sm-12"
				label="Icon"
				name="icon"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.description"
				class="col-sm-12"
				label="Overview"
				name="description"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.orientation_module"
				class="col-sm-12"
				label="Orientation Module"
				name="orientation_module"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.terms_conditions"
				class="col-sm-12"
				label="Terms and conditions"
				name="terms_conditions"
				row="5"
				></text-editor>


				<text-editor
				v-model="item.visitor_policies"
				class="col-sm-12"
				label="Visitor Policies"
				name="visitor_policies"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.contact_us"
				class="col-sm-12"
				label="Contact Us"
				name="contact_us"
				row="5"
				></text-editor>

	
			</div>

			<div class="row">
				<image-picker
				:value="images"
				class="form-group col-sm-12 col-md-12 mt-2"
	            label="Images"
	            name="images[]"
	            placeholder="Choose Files"
	            multiple
	            :sort-url="sortUrl"
	            :remove-url="item.removeImageUrl"
	            @remove="fetch"
	            max="3"
	            min="1"
				></image-picker>
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

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.images = data.images ? data.images : this.images;
			this.add_ons = data.add_ons ? data.add_ons : this.add_ons;
		},
	},

	data() {
		return {
			item: [],
			images: [],
			add_ons: []
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