<template>
	<div>
		<div class="rqst-frm1__step-4-content">
			
			<div class="align-l m-margin-b">
				<h5 class="frm-title small clr--gray">Payment Method</h5>
			</div>
			<hr>

			<!-- COMMENT_ME -->
			<!-- <div class="rqst-frm1__step-4-content-checkbox">
				<label class="rqst-frm1__step-4-content-checkbox-container align-l inlineBlock-parent" style="box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.25)">
					<div class="width--100">
						<div class="width--100">
							<div class="frm-inpt">
								<select v-model="selectedPaymentGateway">
									<option v-for="fee in transactionFees" :value="fee"> {{ fee.name }} </option>
								</select>
							</div>
						</div>
					</div
					>
				</label>
			</div> -->
			<!-- END_COMMENT_ME -->

			<div class="rqst-frm1__step-4-content-checkbox gnrl-scrll">
				<label class="rqst-frm1__step-4-content-checkbox-container align-l inlineBlock-parent" v-for="fee in transactionFees">
					<div class="width--10">
						<input type="radio" name="payment" :value="fee" v-model="selectedPaymentGateway">
						<span class="checkmark"></span>
					</div
					><div class="width--50">
						<p class="frm-header clr--gray">{{ fee.name }}</p>
					</div
					><div class="width--40 align-r">
						<img
						  class="rqst-frm1__step-4-content-checkbox-img" 
						  :src="fee.full_image"
						>
					</div>
				</label>
			</div>

			<div class="align-l m-margin-b l-margin-t">
				<h5 class="frm-title small clr--gray">Fees</h5>
			</div>
			<hr>
				
			<div class="inlineBlock-parent align-l m-margin-b">
				<div class="rqst-frm1__step-4-content-select-holder" @click="showOption">
					<div class="rqst-frm1__step-4-content-select">
						<div class="width--95 margin-a inlineBlock-parent">
							<div class="width--50 inlineBlock-parent">
								<p class="frm-header clr--gray s-margin-r">Conservation Fees</p>
								<div class="rqst-frm1__step-4-content-info-holder">
									<img 
									  class="rqst-frm1__step-4-content-info-icon" 
									  src="images/info-icon.png"
									>
									<div class="rqst-frm1__step-4-content-info-position">
										<div class="rqst-frm1__step-4-content-info">
											<div class="width--90 margin-a frm-description clr--white">
												<p><span v-html="info.conservation_fee_info"></span></p>
											</div>
										</div>
									</div>
								</div>

							</div
							><div class="width--50 align-r">
								<p class="frm-header bold clr--gray s-margin-r">Php {{ withComma(conservationFeeTotal) }}</p>
							</div>
						</div>
					</div>
					<div class="rqst-frm1__step-4-content-select-option" :style="{ display : showOptionStyle }">
						<div class="width--95 margin-a">
							
							<div class="inlineBlock-parent rqst-frm1__step-4-content-option" v-for="type in visitorTypeList">
								<div class="width--50">
									<p class="frm-header clr--gray">Guest #{{ type.number }} : {{ type.name }}</p>
								</div
								><div class="width--50 align-r">
									<p class="frm-header clr--gray">Php {{ withComma(type.fee) }}</p>
								</div>
							</div>
							
							<div class="inlineBlock-parent rqst-frm1__step-4-content-option" v-for="special in specialFeeTypeList">
								<div class="width--50">
									<p class="frm-header clr--gray">Guest #{{ special.number }} : {{ special.name }}</p>
								</div
								><div class="width--50 align-r">
									<p class="frm-header clr--gray">Php {{ withComma(special.fee) }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="inlineBlock-parent m-margin-b">
				<div class="width--50 align-l align-t">
					<div class="inlineBlock-parent">
						<p class="frm-header clr--gray s-margin-b s-margin-r">Platform Support Fees</p>

						<div class="rqst-frm1__step-4-content-info-holder s-margin-b">
							<img 
							  class="rqst-frm1__step-4-content-info-icon" 
							  src="images/info-icon.png"
							>
							<div class="rqst-frm1__step-4-content-info-position">
								<div class="rqst-frm1__step-4-content-info">
									<div class="width--90 margin-a frm-description clr--white">
										<p><span v-html="info.platform_fee_info"></span></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <p class="frm-header clr--gray s-margin-b">{{ stepData.guests.length }} Guests x Php {{ allocation.platform_fee }}</p> -->
				</div
				><div class="width--50 align-r align-t">
					<p class="frm-header bold clr--gray s-margin-b">Php {{ withComma(platformFee) }}</p>
				</div>
			</div>

			<div class="inlineBlock-parent rqst-frm1__step-4-content-subtotal">
				<div class="width--50 align-l align-t">
					<p class="frm-header bold clr--light-gray">Subtotal</p>
				</div
				><div class="width--50 align-r align-t">
					<p class="frm-header bold clr--light-gray">Php {{ withComma(subTotal) }}</p>
				</div>
			</div>
			<hr>

			<div class="inlineBlock-parent l-margin-b align-l">
				<div class="width--50 align-l align-t">
					<div class="inlineBlock-parent">
						<p class="frm-header clr--gray s-margin-b s-margin-r">Transaction Fees</p>

						<div class="rqst-frm1__step-4-content-info-holder s-margin-b">
							<img 
							  class="rqst-frm1__step-4-content-info-icon" 
							  src="images/info-icon.png"
							>
							<div class="rqst-frm1__step-4-content-info-position">
								<div class="rqst-frm1__step-4-content-info">
									<div class="width--90 margin-a frm-description clr--white">
										<p><span v-html="info.transaction_fee_info"></span></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div
				><div class="width--50 align-r align-t">
					<p class="frm-header bold clr--gray s-margin-b">Php {{ withComma(transactionFee) }}</p>
				</div>
			</div>

			<div class="inlineBlock-parent">
				<div class="width--50 align-l">
					<h5 class="frm-title x-small clr--gray">Total</h5>
				</div
				><div class="width--50 align-r">
					<h5 class="frm-title x-small clr--gray">Php {{ withComma(grandTotal) }}</h5>
				</div>
			</div>
			
			<hr>

			<div class="rqst-frm1__step-4-content-terms">
				<div class="align-l">
					<h5 class="frm-title x-small clr--gray m-margin-b l-margin-t">Terms & Conditions of the Visit</h5>
				</div>

				<div class="frm-description l-margin-b">
					<span v-html="destination.terms_conditions"></span>
				</div>

				<div class="inlineBlock-parent align-l m-margin-b">
					<input type="checkbox" @click="$emit('terms_conditions_click')" v-model="isAccepted.termsAndConditions">
					<h5 class="frm-header clr--gray">I agree to the <a href="/read/terms_and_conditions" target="_blank">Terms and Conditions, Changes, Refunds and Postponements and Policies.</a> I also agree to pay the total amount shown, which includes <strong>other fees.</strong></h5>
				</div>
				<div class="inlineBlock-parent align-l m-margin-b">
					<input type="checkbox" @click="$emit('privacy_policy_click')" v-model="isAccepted.privacyPolicy">
					<h5 class="frm-header clr--gray">I agree to the <a href="/read/privacy_policy" target="_blank">Privacy Policy.</a></h5>
				</div>

			</div>

		</div>
	</div>
</template>
<script>
	import DateMixin from 'Mixins/date.js';
	import NumberMixin from 'Mixins/number.js';

	export default{
		props: {
			destination: Object,
			stepData: Object,
			visitorTypes: Array,
			transactionFees: Array,
			allocation:Object,
			info:Object,
			isAccepted: Object
		},

		mixins: [ DateMixin, NumberMixin ],

		data() {
			return {
				showOptionStyle: 'none',
				visitorTypeList: [],
				specialFeeTypeList: [],
				conservationFeeTotal: 0,
				specialFeeTotal: 0,
				transactionFee: 0,
				selectedPaymentGateway: {},
				paymentGatewayCode: null,
				isPaypal: true, // true - paypal, false - bank deposit,
			}
		},

		computed: {
			platformFee() {
				var guests = this.stepData.guests.length;
				var platform_fee = parseFloat(this.allocation.platform_fee);
				var fee = guests * platform_fee;
				return platform_fee;
			},

			subTotal() {
				var conservationFee = this.conservationFeeTotal;
				var platformFee = this.platformFee;
				var total = conservationFee + platformFee;

				return total;
			},

			grandTotal() {
				var subTotal = this.subTotal;
				var transactionFee = parseFloat(this.transactionFee)																																																								;
				var total = subTotal + transactionFee;

				return total;
			}
		},

		watch: {
			selectedPaymentGateway(val) {
				if(val) {
					this.$parent.selectedPaymentGateway = val;
					this.paymentGatewayCode = val.code;
					var type = val.type;
					var fixed_amount = val.fixed_amount;
					var percentage_amount = val.percentage_amount / 100;
					switch(type) {
						case 'PERCENTAGE':
							this.transactionFee = percentage_amount * this.subTotal;
							break;
						case 'COMPARISON':
							var percent_amount = percentage_amount * this.subTotal;
							if(percent_amount > fixed_amount) {
								this.transactionFee = percent_amount;
							} else {
								this.transactionFee = fixed_amount;
							}
							break;
						default:
							this.transactionFee = fixed_amount;
							break;
					}
				}
			}
		},

		mounted() {
			this.conservationFeeForVisitorType();
			this.specialFee();
			this.conservationFeeTotal = this.conservationFeeTotal - this.specialFeeTotal;
			this.selectedPaymentGateway = _.isEmpty(this.$parent.selectedPaymentGateway) ? null : this.$parent.selectedPaymentGateway;

			$('.rqst-frm1__step-4-content-checkbox-container').on('click', function(){
				$('.rqst-frm1__step-4-content-checkbox-container').removeClass('active');
				$(this).addClass('active');
			});

			var information = $('.rqst-frm1__step-4-content-info-icon');

 			information.hover(function(e) {
				$(this).next().fadeIn(200);
			}, function(e) {
				$(this).next().fadeOut(200);
			});

			// $('*').not('.rqst-frm1__step-4-content-info-icon').on('touchstart', function(){ 
			// 	$(this).next().fadeOut(200);
			// })

			var $window = $(window);
				$window.scroll(function () {
				if ($window.scrollTop() > 0) {
					$('.rqst-frm1__steps-header, .rqst-frm1__steps-form-cards').addClass('scroll');
				} else {
					$('.rqst-frm1__steps-header, .rqst-frm1__steps-form-cards').removeClass('scroll');
				}
			});

		},

		methods: {
			showOption() {
				if(this.showOptionStyle == 'none') {
					this.showOptionStyle = 'block';
				} else {
					this.showOptionStyle = 'none';
				}
			},

			specialFee() {
				var result = 0;
				var fee = 0;
				var visitDate = moment(this.stepData.visitDate + " " + this.stepData.timeSelected);
				var is_daytour = visitDate.hours() > 12 ? false : true ;
				var is_weekend = (visitDate.day() === 6) || (visitDate.day() === 0);

				_.forEach(this.allocation.special_fees, (value) => {
					if(is_daytour){
						fee = parseFloat(value.daytour);
					} else {
						fee = parseFloat(value.overnight)
					}

					if(is_weekend) {
						fee += parseFloat(value.weekend);
					} else {
						fee += parseFloat(value.weekday);
					}

					// if(value.id == this.stepData.main.special_fee_id){
						// result += parseFloat(value.daytour);

						// var data = {
						// 	name: value.name,
						// 	fee: fee,
						// 	count: 1
						// };

						// this.specialFeeTotal += fee;

						// this.specialFeeTypeList.push(data)

						_.forEach(this.stepData.guests, (guest, guestKey) => {
						if(value.id == guest.special_fee_id){
							result += parseFloat(value.daytour_fee);
							// _.forEach(this.specialFeeTypeList, (data, key) => {
								var data = {
									name: value.name,
									number: (guestKey + 1),
									fee: fee,
									count: 1
								};
								// if(value.name === data.name) {
								// 	data.count += 1;
								// 	this.specialFeeTypeList[key].count += 1;
								// 	this.specialFeeTypeList[key].fee += fee;
								//	this.specialFeeTotal += fee;
								// } else {
									this.specialFeeTypeList.push(data);
									this.specialFeeTotal += fee;
								// }
							// })
						}
					})
					// }
				});
			},

			conservationFeeForVisitorType() {
				var result = 0;
				var fee = 0;
				var visitDate = moment(this.stepData.visitDate + " " + this.stepData.timeSelected);
				var is_daytour = visitDate.hours() > 12 ? false : true ;
				var is_weekend = (visitDate.day() === 6) || (visitDate.day() === 0);

				_.forEach(this.visitorTypes, (value) => {

					if(is_daytour){
						fee = parseFloat(value.daytour_fee);
					} else {
						fee = parseFloat(value.overnight_fee)
					}

					if(is_weekend) {
						fee += parseFloat(value.weekend_fee);
					} else {
						fee += parseFloat(value.weekday_fee);
					}

					_.forEach(this.stepData.guests, (guest, guestKey) => {
						if(value.id == guest.visitor_type_id){
							result += parseFloat(value.daytour_fee);
							// _.forEach(this.visitorTypeList, (data, key) => {
								var data = {
									name: value.name,
									number: (guestKey + 1),
									fee: fee,
									count: 1
								};
								// if(value.name === data.name) {
								// 	data.count += 1;
								// 	this.visitorTypeList[key].count += 1;
								// 	this.visitorTypeList[key].fee += fee;
								// 	this.conservationFeeTotal += fee;
								// } else {
									this.visitorTypeList.push(data);
									this.conservationFeeTotal += fee;
								// }
							// })
						}
					})
				});
			},

			paymentSelectionChanged() {
				this.transactionFee = parseFloat(this.allocation.transaction_fee);
				
				if(!this.isPaypal) {
					this.transactionFee = 0;
				}
			}
		}
	}
</script>