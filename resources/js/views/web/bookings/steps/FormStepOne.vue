<template>
	<div>
		<div class="rqst-frm1__steps-form-cards">
			<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
				<div class="align-l m-margin-b">
					<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
					<hr>

					<p class="frm-header bold s-margin-b clr--gray">Visit Date</p>
					<div class="frm-inpt m-margin-b">
						<input type="date" v-model="stepData.visitDate">
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Select Experience</p>
					<div class="frm-inpt m-margin-b">
						<select v-model="stepData.experienceSelected">
							<option v-for="experience in destination.experiences" :value="experience.id" >{{ experience.name }}</option>
						</select>
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Number of guest/s</p>
					<div class="frm-inpt m-margin-b">
						<input type="number" v-model="stepData.numberOfGuests" min="0">
					</div>

					<p class="frm-header bold s-margin-b clr--gray">Time</p>
					<div class="frm-inpt m-margin-b">
						<!-- <input type="time"> -->
						<select v-model="stepData.timeSelected">
							<option value="id" >6:30</option>
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
	export default{
		props: {
			destination: Object,
			stepData: Object
		},

		data() {
			return {
				
			}
		}
	}
</script>