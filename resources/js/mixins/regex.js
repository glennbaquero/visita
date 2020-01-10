export default {
	methods: {
		regexNumber(evt) {
			evt = (evt) ? evt : window.event;
	      	var charCode = (evt.which) ? evt.which : evt.keyCode;
	      	if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
	       	 	evt.preventDefault();
	      	} else {
	        	return true;
	      	}
		},

		regexString(evt) {
			evt = (evt) ? evt : window.event;
	      	var charCode = (evt.which) ? evt.which : evt.keyCode;
	      	if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
	       	 	return true;
	      	} else {
	       	 	evt.preventDefault();;
	      	}
		},

		capitalize(val) {
			val = val.split(' ').map(eachWord=>
			      eachWord.charAt(0).toUpperCase() + eachWord.slice(1)
			    ).join(' ');
		}
	}
}