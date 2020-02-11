<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header>Survey Experience Question and Answers</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-12">
					<label>Question</label>
					<input v-model="item.question" name="question" type="text" class="form-control">
				</div>
				
				<div class="form-group col-sm-12 col-md-6">
					<div class="custom-control custom-switch">
						<input
						v-model="item.answerable"
						name="answerable" :checked="item.answerable" @change="withAnswers()" type="checkbox" class="custom-control-input" id="answerable">
						<label class="custom-control-label" for="answerable">With list of answers?</label>
					</div>
				</div>

				<div class="form-group col-sm-12 col-md-12" v-if="item.answerable || with_answer">
					<button type="button" class="btn btn-sm btn-primary" @click="addNewAnswer()">
						<span><i class="fas fa-plus"></i> Add new answer</span>
					</button>
				</div>

				<div class="form-group col-sm-12 col-md-4" v-if="item.answerable || with_answer" v-for="(answer, index) in answers">
					<label>{{ index+1 }}) Answer</label>
					<button type="button" class="btn btn-sm btn-danger" v-if="index > 0" @click="removeAnswer(index, answer)">
						<span><i class="fas fa-minus"></i></span>
					</button>
					<input v-model="answers[index].answer" name="answers[]" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-12">
					<div class="custom-control custom-switch">
						<input
						v-model="item.show_other"
						name="show_other" :checked="item.show_other" @change="showOther()" type="checkbox" class="custom-control-input" id="show_other">
						<label class="custom-control-label" for="show_other">Can enter other answer?</label>
					</div>
				</div>

				<div class="form-group col-sm-12 col-md-12" v-if="item.show_other || show_other">
					<label>Placeholder for Other Answer</label>
					<input v-model="item.others_placeholder" name="others_placeholder" type="text" class="form-control">
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
                :message="'Are you sure you want to archive Annual Income #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Annual Income #' + item.id + '?'"
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
	props:{
		removeAnswerUrl: {
			default: null,
			type: String
		}
	},

	data() {
		return {
			item: [],
			show_other: false,			
			with_answer: false,			
			answers: [
				{
					answer: null
				},
			]
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

	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.answers = data.answers ? data.answers : this.answers;
		},

		showOther() {
			if(!this.show_other) {
				this.show_other = true;
				this.item.show_other = true;
			} else {
				this.show_other = false;
				this.item.show_other = false;
			}
		},

		withAnswers() {
			if(!this.with_answer) {
				this.with_answer = true;
				this.item.answerable = true;
			} else {
				this.with_answer = false;
				this.item.answerable = false;
			}
		},

		addNewAnswer() {
			var obj = {
				answer: null
			};

			this.answers.push(obj)
		},

		removeAnswer(index, answer) {
			this.answers.splice(index, index);
			axios.post(this.removeAnswerUrl, { id : answer.id })
		}
	},

	mixins: [ CrudMixin ],
}
</script>