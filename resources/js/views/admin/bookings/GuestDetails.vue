<template>
	<div>
		<div class="row"  >
			<div class="form-group col-sm-12 col-md-12">
				<h3>
					<b>
						Guest #{{ index }} 

						<button type="button" class="btn btn-danger" @click="removeGuest(index)"><i class="fas fa-minus"></i></button> 
					</b>
				</h3> 
			</div>
			<div class="form-group col-sm-12 col-md-4">
				<label>Firstname</label>
				<input v-model="guest.first_name" name="guest_first_name[]" type="text" class="form-control">
				<input v-model="guest.id" name="guest_id[]" type="text" class="form-control" v-show="hide">
			</div>
			<div class="form-group col-sm-12 col-md-4">
				<label>Lastname</label>
				<input v-model="guest.last_name" name="guest_last_name[]" type="text" class="form-control">
			</div>
			<selector class="col-sm-4"
			v-model="guest.nationality"
			name="guest_nationality[]"
			label="Nationality"
			:items="nationalities"
			item-value="citizenship"
			item-text="citizenship"
			placeholder="Select Nationality"
			></selector>
			<div class="form-group col-sm-12 col-md-4">
				<label>Email</label>
				<input v-model="guest.email" name="guest_email[]" type="email" class="form-control">
			</div>
			
			<date-picker
			v-model="guest.birthdate"
			class="form-group col-sm-12 col-md-4"
			label="Birthday"
			:enableTime="false"
			name="guest_birthdate[]"
			placeholder="Choose a Birthday"
			maxDate="today"
			></date-picker>

			<selector class="col-sm-4"
			v-model="guest.gender"
			name="guest_gender[]"
			label="Gender"
			:items="genders"
			item-value="name"
			item-text="name"
			placeholder="Select Gender"
			></selector>
		</div>
	</div>
</template>
<script>
	import Datepicker from '../../../components/datepickers/Datepicker.vue';
	import Select from '../../../components/inputs/Select.vue';

	export default {
		props: {
			guest: Object,
			nationalities: Array,
			index: Number,
			genders: Array
		},

		data() {
			return {
				date: null,
				hide: false
			}
		},

		components: {
			'selector': Select,
			'date-picker': Datepicker,
		},
	}
</script>