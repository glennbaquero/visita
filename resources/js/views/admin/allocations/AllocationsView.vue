<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header>Experience Information</template>
			<div class="row">
				<selector class="col-sm-12 col-md-6"
				v-model="item.destination_id"
				name="destination_id"
				label="Destination"
				:items="destinations"
				item-value="id"
				item-text="name"
				empty-text="None"
				placeholder="Please select a Destination"
				></selector>
			</div>
			
			<div class="row">
				<div class="form-group col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Platform Fees</label>
					<input v-model="item.platform_fees" name="platform_fees" type="number" class="form-control">
				</div>
<!-- 
				<div class="form-group col-sm-12 col-md-6">
					<label>Transaction Fees</label>
					<input v-model="item.transaction_fees" name="transaction_fees" type="number" class="form-control">
				</div> -->

				<!-- <div class="form-group col-sm-12 col-md-6">
					<label>Fee Per Head</label>
					<input v-model="item.fee_per_head" name="fee_per_head" type="number" class="form-control">
				</div> -->
			</div>
			
			<div class="row">

				<text-editor
				v-model="item.description"
				class="col-sm-12"
				label="Description"
				name="description"
				row="5"
				></text-editor>

				<!-- <text-editor
				v-model="item.recommended_for"
				class="col-sm-12"
				label="Recommended For (For Masungi Automated Email)"
				name="recommended_for"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.overview"
				class="col-sm-12"
				label="Overview (For Masungi Automated Email)"
				name="overview"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.characteristic"
				class="col-sm-12"
				label="Characteristic (For Masungi Automated Email)"
				name="characteristic"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.ideal_for"
				class="col-sm-12"
				label="Ideal For (For Masungi Automated Email)"
				name="ideal_for"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.inclusions"
				class="col-sm-12"
				label="Inclusions (For Masungi Automated Email)"
				name="inclusions"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.good_to_know"
				class="col-sm-12"
				label="Good To Know (For Masungi Automated Email)"
				name="good_to_know"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.visit_request_process"
				class="col-sm-12"
				label="Visit Request Process (For Masungi Automated Email)"
				name="visit_request_process"
				row="5"
				></text-editor>

				<text-editor
				v-model="item.terms_and_condition"
				class="col-sm-12"
				label="Terms And Condition (For Masungi Automated Email)"
				name="terms_and_condition"
				row="5"
				></text-editor> -->
	
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
                :message="'Are you sure you want to archive Experience #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Experience #' + item.id + '?'"
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
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.destinations = data.destinations ? data.destinations : this.destinations;
		},
	},

	data() {
		return {
			item: [],
			destinations: [],
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