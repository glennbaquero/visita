<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header>Fees Information</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<selector class="col-sm-12 col-md-6"
				v-model="item.allocation_id"
				name="allocation_id"
				label="Allocation"
				:items="allocations"
				item-value="id"
				item-text="name"
				empty-text="None"
				placeholder="Please select an Allocation"
				></selector>

				<div class="form-group col-sm-12 col-md-6">
					<label>Weekday</label>
					<input v-model="item.weekday" name="weekday" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Weekend</label>
					<input v-model="item.weekend" name="weekend" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Day Tour</label>
					<input v-model="item.daytour" name="daytour" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Overnight</label>
					<input v-model="item.overnight" name="overnight" type="number" min="1" class="form-control">
				</div>
							
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
                :message="'Are you sure you want to archive Fee #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Fee #' + item.id + '?'"
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

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.allocations = data.allocations ? data.allocations : this.allocations;
		},
	},

	data() {
		return {
			item: [],
			allocations: [],
		}
	},

	components: {
		'action-button': ActionButton,
		'selector': Select,
	},

	mixins: [ CrudMixin ],
}
</script>