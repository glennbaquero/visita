<template>
    <div>
        <div class="row">
            <selector
            class="mt-2 col-md-6"
            :items="new_destinations"
            v-model="destination"
            item-text="name"
            item-value="id"
            label="Filter by destination"
            @change="filter($event, 'destination'); destinationChange()"
            placeholder="Filter by destination"
            ></selector>

            <selector
            class="mt-2 col-md-6"
            :items="experiences"
            v-model="experience"
            item-text="name"
            item-value="id"
            label="Filter by experience"
            @change="filter($event, 'experience'); "
            placeholder="Filter by experience"
            ></selector>


            <selector
            class="mt-2 col-md-6"
            :items="payment_status"
            item-text="label"
            item-value="value"
            label="Filter by Payment Status"
            @change="filter($event, 'payment_status')"
            placeholder="Filter by Payment Status"
            ></selector>
            <selector
            class="mt-2 col-md-6"
            :items="payment_types"
            item-text="label"
            item-value="value"
            label="Filter by Payment Types"
            @change="filter($event, 'payment_type')"
            placeholder="Filter by Payment Types"
            ></selector>
            <selector
            class="mt-2 col-md-6"
            :items="visitor_types"
            item-text="name"
            item-value="id"
            label="Filter by Visitor Types"
            @change="filter($event, 'visitor_type')"
            placeholder="Filter by Visitor Types"
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
        order-desc
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.main_contact.fullname }}</td>
                    <td>{{ item.agency_code }}</td>
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
                    <!-- <td>
                        <select class="select__type" v-model="item.invoice_status">
                            <option v-for="action in actions" :value="action.value"> {{ action.label }} </option>
                        </select>
                    </td> -->
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
                { text: 'Point Person', value: '' },
                { text: 'Agency Code', value: 'agency_code' },
                { text: 'Destination', value: 'destination_id' },
                { text: 'Experience', value: 'allocation_id' },
                { text: 'Total Guest', value: 'total_guest' },
                { text: 'Time', value: 'start_time' },
                { text: 'Type', value: '' },
                { text: 'Reservation Type', value: 'is_walkin' },
                { text: 'Visit Status', value: ' ' },
                { text: 'Amount Settled', value: '' },
                { text: 'Initial Payment', value: '' },
                { text: 'Remaining Balance', value: '' },
                { text: 'Total', value: '' },
                { text: 'Payment Status', value: '' },
                // { text: 'Set Invoice As', value: '' },
            ];


            array = array.concat([
                { text: 'Created At', value: 'created_at' },
            ]);

            return array;
        },
    },

    data() {
        return {
            destination: null,
            experience: null,
            new_destinations: this.destinations,
            experiences: [],
            special_fees: [],
            payment_status: [
                {
                    label: 'All',
                    value: 0
                },
                {
                    label: 'Fully Paid',
                    value: 1
                },
                {
                    label: 'Initially Paid',
                    value: 2
                },
                {
                    label: 'For Approval',
                    value: 3
                },
                {
                    label: 'Rejected',
                    value: 4
                }
            ],
            payment_types: [
                {
                    label: 'All',
                    value: 0
                },
                {
                    label: 'Paypal',
                    value: 1
                },
                {
                    label: 'Paynamics',
                    value: 2
                },
                {
                    label: 'Bank Deposit',
                    value: 3
                }
            ],
            actions: [
                {
                    label: 'Fully Paid',
                    value: 1
                },
                {
                    label: 'Initially Paid',
                    value: 2
                },
                {
                    label: 'For Approval',
                    value: 3
                },
                {
                    label: 'Rejected',
                    value: 4
                },
                {
                    label: 'Expired',
                    value: 4
                }
            ],
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

        destinations: Array,
        visitor_types: Array,
    },

    mixins: [ ListMixin, NumberFormat ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'selector': Select,
    },

    mounted() {
        var all = {
            'id': 0,
            'name': 'All'
        };

        // setTimeout(() => {
            this.new_destinations.push(all);
        // }, 2000)
    },

    methods: {
        destinationChange() {
            this.experiences = [];
            _.each(this.destinations, (destination) => {
                if(destination.id == this.destination) {
                    this.experiences = destination.allocations;
                }
            })
            var all = {
                'id': 0,
                'name': 'All'
            };
            this.experiences.push(all)
        },

    }
}
</script>