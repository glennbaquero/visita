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
          <img src="images/paynamics.png" width="15%" alt="Paypal" v-if="item.is_paypal_payment"> 
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
                  	<td>&#8369; {{ withComma(item.conservation_fee) }}</td>
                	</tr>
                	<tr>
                  	<th>Platform Fee</th>
                  	<td>&#8369; {{ withComma(item.platform_fee) }}</td>
                	</tr>
                	<tr>
                  	<th>Sub Total</th>
                  	<td>&#8369; {{ withComma(item.sub_total) }}</td>
                	</tr>
                	<tr>
                  	<th>Transaction Fee</th>
                  	<td>&#8369; {{ withComma(item.transaction_fee) }}</td>
                	</tr>
                  <tr>
                    <th>Amount to Settle</th>
                    <td>{{ item.payment_settle }}</td>
                  </tr>
                  <tr>
                    <th>Initial Payment</th>
                    <td>&#8369; {{ withComma(item.amount_settled) }}</td>
                  </tr>
                  <tr>
                    <th>Remaining Balance</th>
                    <td>&#8369; {{ withComma(item.balance) }}</td>
                  </tr>
                	<tr>
                  	<th>Total</th>
                  	<td><b>&#8369; {{ withComma(item.grand_total) }}</b></td>
                	</tr>
              </table>
          </div>
        </div>
        <!-- /.col -->
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Reason</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form>
                  <div class="modal-body">
                    <text-editor
                    class="col-sm-12"
                    label=" "
                    v-model="item.rejected_reason"
                    name="rejected_reason"
                    row="5"
                    ></text-editor>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" v-if="!item.deleted_at && !item.is_paid" @click="rejectReservation()">Reject</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
      </div>
			<template v-slot:footer>
        <button type="button" v-if="!item.deleted_at && !item.is_paid" class="btn btn-danger" data-toggle="modal" data-target="#modal-default">Reject</button>
        <button type="button" v-if="item.deleted_at && !item.is_paid" class="btn btn-danger" data-toggle="modal" data-target="#modal-default">View Reason</button>
        <action-button type="submit" :disabled="loading" class="btn-success" v-if="!item.is_paid && !item.deleted_at">{{ item.btn_label }}</action-button>
        
        <!-- Bank Deposit Payment Method -->
        <button type="button" v-if="item.showButtonForBankDeposit == 'initial_button-show'" class="btn btn-primary" @click="setAsPaid('initial')">Set as paid for Initial Payment</button>
        <button type="button" v-if="item.showButtonForBankDeposit == 'final_button-show'" class="btn btn-primary" @click="setAsPaid('final')">Set as Fully Paid</button>
        <button type="button" v-if="item.showButtonForBankDeposit == 'fullpayment-final_button-show' && item.is_approved" class="btn btn-primary" @click="setAsPaid('fullpayment_final')">Set as Fully Paid</button>
        <!-- End -->
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</form-request>
</template>

<script type="text/javascript">
import { EventBus }from '../../../EventBus.js';
import CrudMixin from 'Mixins/crud.js';
import NumberFormat from 'Mixins/number.js';
import ResponseHandler from 'Mixins/response.js';

import ActionButton from 'Components/buttons/ActionButton.vue';
import Select from 'Components/inputs/Select.vue';
import ImagePicker from 'Components/inputs/ImagePicker.vue';
import TextEditor from 'Components/inputs/TextEditor.vue';
import Datepicker from 'Components/datepickers/Datepicker.vue';
import TimePicker from 'Components/timepickers/Timepicker.vue';

export default {
  props: {
    updateInitialPaymentUrl: String
  },

	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
		},

    rejectReservation() {
      this.loading = true;
      var data = {
        'rejected_reason': this.item.rejected_reason
      };

      axios.post(this.item.archiveUrl, data)
        .then(response => {
          this.fetch();
          this.loading = false;
        })
    },

    setAsPaid(payment){
      this.loading = true;
      var url = this.item.updateInitialPaymentUrl;
      if(payment == 'final') {
        url = this.item.updateFinalPaymentUrl;
      } else if(payment == 'fullpayment_final') {
        url = this.item.updateFullFinalPaymentUrl;
      }

      axios.get(url)
        .then(response => {
          this.fetch();
          this.loading = false;
        })
    }
	},

	data() {
		return {
			item: [],
      loading: false
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

	mixins: [ CrudMixin, NumberFormat, ResponseHandler ],
}
</script>