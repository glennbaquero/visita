<template>
	<div>
		<div class="inlineBlock-parent l-margin-b">
			<div class="width--50">
				<p class="frm-header s-margin-b bold clr--green">Booking History</p>
			</div
			><div class="width--50 align-r inlineBlock-parent">
				<p class="frm-header bold clr--gray s-margin-b s-margin-r">Sort by:</p>
				<div class="frm-inpt frm-inpt__filter">
					<select>
						<option>Date</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="inlineBlock-parent">
			
			<div class="dshbrd-frm1__content-card" v-for="item in items">
				<div class="width--85 margin-a align-l">

					<div class="inlineBlock-parent m-margin-b">
						<div class="width--50">
							<p class="frm-header bold clr--gray">Destination:</p>
						</div
						><div class="width--50">
							<p class="frm-header clr--gray">{{ item.destination }}</p>
						</div>
					</div>

					<div class="inlineBlock-parent m-margin-b">
						<div class="width--50">
							<p class="frm-header bold clr--gray">Date:</p>
						</div
						><div class="width--50">
							<p class="frm-header clr--gray">{{ item.scheduled_at }}</p>
						</div>
					</div>

					<div class="inlineBlock-parent m-margin-b">
						<div class="width--50">
							<p class="frm-header bold clr--gray">Guest #:</p>
						</div
						><div class="width--50">
							<p class="frm-header clr--gray">{{ item.total_guest }} person/s</p>
						</div>
					</div>

					<div class="inlineBlock-parent m-margin-b">
						<div class="width--50">
							<p class="frm-header bold clr--gray">Status:</p>
						</div
						><div class="width--50">
							<p class="frm-header dshbrd-frm1__content-card-book-status" :class="item.status_class">{{ item.status_label }}</p>
						</div>
					</div>

					<div class="inlineBlock-parent m-margin-b">
						<div class="width--50">
							<p class="frm-header bold clr--gray">Payment Total:</p>
						</div
						><div class="width--50">
							<p class="frm-header clr--gray">Php {{ withComma(item.total) }}</p>
						</div>
					</div>

					<div class="align-c">
						<!-- data-remodal-target="view-info-modal" -->
						<button class="frm-btn green" @click="viewMore(item)">View More</button>
					</div>

				</div>

			</div
			>
		</div>

		<!-- {{-- Modal --}} -->
		<div id="gnrl-rmdl" class="remodal" data-remodal-id="view-info-modal">
			<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
				<img src="images/close-button.png" class="gnrl-rmdl__close-btn-img">
			</button>
			<div class="width--100 m-margin-t align-l">
				
				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray s-margin-r">Destination:</p>
					<p class="frm-header clr--gray">{{ item.destination }}</p>
				</div>

				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray s-margin-r">Date:</p>
					<p class="frm-header clr--gray">{{ item.scheduled_at }}</p>
				</div>

				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray s-margin-r">Guest #:</p>
					<p class="frm-header clr--gray">{{ item.total_guest }} person/s</p>
				</div>

				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray s-margin-r">Status:</p>
					<p class="frm-header bold clr--green">{{ item.status_label }}</p>
				</div>

				<div class="inlineBlock-parent">
					<p class="frm-header bold clr--gray s-margin-r">Payment Total:</p>
					<p class="frm-header clr--gray">Php {{ withComma(item.total) }}</p>
				</div>

				<div class="inlineBlock-parent" v-if="item.showImgTag">
					<p class="frm-header bold clr--gray s-margin-r">Recently Uploaded Deposit Slip:</p>
					<p class="frm-header bold clr--green"><a :href="item.deposit_slip" target="_blank">View Here</a></p>
				</div>

				<div class="align-c" v-if="!item.is_paid && item.is_approved && item.is_paypal_payment">
					<button class="frm-btn green" @click="processPayment()">Pay Now</button>
				</div>
				<div class="align-c" v-if="!item.is_paid && item.is_approved && !item.is_paypal_payment && item.deposit_slip_approve != 2">
					<input type="file" class="frm-btn green" @change="uploadDepositSlipChange">
				</div>

			</div>
		</div>	
		<!-- {{  }} -->
		<loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
		<SuccessErrorModal :message="message" :icon="iconToShow"></SuccessErrorModal>
		<paynamics-form
		ref="paynamics-form"
		></paynamics-form>
	</div>
</template>
<script>
	import NumberMixin from 'Mixins/number.js';
	import ResponseMixin from 'Mixins/errorResponse.js';
	import prx_paypal_mixin from '../../../../../public/vendor/praxxys/ecommerce/paypal/js/vue-mixin.js';
	import SuccessErrorModal from '../partials/SuccessErrorModal.vue';
	import PaynamicsForm from './components/PaynamicsForm.vue';

	export default {
		props: {
			fetchUrl: String,
			processPaymentUrl: String,
			uploadDepositSlipUrl: String,
		},

		mixins: [ NumberMixin, prx_paypal_mixin, ResponseMixin ],

		components: {
	        Loading,
	        SuccessErrorModal,
	        PaynamicsForm
		},

		data() {
			return {
				items: [],
				item: {},
				image: null,
				isLoading: false,
             	fullPage: true,
             	message: null,
             	iconToShow: null
			}
		},

		mounted() {
			this.init();
		},

		methods: {
			init() {
				axios.get(this.fetchUrl)
					.then(response => {
						this.items = response.data.items;
					})
			},

			viewMore(item) {
				var showItemModal = $('[data-remodal-id=view-info-modal]').remodal();
				this.item = item;
				showItemModal.open();
			},

			processPayment() {
				var data = {
					id: this.item.id
				};

				axios.post(this.processPaymentUrl, data)
					.then(response => {
						var data = response.data;
                        let form = this.$refs['paynamics-form'];
                        form.setVars(data.paynamics_url, data.signature);
                        form.submit();
					})
				// this.PRXPayPalSubmit(this.buildItems(), this.item.reference_code, 'PHP');
			},

			buildItems() {
				const items = []; 
				var total = parseFloat(this.item.total);
				items.push({name: 'Visita Reservation', price: total, qty: 1});
				return items;
			},

			uploadDepositSlipChange(e) {
				var showItemModal = $('[data-remodal-id=view-info-modal]').remodal();
				var showSuccessErrorModal = $('[data-remodal-id=success-modal]').remodal();
				showItemModal.close();

				this.isLoading = true;
				var files = e.target.files || e.dataTransfer.files;

	            if(!files.length)
	                return;

	            this.image = files[0];
	            var data = new FormData();

	            data.append('bank_deposit_slip', files[0]);
	            data.append('id', this.item.id);

	            axios.post(this.uploadDepositSlipUrl, data)
	        		.then(response => {
	        			this.isLoading = false;
	        			this.message = 'Deposit Slip Uploaded! Kindly wait us to review the deposit slip. Thank you!';
	        			this.iconToShow = 'images/success-icon.png';
	        			showSuccessErrorModal.open();
	        			this.init();
	        		}).catch(errors => {
	        			this.isLoading = false;
						this.message = this.parseResponse(errors, 'error');
						this.iconToShow = 'images/remove-button.png';
	        			showSuccessErrorModal.open();
	        		})
			}
		}
	}
</script>