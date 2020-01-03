export default {
    methods: {
        /**
         * Parse response array/object
         * 
         * @param  mixed result
         * @param  boolean type
         * @param  string title
         * @return string
         */
        parseResponse(result, type, title = null, options = {}) {
            /* Set needed variables */
            let message = '';
            let hasResponse = false, hasData = false, hasMultiError = false;


            if(typeof result === 'string') {
                message = result;
            }

            if(typeof result !== 'undefined') {
                /* Fetch and add in message */
                if(result.hasOwnProperty('message')) {
                    message = result.message;
                }
            }

            if(typeof result.data !== 'undefined') { //alert(result.response.status);
                if(result.data.hasOwnProperty('message') && result.data.message.length > 0) {
                    message = result.data.message;
                }
            }

            if(typeof result.response !== 'undefined') { //alert(result.response.status);
                /* Set needed checker vars; */
                hasData = result.response.hasOwnProperty('data');

                /* Fetch and add in response error message */
                if(hasData) {
                    if(result.response.data.hasOwnProperty('message') && result.response.data.message.length > 0) {
                        message = result.response.data.message;
                    }
                }

                /* Setup generic response messages only for error & warning response */
                if(type == 'error' || type == 'warning') {
                    switch(result.response.status) {
                        case 404: message = '404: Route is no longer available'; break;
                        case 405: message = '405: Request is not allowed'; break;
                        case 413: message = '413: File uploaded is too large, please upload a smaller file'; break;
                        case 419: message = '419: Authentication has expired, please refresh the page'; break;
                        case 422:

                            /* Check for errors field */
                            if(hasData) {
                                if(result.response.data.hasOwnProperty('errors')) { 
                                    let fieldsArray = result.response.data.errors; //console.log(fieldsArray);

                                    /* Set multi-line error trigger */
                                    hasMultiError = true;
                                    /* Set error var for hasError() */
                                    this.errors = fieldsArray;

                                    /* Fetch each error per item */
                                    for(let field in fieldsArray) { //console.log(field);
                                        for(let subfield in fieldsArray[field]) { //console.log(fieldsArray[field][subfield]);
                                            message += '<li>' + fieldsArray[field][subfield] + '</li>';
                                        }
                                    } //console.log(errorsMsg);
                                }
                            }

                            break;
                        case 500: message = 'Server error';
                            break;
                    }
                }
            }
            return message;
        },
    }
}