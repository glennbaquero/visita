<template>
	<div>
		<div class="rqst-frm1__steps-form-cards">
			<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
				<div class="align-l m-margin-b">
					<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
					<hr>

					<p class="frm-header bold s-margin-b clr--gray">Visit Date</p>
					<div class="frm-inpt m-margin-b">
						<input type="text" v-model="stepData.visitDate" id="visit-date">
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Select Experience</p>
					<div class="frm-inpt m-margin-b">
						<select v-model="stepData.allocationSelected" @change="allocationChanged()">
							<option v-for="allocation in items" :value="allocation.allocation_id" >{{ allocation.allocation_name }}</option>
						</select>
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Number of guest/s</p>
					<div class="frm-inpt m-margin-b">
						<input type="number" v-model="stepData.numberOfGuests" min="0" @keypress="regexNumber()" @change="$emit('numberOfGuestsChanged')">
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Time</p>
					<div class="frm-inpt m-margin-b">
						<!-- <input type="time"> -->
						<select v-model="stepData.timeSelected">
							<option v-for="timeslot in timeslots" :value="timeslot.time" >{{ timeslot.formatted_time }}</option>
						</select>
					</div>

				</div>
			</div>
			<hr>
			<div class="inlineBlock-parent">
				<div class="width--45">
					
				</div
				><div class="width--45">
					<div class="width--95">
						<button 
							v-if="detailsComplete"
						  	class="frm-btn green"
						  	@click="$emit('showStep2')"
						>Next</button>
					</div>
				</div>
			</div>
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
			destination: Object,
			stepData: Object,
			items: Array
		},

		mixins: [ RegexMixin ],

		computed: {
			detailsComplete() {
				if(this.stepData.visitDate != null && this.stepData.timeSelected != null && this.stepData.allocationSelected != null) return true;

				return false;
			},

			timeslots() {
				var result = [];
				_.forEach(this.items, (value) => {
			    	if(value.allocation_id  === this.stepData.allocationSelected){
			      		result = value.timeslot;
			    	}
			  	});

			  	return result;
			}
		},

		mounted() {
			flatpickr('#visit-date', { minDate: 'today', disable: this.destination.dateBlock });
		},

		methods: {
			allocationChanged() {
				var result = [];

			  	_.forEach(this.items, (value) => {
			    	if(value.allocation_id  === this.stepData.allocationSelected){
			      		this.timeslots = value.timeslot;
			    	}
			  	});
			}
		}
	}
</script>