<template>
	<div class="form-group">
		<label>{{ label }} <small v-if="note" class="text-danger">({{ note }})</small></label>
		<template v-if="mode == 'single'">
			<input ref="elem" :name="name" :placeholder="placeholder" type="text" class="form-control" readonly>
		</template>
		<template v-if="mode == 'multiple'">
			<input ref="elem" :placeholder="placeholder" type="text" class="form-control" readonly>
			<input v-for="date in value" :name="name" :value="date" type="hidden">
		</template>

		<template v-if="mode == 'range'">
			<input ref="elem" :placeholder="placeholder" type="text" class="form-control" readonly>
			<input v-for="date in value" :name="name" :value="date" type="hidden">
		</template>
	</div>
</template>

<script type="text/javascript">
/* Flatpickr Documentation: https://flatpickr.js.org/options/ */
import flatpickr from 'flatpickr';
// window.flatpickr = flatpickr;
import 'flatpickr/dist/flatpickr.css';

import ArrayHelpers from '../../mixins/array.js';

export default {
	watch: {
		value(value, oldValue) {
			if (!oldValue) {
				this.elem.setDate(value);
			}
		},
	},

	mounted() {
		this.setup();
	},

	methods: {
		setup() {
			let options = this.getOptions();
			var $this = this;
			console.log(options);
			this.elem = flatpickr(this.$refs.elem, options);
		},

		getOptions() {
			let $this = this;

			let options = {
				enableTime: this.enableTime,
				dateFormat: this.dateFormat,
				noCalendar: this.noCalendar,
				mode: this.mode,
				onChange(selectedDates, dateStr, instance) {
					let date = dateStr;

					switch ($this.mode) {
						case 'multiple':
								date = date.split(', ');
							break;
					}

					$this.$emit('change', date);
				},
				"disable": [
			        (date) => {
			        	if (this.disabledDates) {
			        		var day = date.getDate();

			        		var month = date.getMonth()+1; 
			        		var year = date.getFullYear();

			        		if(day < 10) 
			        		{
			        		    day = '0'+day;
			        		} 

			        		if(month < 10) 
			        		{
			        		    month = '0'+month;
			        		} 

			        		var date = year+'-'+month+'-'+day;

			        		if (this.inArray(date, this.disabledDates)) {
				        		return true;
				        	}	
			        	}

			        	if (this.disabledDays) {
				        	if (this.inArray(date.getDay(), this.disabledDays)) {
				        		return true;
				        	}
			        	}

			        	return false;
			        }
			    ],
			};

			if (this.minDate) {
				options.minDate = this.minDate;
			}

			if (this.maxDate) {
				options.maxDate = this.maxDate;
			}

			if (this.defaultDate) {
				options.defaultDate = this.defaultDate;
			}

			return options;
		},
	},

	props: {
		label: String,

		placeholder: String,

		name: String,

		note: String,

		placeholder: {
			default: null,
		},

		/* 'single', 'multiple,', 'range' */
		mode: {
			default: 'single',
			type: String,
		},

		enableTime: {
			default: true,
		},

		noCalendar: {
			default: false,
			type: Boolean,
		},

		dateFormat: {
			default: 'Y-m-d H:i:S',
			type: String,
		},

		value: {},

		defaultDate: {},

		minDate: {},
		maxDate: {},

		disabledDays: {},
		disabledDates: {},
	},

	data() {
		return {
			//
		}
	},

	model: {
        prop: 'value',
        event: 'change', 
    },

    mixins: [ ArrayHelpers ],
}
</script>

<style scoped>
.form-control[readonly] {
	background-color: #fff;
}
</style>