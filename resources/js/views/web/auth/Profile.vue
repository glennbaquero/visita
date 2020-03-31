<template>
	<div>
		<div class="width--90 margin-a align-l">
			<h5 class="frm-title x-small l-margin-b clr--orange">Hello {{ user.first_name }}</h5>
			<p class="frm-header m-margin-b bold clr--green">Personal Information</p>

			<div class="inlineBlock-parent">
				
				<div class="width--33 m-margin-b">
					<div class="width--95">
						<p class="frm-header s-margin-b bold clr--gray">First Name</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="first_name" v-model="user_details.first_name">
	                    </div>
                	</div>
				</div
				><div class="width--33 m-margin-b">
					<div class="width--95 margin-a">
						<p class="frm-header s-margin-b bold clr--gray">Middle Name</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="name" v-model="user_details.middle_name">
	                    </div>
	                </div>
				</div
				><div class="width--33 m-margin-b">
					<div class="width--95 margin-l-a">
						<p class="frm-header s-margin-b bold clr--gray">Last Name</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="last_name" v-model="user_details.last_name">
	                    </div>
	                </div>
				</div>

				<div class="width--33 m-margin-b">
					<div class="width--95">
						<p class="frm-header s-margin-b bold clr--gray">E-mail Address</p>
	 					<div class="frm-inpt">
	 						<input type="text" name="name" v-model="user_details.email" disabled>
	                        <!-- <select>
	                        	<option></option>
	                        </select> -->
	                    </div>
                	</div>
				</div
				><!-- <div class="width--33 m-margin-b">
					<div class="width--95 margin-a">
						<p class="frm-header s-margin-b bold clr--gray">E-mail Address</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="name" v-model="user_details.email" disabled>
	                    </div>
	                </div>
				</div
				> --><div class="width--33 m-margin-b">
					<div class="width--95 margin-l-a">
						<p class="frm-header s-margin-b bold clr--gray">Mobile Phone</p>
						<div class="inlineBlock-parent">
							<div class="width--30">
								<div class="width--90">
									<div class="lgn-frm1__inpt frm-inpt align-c">
										<input type="text" value="+63" disabled>
									</div>
								</div>
							</div
							><div class="width--70">
								<div class="lgn-frm1__inpt frm-inpt align-c">
									<input type="number" v-model="user_details.contact_no">
								</div>
							</div>
		                </div>
	                </div>
				</div>

				<!-- <div class="width--100 m-margin-b">
					<div class="width--100">
						<p class="frm-header s-margin-b bold clr--gray">Address</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="" placeholder="">
	                    </div>
                	</div>
				</div> -->

				<!-- <div class="width--33 m-margin-b">
					<div class="width--95">
						<p class="frm-header s-margin-b bold clr--gray">Country</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="" placeholder="">
	                    </div>
                	</div>
				</div
				><div class="width--33 m-margin-b">
					<div class="width--95 margin-a">
						<p class="frm-header s-margin-b bold clr--gray">Nationality</p>
	 					<div class="frm-inpt">
	                        <input type="text" name="name">
	                    </div>
	                </div>
				</div
				><div class="width--33 m-margin-b">
					<div class="width--95 margin-a">
						<p class="frm-header s-margin-b bold clr--gray">Birthdate</p>
	 					<div class="frm-inpt">
	                        <input type="date" name="name">
	                    </div>
	                </div>	
				</div> -->

				<modal
				:icon="iconToShow"
				:message="message"
				:btn-color="btnColor"
				></modal>

				<loading :active.sync="isLoading" 
				        :is-full-page="fullPage"></loading>
			</div>
		</div>
		<div class="m-margin-t"></div>
		<div class="width--90 margin-a align-l">
			<p class="frm-header m-margin-b bold clr--green">Update Password</p>
			<div class="inlineBlock-parent">
				<div class="width--33 m-margin-b">
					<div class="width--95">
						<p class="frm-header s-margin-b bold clr--gray">Old Password</p>
	 					<div class="frm-inpt">
	                        <input type="password" placeholder="" v-model="user_details.old_password">
	                    </div>
                	</div>
				</div
				><div class="width--33 m-margin-b">
					<div class="width--95 margin-a">
						<p class="frm-header s-margin-b bold clr--gray">New Password</p>
	 					<div class="frm-inpt">
	                        <input type="password" name="password" v-model="user_details.password">
	                    </div>
	                </div>
				</div
				><div class="width--33 m-margin-b">
					<div class="width--95 margin-a">
						<p class="frm-header s-margin-b bold clr--gray">Confirm New Password</p>
	 					<div class="frm-inpt">
	                        <input type="password" name="password_confirmation" v-model="user_details.password_confirmation">
	                    </div>
	                </div>	
				</div>

				<div class="prfl-btn__holder l-margin-t align-r width--100 inlineBlock-parent">
					<button class="frm-btn gray s-margin-r">Cancel</button>
					<!-- <button class="frm-btn green" >Save</button> -->
					<button class="frm-btn green" @click="save">Save</button>
				</div>

			</div>
		</div>
	</div>
</template>
<script>
	import Modal from '../partials/Modal.vue';
	import ResponseMixin from 'Mixins/errorResponse.js';

	export default{
		props: {
			user: Object,
			submitUrl: String
		},

		mixins: [ ResponseMixin ],

        components: {
            Loading,
            Modal
        },

		data() {
			return {
				user_details: this.user,
				isLoading: false,
                fullPage: true,
                callModal: null,
                message: null,
                btnColor: null,
                iconToShow: null
			}
		},

		methods: {
			save() {
				this.isLoading = true;
				var inst = $('[data-remodal-id=remodal]').remodal();
				axios.post(this.submitUrl, this.user_details)
					.then(response => {
						this.isLoading = false;
						this.iconToShow = 'images/success-icon.png';
						this.message = 'Information successfully updated.';
						this.btnColor = 'green';
						inst.open();
					}).catch(errors => {
						this.isLoading = false;
						this.iconToShow = 'images/remove-button.png';
						this.message = this.parseResponse(errors, 'error');
						this.btnColor = 'red';
						inst.open();
					})
			}
		}
	}
</script>