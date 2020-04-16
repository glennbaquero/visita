<template>
	<div>
        
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Destination</label>
                    <select class="form-control" v-model="destination" @change="destinationChange()">
                        <option v-for="destination in destinations" :value="destination">{{ destination.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Experience</label>
                    <select class="form-control" v-model="experience" @change="init()">
                        <option v-for="experience in experiences" :value="experience.id"> {{ experience.name }} </option>
                    </select>
                </div>
            </div>
        </div>

		<full-calendar v-if="destination && experience" :events="events" :editable="false" :header="header" :config="config" @day-click="selectedDay" defaultView="month"/>
	</div>
</template>

<script type="text/javascript">
import { EventBus }from '../../../EventBus.js';

import { FullCalendar } from 'vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.css';

import ResponseHandler from '../../../mixins/response.js';

import SearchForm from '../../../components/forms/SearchForm.vue';
import Select from '../../../components/inputs/Select.vue';
import Loader from '../../../components/loaders/Loader.vue';

export default {
	props: {
		fetchUrl: String,
		fetchBookingsUrl: String,
        destinations: Array
	},

	data() {
	    return {
	    	events: [],
	      	config: {},
	      	header: {
	      		center: "title",
				left: "prev today",
				right: 'next'
	      	},
            loading: false,
            destination: null,
            experiences: [],
            experience: null
	  	}
	},

    components: {
        'search-form': SearchForm,
        'selector': Select,
        FullCalendar
    },

    mixins: [ ResponseHandler ],

    mounted() {
        if(!_.isEmpty(JSON.parse(window.sessionStorage.getItem('destination')))) {
            this.destination = JSON.parse(window.sessionStorage.getItem('destination'));
            this.experiences = this.destination.allocations;
        }
    	// this.init();
    },

    methods: {
    	init() {
            this.loading = true;
            var data = {
                destination_id : this.destination.id,
                allocation_id : this.experience
            };

    		axios.post(this.fetchUrl, data)
    			.then((response) => {

    				if(response.status === 200) {
    					this.events = response.data.items
			            this.loading = false;
    				}
    			}).catch((error) => {
		            this.loading = false;
    				this.parseError(error);
    			})
    	},

    	selectedDay(e) {
    		var data = {
    			selectedDate: moment(e).format('Y-MM-DD')
    		};

    		axios.post(this.fetchBookingsUrl, data)
    			.then((response) => {
    				if(response.status === 200) {
    					window.location.href = response.data.showBookingsUrl+'/'+moment(e).format('Y-MM-DD')+'/'+this.destination.id+'/'+this.experience+'/'+this.destination.name;
    				}
    			}).catch((error) => {
    				this.parseError(error);
    			})
    	},

        destinationChange() {

            window.sessionStorage.setItem('destination', JSON.stringify(this.destination));

            // if(!_.isEmpty(JSON.parse(window.sessionStorage.getItem('destination')))) {
            //     this.destination = JSON.parse(window.sessionStorage.getItem('destination'));
            // }
            this.experiences = !_.isEmpty(this.destination) ? this.destination.allocations : null;
        }
    }
}
</script>