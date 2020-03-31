<template>
	<div>
        <form-request :submit-url="exportUrl" @load="load" submit-on-success method="POST" :action="exportUrl">
            <filter-box @refresh="fetch">
                <template v-slot:left>

                    <selector
                    v-if="filterDestinations"
                    class="mt-2 ml-2"
                    name="destination_id"
                    :items="filterDestinations"
                    v-model="item.destination_id"
                    @change="destinationChanged()"
                    placeholder="Filter by destination"
                    ></selector>

                    <selector
                    v-if="filterAllocations"
                    class="mt-2 ml-2"
                    name="allocation_id"
                    :items="filterAllocations"
                    @change="filter($event, 'status')"
                    placeholder="Filter by experience"
                    ></selector>

                    <selector
                    v-if="filterCategories"
                    class="mt-2 ml-2"
                    name="category"
                    :items="filterCategories"
                    @change="filter($event, 'status')"
                    placeholder="Filter by status"
                    ></selector>

                    <selector
                    v-if="filterTypes"
                    class="mt-2 ml-2"
                    name="booking_type"
                    :items="filterTypes"
                    @change="filter($event, 'status')"
                    placeholder="Filter by booking type"
                    ></selector>

                    <date-range
                    class="mr-2"
                    @change="filter($event)"
                    ></date-range>
                    
                    <action-button v-if="exportUrl" type="submit" :disabled="loading" class="btn-warning mr-2" icon="fa fa-download">Export</action-button>

                </template>
            </filter-box>
        </form-request>


        <loader 
        :loading="loading">
        </loader>
	</div>
</template>

<script type="text/javascript">
import ListMixin from 'Mixins/list.js';
import { EventBus }from '../../../EventBus.js';

import SearchForm from 'Components/forms/SearchForm.vue';
import DateRange from 'Components/datepickers/DateRange.vue';
import ActionButton from 'Components/buttons/ActionButton.vue';
import ViewButton from 'Components/buttons/ViewButton.vue';
import Select from 'Components/inputs/Select.vue';
import FormRequest from 'Components/forms/FormRequest.vue';

export default {
    methods: {
        init(data) {
            console.log(data);
        },
        
        update() {
            this.fetch();
        },

        destinationChanged() {
            _.forEach(this.filterDestinations, (destination) => {
                if(destination.value === parseInt(this.item.destination_id)){
                    this.filterAllocations = destination.allocations;
                }
            })
        }
    },

    mounted() {
        // this.fetch();
    },

    props: {
        filterCategories: {},
        filterTypes: {},
        filterDestinations: {},
        exportUrl: String,
    },

    data() {
        return {
            filterAllocations: [],
            item: {},
        }
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'date-range': DateRange,
        'selector': Select,
        'form-request': FormRequest,
    },
}
</script>