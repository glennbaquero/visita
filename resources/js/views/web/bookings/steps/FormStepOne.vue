<template>
	<div>
		<div class="rqst-frm1__steps-form-cards">
			<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
				<div class="align-l m-margin-b">
					<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
					<hr>
					
					<p class="frm-header bold s-margin-b clr--gray">Select Experience</p>
					<div class="frm-inpt m-margin-b">
						<select v-model="stepData.allocationSelected" @change="allocationChanged()">
							<option v-for="allocation in items" :value="allocation.allocation_id" >{{ allocation.allocation_name }}</option>
						</select>
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Visit Date</p>
					<div class="frm-inpt m-margin-b">
						<input type="text" v-model="stepData.visitDate" id="visit-date">
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Number of guest/s</p>
					<div class="frm-inpt m-margin-b">
						<input type="number" v-model="stepData.numberOfGuests" min="1" @keypress="regexNumber()" @change="$emit('numberOfGuestsChanged')">
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Time</p>
					<div class="frm-inpt m-margin-b">
						<!-- <input type="time"> -->
						<select v-model="stepData.timeSelected">
							<option v-for="timeslot in timeslots" :value="timeslot.time">{{ timeslot.formatted_time }}</option>
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
							v-if="isDataComplete"
						  	class="frm-btn green"
						  	@click="$emit('showStep2')"
						>Next</button>
					</div>
				</div>
			</div>
		</div>
		<loading :active.sync="isLoading" :is-full-page="true"></loading>
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
			items: Array,
			checkerUrl: String,
			remainingSeatUrl: String,
		},

		components: {
		    Loading,
		},

		mixins: [ RegexMixin ],

		watch: {
			'stepData.visitDate'(val) {
				var data = {
					destination: this.destination.id,
					allocation: this.stepData.allocationSelected,
					date: this.stepData.visitDate
				}

				axios.post(this.remainingSeatUrl, data) 
					.then(response => {
						this.destination.availableSeat = response.data.availableSeat;

						if(this.stepData.visitDate != null && this.stepData.timeSelected != null && this.stepData.allocationSelected != null && parseInt(this.stepData.numberOfGuests) >= 1 && this.stepData.numberOfGuests <= this.destination.availableSeat) {
							this.isDataComplete = true;
						}
						
						if(response.data.availableSeat == 0) {
							swal.fire('Oops...', 'Capacity is full for selected date of visit!', 'error')
						}
					})

			}
		},

		data() {
			return {
				timeslots: [],
				isLoading: false,
		        now: moment().add(0, 'days').format('Y-MM-DD'),
		        isDataComplete: this.detailsComplete
			}
		},

		computed: {
			detailsComplete() {
				if(this.stepData.visitDate != null && this.stepData.timeSelected != null && this.stepData.allocationSelected != null && parseInt(this.stepData.numberOfGuests) >= 1 && this.stepData.numberOfGuests <= this.destination.availableSeat) return true;

				return false;
			},

			timeslots() {
				var result = [];
				var currentTime = moment();
				_.forEach(this.items, (value) => {
			    	if(value.allocation_id  === this.stepData.allocationSelected){
			    		_.each(value.timeslot, (timeslot) => {
							var slot = moment(timeslot.formatted_time, 'H:mm A');
			    			if(this.stepData.visitDate == this.now) {
			    				if(slot.isAfter(currentTime)) {
			    					result.push(timeslot);
			    				}
			    			} else {
								result.push(timeslot);
							}
			    		})
			      		// result = value.timeslot;
			    	}
			  	});

			  	return result;
			}
		},

		mounted() {
			// flatpickr('#visit-date', { maxDate: new Date().fp_incr(-this.destination.cut_off_days), disable: this.destination.dateBlock, disableMobile: 'true' });
			var date = new Date();
			flatpickr('#visit-date', { minDate: date.setDate(date.getDate() + this.destination.cut_off_days), disable: this.destination.dateBlock, disableMobile: 'true' });
			if(this.stepData.allocationSelected) {
				this.allocationChanged();
			}
		},

		methods: {
			allocationChanged() {
				this.isLoading = true;
				var data = {
					allocationSelected: this.stepData.allocationSelected
				};

				this.stepData.timeSelected = null;

				axios.post(this.checkerUrl, data)
					.then(response => {
						_.each(response.data, (data)=> {
							this.destination.dateBlock.push(data);
						})
						// flatpickr('#visit-date', { minDate: 'today', disable: this.destination.dateBlock, disableMobile: 'true' });
						var date = new Date();
						flatpickr('#visit-date', { minDate: date.setDate(date.getDate() + this.destination.cut_off_days), disable: this.destination.dateBlock, disableMobile: 'true' });
						this.isLoading = false;
					})

				// var result = [];

			  	_.forEach(this.items, (value) => {
			    	if(value.allocation_id  === this.stepData.allocationSelected){
			      		this.timeslots = value.timeslot;
			    	}
			  	});
			}
		}
	}
</script>