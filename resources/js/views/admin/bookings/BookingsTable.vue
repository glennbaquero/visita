<template>
    <div>
        <filter-box @refresh="fetch">
            <template v-slot:left>
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
                    <td>
                        <a :href="item.qr_path" target="_blank">
                            <img :src="item.qr_path" width="100px" class="rounded img-fluid img-thumbnail">
                            {{ item.qr_id }}
                        </a>
                    </td>
                    <td>{{ item.main_contact.fullname }}</td>
                    <td>{{ item.total_guest }}</td>
                    <td>{{ item.time }}</td>
                    <td>{{ item.allocation }}</td>
                    <td>{{ item.main_contact.type }}</td>
                    <td>{{ item.is_walkin }}</td>
                    <td>{{ item.status }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                        <view-button :href="item.showUrl+'/'+selectedDate+'/'+destination+'/'+experience+'/'+destinationName"></view-button>
                        
                        <action-button
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
                        ></action-button>
                    </td>
                </tr>
            </template>

        </data-table>

        <loader :loading="loading"></loader>
    </div>
</template>

<script type="text/javascript">
import ListMixin from '../../../mixins/list.js';

import SearchForm from '../../../components/forms/SearchForm.vue';
import ActionButton from '../../../components/buttons/ActionButton.vue';
import ViewButton from '../../../components/buttons/ViewButton.vue';

export default {
    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id' },
                { text: 'QR', value: 'qr_id' },
                { text: 'Point Person', value: 'fullname' },
                { text: 'Total Guest', value: 'total_guest' },
                { text: 'Time', value: 'time' },
                { text: 'Experience', value: 'allocation' },
                { text: 'Type', value: 'type' },
                { text: 'Walk In', value: 'is_walkin' },
                { text: 'Status', value: 'status' },
            ];


            array = array.concat([
                { text: 'Created Date', value: 'created_at' },
            ]);

            return array;
        },
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

        selectedDate: String,
        destination: String,
        experience: String,
        destinationName: String,
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
    },
}
</script>