<template>
	<div >
	
		<card>
			<template v-slot:header>Survey Tabbing Information</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-6">
					<label>Book ID</label>
					<input v-model="item.group" name="book_id" type="text" class="form-control" readonly>
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Age</label>
					<input v-model="item.age" name="age" type="text" class="form-control" readonly>
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Gender</label>
					<input v-model="item.gender" name="gender" type="text" class="form-control" readonly>
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Nationality</label>
					<input v-model="item.nationality" name="nationality" type="text" class="form-control" readonly>
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Civil Status</label>
					<input v-model="item.civil_status" name="civil_status" type="text" class="form-control" readonly>
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Annual Income</label>
					<input v-model="item.annual_income" name="annual_income" type="text" class="form-control" readonly>
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Educational Attainment</label>
					<input v-model="item.education_attainment" name="education_attainment" type="text" class="form-control" readonly>
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Budget</label>
					<input v-model="item.budget" name="budget" type="text" class="form-control" readonly>
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Date</label>
					<input v-model="item.created_at" name="created_at" type="text" class="form-control" readonly>
				</div>

				<div class="form-group col-sm-12 col-md-12">
					<label>Visitor purchase to create the memory of a destination</label>
					<input v-model="item.memory" name="memory" type="text" class="form-control" readonly>
				</div>

				<div class="form-group col-sm-12 col-md-12">
					<label>Item Visitor bought</label>
					<input v-model="item.item" name="item" type="text" class="form-control" readonly>
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
                :message="'Are you sure you want to archive Survey #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Survey #' + item.id + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                @error="fetch"
                ></action-button>
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</div>
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
		},
	},

	data() {
		return {
			item: [],
			images: [],
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