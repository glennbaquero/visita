<template>
	<div class="form-group">
		<label>{{ label }}</label>
		<template v-if="mode == 'single'">
			<input ref="elem" :name="name" :placeholder="placeholder" type="text" class="form-control" readonly>
		</template>
		<template v-if="mode == 'multiple'">
			<input ref="elem" :placeholder="placeholder" type="text" class="form-control" readonly>
			<input v-for="date in value" :name="name" :value="date" type="hidden">
		</template>
	</div>
</template>
<script type="text/javascript">
/* Flatpickr Documentation: https://flatpickr.js.org/options/ */
import flatpickr from 'flatpickr';
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
			
			if (this.defaultDate) {
				options.defaultDate = this.defaultDate;
			}

			this.elem = $(this.$refs.elem).flatpickr(options);
		},

		getOptions() {
			let $this = this;

			let options = {
				default: 'H:i',
				type: String,
				enableTime: true,
			    noCalendar: true,
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
			            return this.inArray(date.getDay(), this.disabledDays);
			        }
			    ],
			};

			if (this.minDate) {
				options.minDate = this.minDate;
			}

			return options;
		},
	},

	props: {
		label: String,

		placeholder: String,

		name: String,

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

		dateFormat: {
			default: 'H:i',
			type: String,
			enableTime: true,
		    noCalendar: true,
		},

		value: {},

		defaultDate: {},

		minDate: {},

		disabledDays: {},
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