<template>
    <div>
        <div class="row">
            <selector
            class="mt-2 col-md-6"
            :items="destinations"
            v-model="destination"
            item-text="name"
            item-value="id"
            @change="filter($event, 'destination'); destinationChange()"
            placeholder="Filter by destination"
            ></selector>

            <selector
            class="mt-2 col-md-6"
            :items="experiences"
            item-text="name"
            item-value="id"
            @change="filter($event, 'experience')"
            placeholder="Filter by experience"
            ></selector>
        </div>
        <filter-box @refresh="fetch">
            <template>
            </template>
            <template v-slot:right>

                <search-form
                @search="filter($event, 'search')">
                </search-form>

            </template>
        </filter-box>

        <!-- DATATABLE -->
        <data-table
        ref="data-table"
        :headers="headers"
        :filters="filters"
        :fetch-url="fetchUrl"
        :no-action="noAction"
        :disabled="disabled"
        order-by="id"
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.main_contact.fullname }}</td>
                    <td>{{ item.destination }}</td>
                    <td>{{ item.allocation }}</td>
                    <td>{{ item.total_guest }}</td>
                    <td>{{ item.time }}</td>
                    <td>{{ item.main_contact.type }}</td>
                    <td>{{ item.is_walkin }}</td>
                    <td>{{ item.status }}</td>
                    <td>{{ item.is_fullpayment }}</td>
                    <td>{{ item.initial_payment }}</td>
                    <td>{{ item.balance }}</td>
                    <td>{{ item.grand_total }}</td>
                    <td>{{ item.payment_status }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                        <view-button :href="item.showUrl+'/'+item.scheduled_at+'/'+item.destination_id+'/'+item.allocation_id+'/'+item.destination"></view-button>
                     <!--    <action-button
                        v-if="!hideButtons"
                        small 
                        color="btn-danger"
                        alt-color="btn-warning"
                        :show-alt="item.deleted_at"
                        :action-url="item.archiveUrl"
                        :alt-action-url="item.restoreUrl"
                        icon="fas fa-trash"
                        alt-icon="fas fa-trash-restore-alt"
                        confirm-dialog
                        :disabled="loading"
                        title="Archive Item"
                        alt-title="Restore Item"
                        :message="'Are you sure you want to archive this reservation? '"
                        :alt-message="'Are you sure you want to restore this reservation?'"
                        @load="load"
                        @success="sync"
                        ></action-button> -->
                    </td>
                </tr>
            </template>

        </data-table>

        <loader :loading="loading"></loader>
    </div>
</template>

<script type="text/javascript">
import ListMixin from 'Mixins/list.js';
import NumberFormat from 'Mixins/number.js';

import SearchForm from 'Components/forms/SearchForm.vue';
import ActionButton from 'Components/buttons/ActionButton.vue';
import ViewButton from 'Components/buttons/ViewButton.vue';
import Select from 'Components/inputs/Select.vue';

export default {
    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id' },
                { text: 'Point Person', value: 'fullname' },
                { text: 'Destination', value: 'destination' },
                { text: 'Experience', value: 'allocation' },
                { text: 'Total Guest', value: 'total_guest' },
                { text: 'Time', value: 'time' },
                { text: 'Type', value: 'type' },
                { text: 'Reservation Type', value: 'is_walkin' },
                { text: 'Visit Status', value: 'status' },
                { text: 'Amount Settled', value: '' },
                { text: 'Initial Payment', value: '' },
                { text: 'Succeeding Payment', value: '' },
                { text: 'Total', value: 'grand_total' },
                { text: 'Payment Status', value: 'payment_status' },
            ];


            array = array.concat([
                { text: 'Created Date', value: 'created_at' },
            ]);

            return array;
        },
    },

    data() {
        return {
            destination: null,
            experiences: [],
        }
    },

    props: {
        hideParent: {
            default: false,
            type: Boolean,
        },

        hideButtons: {
            default: false,
            type: Boolean,
        },

        destinations: Array
    },

    mixins: [ ListMixin, NumberFormat ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'selector': Select,
    },

    methods: {
        destinationChange() {
            this.experiences = [];
            _.each(this.destinations, (destination) => {
                if(destination.id == this.destination) {
                    this.experiences = destination.allocations;
                }
            })
        }
    }
}
</script>