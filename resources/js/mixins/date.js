export default {
	methods: {
		toDate(value, format='MMM D, YYYY') {
			let result = '';

			if (moment(value).isValid()) {
				result = moment(value).format(format);
			}

			return result;
		},

		toTime(value, format='HH:mm') {
			let result = '';
			
			if (moment(value).isValid()) {
				result = moment(value).format(format);
			} else {
				result = moment(value, format).format(format)
			}

			return result;
		},

		fromNow(value) {
			let result = '';
			
			if (moment(value).isValid()) {
				result = moment(value).fromNow();
			}

			return result;
		},

		moment() {
			return {
				getPastYear(years = 1) {
					return moment(new Date).subtract(years, 'years').format('YYYY-MM-D');
				},
			};
		},
	},
}