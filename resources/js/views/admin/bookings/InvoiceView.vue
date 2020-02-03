<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
		<card>
      <template v-slot:header>Reservation Payment Information</template>

			<div class="row">
        <div class="col-12">
          <h3><b>{{ item.reservation_from }}</b></h3>
        </div>
				<div class="col-12 table-responsive">
                  	<table class="table table-striped">
                    	<thead>
                    		<tr>
                      			<th class="text-center">#</th>
                      			<th class="text-center">Visitor Name</th>
                      			<th class="text-center">Visitor Type</th>
                      			<th class="text-center">Daytour/Overnight Fee</th>
                      			<th class="text-center">Weekday/Weekend Fee</th>
                      			<th class="text-center">Special Fee</th>
                      			<th class="text-center">Daytour/Overnight Fee</th>
                      			<th class="text-center">Weekday/Weekend Fee</th>
                      			<th class="text-center">Total</th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		<tr v-for="(guest,key) in item.guests">
                      			<td class="text-center">{{ key+1 }}</td>
                      			<td class="text-center">{{ guest.name }}</td>
                      			<td class="text-center">{{ guest.visitor_type_name }}</td>
                      			<td class="text-center">{{ guest.type_daytourOrOvernight_fee }}</td>
                      			<td class="text-center">{{ guest.type_weekdayOrWeekend_fee }}</td>
                      			<td class="text-center">{{ guest.special_fee_name }}</td>
                      			<td class="text-center">{{ guest.special_fee_daytourOrOvernight }}</td>
                      			<td class="text-center">{{ guest.special_fee_weekdayOrWeekend }}</td>
                      			<td class="text-center">{{ guest.total }}</td>
                    		</tr>
                    		<tr v-if="!item.from_masungi_reservation">
                      			<td class="text-center"></td>
                      			<td class="text-center"></td>
                      			<td class="text-center"></td>
                      			<td class="text-center"></td>
                      			<td class="text-center"></td>
                      			<td class="text-center"></td>
                      			<td class="text-center"></td>
                      			<td class="text-center"><b>Total</b></td>
                      			<td class="text-center"><b>{{ item.conservation_fee }}</b></td>
                    		</tr>
                    	</tbody>
                  	</table>
                </div>
			</div>
			<div class="row">
          <!-- accepted payments column -->
        <div class="col-6">
          <p class="lead">Payment Method:</p>
          <img src="images/paynamics" width="15%" alt="Paypal" v-if="item.is_paypal_payment"> 

          	<label v-if="!item.is_paypal_payment"><b>Bank Deposit</b></label>
          	<br>
          	<template v-if="item.showImgTag">
          		<p>Uploaded Deposit Slip <a :href="item.renderDepositSlip" target="_blank">view here</a></p>
          		<!-- <img :src="item.renderDepositSlip"> -->
      		</template>
        </div>
          <!-- /.col -->
        <div class="col-6">
          	<p class="lead">Amount</p>

          <div class="table-responsive">
              <table class="table">
                	<tr>
                  	<th style="width:50%">Conservation Fee</th>
                  	<td>&#8369; {{ item.conservation_fee }}</td>
                	</tr>
                	<tr>
                  	<th>Platform Fee</th>
                  	<td>&#8369; {{ item.platform_fee }}</td>
                	</tr>
                	<tr>
                  	<th>Sub Total</th>
                  	<td>&#8369; {{ item.sub_total }}</td>
                	</tr>
                	<tr>
                  	<th>Transaction Fee</th>
                  	<td>&#8369; {{ item.transaction_fee }}</td>
                	</tr>
                	<tr>
                  	<th>Total</th>
                  	<td><b>&#8369; {{ item.grand_total }}</b></td>
                	</tr>
              </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
			<template v-slot:footer>
				<action-button type="submit" :disabled="loading" class="btn-success" v-if="!item.is_paid">Approve</action-button>
            	
        <action-button
        v-if="item.archiveUrl && !item.is_paid"
        color="btn-danger"
        alt-color="btn-warning"
        :action-url="item.archiveUrl"
        label="Reject"
        :show-alt="item.deleted_at"
        confirm-dialog
        title="Reject"
        :message="'Are you sure you want to reject this reservation #' + item.id + '?'"
        :disabled="loading"
        @load="load"
        @success="fetch"
        @error="fetch"
        ></action-button>
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</form-request>
</template>

<script type="text/javascript">
import { EventBus }from '../../../EventBus.js';
import CrudMixin from '../../../mixins/crud.js';

import ActionButton from '../../../components/buttons/ActionButton.vue';
import Select from '../../../components/inputs/Select.vue';
import ImagePicker from '../../../components/inputs/ImagePicker.vue';
import TextEditor from '../../../components/inputs/TextEditor.vue';
import Datepicker from '../../../components/datepickers/Datepicker.vue';
import TimePicker from '../../../components/timepickers/Timepicker.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
		},
	},

	data() {
		return {
			item: [],
		}
	},

	components: {
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
		'date-picker': Datepicker,
		'time-picker': TimePicker,
	},

	mixins: [ CrudMixin ],
}
</script>