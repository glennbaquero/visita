<template>
	<div>

	<div class="frm-cntnr align-c width--85">
		<!-- Header -->
		<div class="rqst-frm1__steps-header inlineBlock-parent">
			<div class="rqst-frm1__steps-header-col width--25 align-l align-t">
				<div class="rqst-frm1__breadcrumbs inlineBlock-parent">
					<p>Destinations</p>
					<p>></p>
					<p class="active">Request to visit</p>
				</div>
			</div
			><div class="rqst-frm1__steps-header-col width--50 inlineBlock-parent align-t">
				<div
				  class="rqst-frm1__steps-col"
				  :class="[activeStep1 ? 'active' : '', doneStep1 ? 'done' : '']"
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>1</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Experience & Schedule</h5>
					</div>
				</div
				><div 
				   class="rqst-frm1__steps-col"
				   :class="[activeStep2 ? 'active' : '', doneStep2 ? 'done' : '']"
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>2</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Contact Person</h5>
					</div>
				</div
				><div 
				   class="rqst-frm1__steps-col"
				   :class="[activeStep3 ? 'active' : '', doneStep3 ? 'done' : '']"   
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>3</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Guest Details</h5>
					</div>
				</div
				><div 
				   class="rqst-frm1__steps-col"
				   :class="[activeStep4 ? 'active' : '', doneStep4 ? 'done' : '']"   
				>
					<div class="rqst-frm1__steps">
						<div class="vertical-parent">
							<div class="vertical-align">
								<p>4</p>
							</div>
						</div>
					</div>
					<div class="align-c">
						<h5 class="rqst-frm1__steps-label">Review & Pay</h5>
					</div>
				</div
				>
			</div
			><div class="width--25 align-t rqst-frm1__steps-col">
				<img 
				  class="rqst-frm1__steps-header-logo"
				  :src="visitaLogo" 
				>
			</div>
		</div>
		<!--  -->

		<!-- Forms -->
		<div class="rqst-frm1__steps-form">
			<div class="inlineBlock-parent">
				<div class="width--60 align-t">
					<!-- Step 1 -->
					<StepOne v-if="step === 1" :destination="destination"></StepOne>
					<!--  -->
					<!-- Step 2 -->
					<div class="rqst-frm1__step-2" v-if="step === 2">
						<div class="rqst-frm1__step-2-content">
							<div class="align-l m-margin-b">
								<h5 class="frm-title small clr--gray">Main Contact Person</h5>
							</div>
							<hr>

							<div class="inlineBlock-parent align-l">
								<div class="width--50">
									<div class="width--95">
										<p class="frm-header bold s-margin-b clr--gray">First Name*</p>
										<div class="frm-inpt m-margin-b">
											<input type="text">
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a">
										<p class="frm-header bold s-margin-b clr--gray">Last Name*</p>
										<div class="frm-inpt m-margin-b">
											<input type="text">
										</div>
									</div>
								</div>
							</div>

							<div class="inlineBlock-parent align-l">
								<div class="width--50">
									<div class="width--95">
										<p class="frm-header bold s-margin-b clr--gray">Nationality*</p>
										<div class="frm-inpt m-margin-b">
											<select>
												<option></option>
											</select>
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a">
										<p class="frm-header bold s-margin-b clr--gray">Email Address*</p>
										<div class="frm-inpt m-margin-b">
											<input type="email">
										</div>
									</div>
								</div>
							</div>

							<div class="inlineBlock-parent align-l">
								<div class="width--50">
									<div class="width--95">
										<p class="frm-header bold s-margin-b clr--gray">Contact No.*</p>
										<div class="inlineBlock-parent">
											<div class="width--30">
												<div class="width--90">
													<div class="frm-inpt align-c m-margin-b">
														<input type="text" name="" value="+63" disabled>
													</div>
												</div>
											</div
											><div class="width--70">
												<div class="frm-inpt align-c m-margin-b">
													<input type="number" name="" placeholder="">
												</div>
											</div>
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a">
										<p class="frm-header bold s-margin-b clr--gray">Emergency Contact*</p>
										<div class="inlineBlock-parent">
											<div class="width--30">
												<div class="width--90">
													<div class="frm-inpt align-c m-margin-b">
														<input type="text" name="" value="+63" disabled>
													</div>
												</div>
											</div
											><div class="width--70">
												<div class="frm-inpt align-c m-margin-b">
													<input type="number" name="" placeholder="">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="inlineBlock-parent align-l">
								<div class="width--50">
									<div class="width--95">
										<p class="frm-header bold s-margin-b clr--gray">Birthdate*</p>
										<div class="frm-inpt m-margin-b">
											<input type="date">
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a">
										<p class="frm-header bold s-margin-b clr--gray">Gender*</p>
										<div class="frm-inpt m-margin-b">
											<select>
												<option></option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="inlineBlock-parent align-l">
								<div class="width--50">
									<div class="width--95">
										<p class="frm-header bold s-margin-b clr--gray">Visitor Type*</p>
										<div class="frm-inpt m-margin-b">
											<select>
												<option></option>
											</select>
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a">
										<p class="frm-header bold s-margin-b clr--gray">Special Fees</p>
										<div class="frm-inpt m-margin-b">
											<select>
												<option>None</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="inlineBlock-parent align-l">
								<div class="width--50">
									<div class="width--95">
										<p class="frm-header bold s-margin-b clr--gray">Agency Code</p>
										<div class="frm-inpt m-margin-b">
											<input type="text">
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a">
										<p class="frm-header bold s-margin-b clr--gray">Health Certificate/Letter of Consent*</p>
										<div class="frm-inpt m-margin-b">
											<input type="file">
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="inlineBlock-parent width--100 align-l">
							<p class="frm-header bold clr--green">NOTE:</p>
							<p class="frm-header clr--gray">Contact Person should be 18 years old and above.</p>
						</div>
					</div>
					<!--  -->
					<!-- Step 3 -->
					<div class="rqst-frm1__step-3" v-if="step === 3">
						<div class="rqst-frm1__step-3-content">
							
							<!-- Guest Details Card -->
							<div 
							  class="rqst-frm1__step-3-content-guest-card"
							  :class="guestCard ? 'hide' : ''"
							>
								<div class="align-l m-margin-b">
									<h5 class="frm-title small clr--gray">Guest Details</h5>
								</div>
								<hr>
								<div class="inlineBlock-parent align-l m-margin-b">
									
									<div class="rqst-frm1__step-3-content-col">
										<p class="frm-header s-margin-b">Guest 1:</p>
										<div class="rqst-frm1__step-3-content-card">
											<div class="width--90 margin-a inlineBlock-parent">
												<div class="width--40 inlineBlock-parent">
													<img 
													  class="rqst-frm1__step-3-content-card-edit-btn" 
													  :src="editButton"
													  @click="openGuestForm()"
													>
													<p class="frm-header bold clr--light-gray">|</p>
													<img 
													  class="rqst-frm1__step-3-content-card-remove-btn" 
													  :src="removeButton"
													>
												</div
												><div class="width--60">
													<p class="frm-header bold clr--green">Register Guest</p>
												</div>
											</div>
										</div>
									</div
									><div class="rqst-frm1__step-3-content-col">
										<p class="frm-header s-margin-b">Guest 2:</p>
										<div class="rqst-frm1__step-3-content-card">
											<div class="width--90 margin-a inlineBlock-parent">
												<div class="width--40 inlineBlock-parent">
													<img 
													  class="rqst-frm1__step-3-content-card-edit-btn" 
													  :src="editButton"
													>
													<p class="frm-header bold clr--light-gray">|</p>
													<img 
													  class="rqst-frm1__step-3-content-card-remove-btn" 
													  :src="removeButton"
													>
												</div
												><div class="width--60">
													<p class="frm-header bold clr--green">Register Guest</p>
												</div>
											</div>
										</div>
									</div
									><div class="rqst-frm1__step-3-content-col">
										<p class="frm-header s-margin-b">Guest 3:</p>
										<div class="rqst-frm1__step-3-content-card">
											<div class="width--90 margin-a inlineBlock-parent">
												<div class="width--40 inlineBlock-parent">
													<img 
													  class="rqst-frm1__step-3-content-card-edit-btn" 
													  :src="editButton"
													>
													<p class="frm-header bold clr--light-gray">|</p>
													<img 
													  class="rqst-frm1__step-3-content-card-remove-btn" 
													  :src="removeButton"
													>
												</div
												><div class="width--60">
													<p class="frm-header bold clr--green">Register Guest</p>
												</div>
											</div>
										</div>
									</div
									><div class="rqst-frm1__step-3-content-col">
										<p class="frm-header s-margin-b">Guest 4:</p>
										<div class="rqst-frm1__step-3-content-card">
											<div class="width--90 margin-a inlineBlock-parent">
												<div class="width--40 inlineBlock-parent">
													<img 
													  class="rqst-frm1__step-3-content-card-edit-btn" 
													  :src="editButton"
													>
													<p class="frm-header bold clr--light-gray">|</p>
													<img 
													  class="rqst-frm1__step-3-content-card-remove-btn" 
													  :src="removeButton"
													>
												</div
												><div class="width--60">
													<p class="frm-header bold clr--green">Register Guest</p>
												</div>
											</div>
										</div>
									</div
									><div class="rqst-frm1__step-3-content-col">
										<p class="frm-header s-margin-b">Guest 5:</p>
										<div class="rqst-frm1__step-3-content-card">
											<div class="width--90 margin-a inlineBlock-parent">
												<div class="width--40 inlineBlock-parent">
													<img 
													  class="rqst-frm1__step-3-content-card-edit-btn" 
													  :src="editButton"
													>
													<p class="frm-header bold clr--light-gray">|</p>
													<img 
													  class="rqst-frm1__step-3-content-card-remove-btn" 
													  :src="removeButton"
													>
												</div
												><div class="width--60">
													<p class="frm-header bold clr--green">Register Guest</p>
												</div>
											</div>
										</div>
									</div
									><div class="rqst-frm1__step-3-content-col">
										<p class="frm-header s-margin-b">Guest 6:</p>
										<div class="rqst-frm1__step-3-content-card">
											<div class="width--90 margin-a inlineBlock-parent">
												<div class="width--40 inlineBlock-parent">
													<img 
													  class="rqst-frm1__step-3-content-card-edit-btn" 
													  :src="editButton"
													>
													<p class="frm-header bold clr--light-gray">|</p>
													<img 
													  class="rqst-frm1__step-3-content-card-remove-btn" 
													  :src="removeButton"
													>
												</div
												><div class="width--60">
													<p class="frm-header bold clr--green">Register Guest</p>
												</div>
											</div>
										</div>
									</div
									>
								</div>
								<div class="rqst-frm1__step-3-content-add-guest-holder inlineBlock-parent align-l">
									<img 
									  class="rqst-frm1__step-3-content-add-guest-btn" 
									  :src="addButton"
									>
									<p class="frm-header bold clr--green rqst-frm1__step-3-content-add-guest-btn-label">Add Guest</p>
								</div>
							</div>

							<!-- Guest Details Form -->
							<div 
							  class="rqst-frm1__step-3-content-guest-form align-l m-margin-b"
							  :class="guestForm ? 'show' : ''"
							>
								<div class="inlineBlock-parent">
									<div class="width--60">
										<h5 class="frm-title small clr--gray">Guest 1 Details</h5>
									</div
									><div class="width--40 align-r inlineBlock-parent">
										
									</div>
								</div>
								<hr>

								<div class="inlineBlock-parent align-l">
									<div class="width--50">
										<div class="width--95">
											<p class="frm-header bold s-margin-b clr--gray">First Name*</p>
											<div class="frm-inpt m-margin-b">
												<input type="text">
											</div>
										</div>
									</div
									><div class="width--50">
										<div class="width--95 margin-l-a">
											<p class="frm-header bold s-margin-b clr--gray">Last Name*</p>
											<div class="frm-inpt m-margin-b">
												<input type="text">
											</div>
										</div>
									</div>
								</div>

								<div class="inlineBlock-parent align-l">
									<div class="width--50">
										<div class="width--95">
											<p class="frm-header bold s-margin-b clr--gray">Nationality*</p>
											<div class="frm-inpt m-margin-b">
												<select>
													<option></option>
												</select>
											</div>
										</div>
									</div
									><div class="width--50">
										<div class="width--95 margin-l-a">
											<p class="frm-header bold s-margin-b clr--gray">Email Address*</p>
											<div class="frm-inpt m-margin-b">
												<input type="email">
											</div>
										</div>
									</div>
								</div>

								<div class="inlineBlock-parent align-l">
									<div class="width--50">
										<div class="width--95">
											<p class="frm-header bold s-margin-b clr--gray">Contact No.*</p>
											<div class="inlineBlock-parent">
												<div class="width--30">
													<div class="width--90">
														<div class="frm-inpt align-c m-margin-b">
															<input type="text" name="" value="+63" disabled>
														</div>
													</div>
												</div
												><div class="width--70">
													<div class="frm-inpt align-c m-margin-b">
														<input type="number" name="" placeholder="">
													</div>
												</div>
											</div>
										</div>
									</div
									><div class="width--50">
										<div class="width--95 margin-l-a">
											<p class="frm-header bold s-margin-b clr--gray">Emergency Contact*</p>
											<div class="inlineBlock-parent">
												<div class="width--30">
													<div class="width--90">
														<div class="frm-inpt align-c m-margin-b">
															<input type="text" name="" value="+63" disabled>
														</div>
													</div>
												</div
												><div class="width--70">
													<div class="frm-inpt align-c m-margin-b">
														<input type="number" name="" placeholder="">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="inlineBlock-parent align-l">
									<div class="width--50">
										<div class="width--95">
											<p class="frm-header bold s-margin-b clr--gray">Birthdate*</p>
											<div class="frm-inpt m-margin-b">
												<input type="date">
											</div>
										</div>
									</div
									><div class="width--50">
										<div class="width--95 margin-l-a">
											<p class="frm-header bold s-margin-b clr--gray">Gender*</p>
											<div class="frm-inpt m-margin-b">
												<select>
													<option></option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="inlineBlock-parent align-l">
									<div class="width--50">
										<div class="width--95">
											<p class="frm-header bold s-margin-b clr--gray">Visitor Type*</p>
											<div class="frm-inpt m-margin-b">
												<select>
													<option></option>
												</select>
											</div>
										</div>
									</div
									><div class="width--50">
										<div class="width--95 margin-l-a">
											<p class="frm-header bold s-margin-b clr--gray">Special Fees</p>
											<div class="frm-inpt m-margin-b">
												<select>
													<option>None</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="inlineBlock-parent align-l">
									<div class="width--50">
										<div class="width--95">
											<p class="frm-header bold s-margin-b clr--gray">Health Certificate/Letter of Consent (Optional)</p>
											<div class="frm-inpt m-margin-b">
												<input type="file">
											</div>
										</div>
									</div>
								</div>

								<div class="align-l">
									<button class="frm-btn green">Submit</button>
								</div>

							</div>

						</div>
					</div>
					<!--  -->
					<!-- Step 4 -->
					<div class="rqst-frm1__step-4 " v-if="step === 4">
						<div class="rqst-frm1__step-4-content">
							
							<div class="align-l m-margin-b">
								<h5 class="frm-title small clr--gray">Payment Method</h5>
							</div>
							<hr>

							<div class="rqst-frm1__step-4-content-checkbox">
								<label class="rqst-frm1__step-4-content-checkbox-container align-l inlineBlock-parent">
									<div class="width--10">
										<input type="radio" name="payment">
										<span class="checkmark"></span>
									</div
									><div class="width--50">
										<p class="frm-header clr--gray">Paypal</p>
									</div
									><div class="width--40 align-r">
										<img
										  class="rqst-frm1__step-4-content-checkbox-img" 
										  src="https://cdn.pixabay.com/photo/2015/05/26/09/37/paypal-784404_960_720.png"
										>
									</div>
								</label>
							</div>

							<div class="rqst-frm1__step-4-content-checkbox">
								<label class="rqst-frm1__step-4-content-checkbox-container align-l inlineBlock-parent">
									<div class="width--10">
										<input type="radio" name="payment">
										<span class="checkmark"></span>
									</div
									><div class="width--50">
										<p class="frm-header clr--gray">Credit Card</p>
									</div
									><div class="width--40 align-r">
										<img
										  class="rqst-frm1__step-4-content-checkbox-img" 
										  src="https://www.stickpng.com/assets/images/58482363cef1014c0b5e49c1.png"
										>
										<img 
										  class="rqst-frm1__step-4-content-checkbox-img" 
										  src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/1200px-Mastercard_2019_logo.svg.png"
										>
									</div>
								</label>
							</div>

							<div class="align-l m-margin-b l-margin-t">
								<h5 class="frm-title small clr--gray">Fees</h5>
							</div>
							<hr>
								
							<div class="inlineBlock-parent align-l m-margin-b">
								<div class="rqst-frm1__step-4-content-select-holder">
									<div class="rqst-frm1__step-4-content-select">
										<div class="width--95 margin-a inlineBlock-parent">
											<div class="width--50 inlineBlock-parent">
												<p class="frm-header clr--gray s-margin-r">Conservation Fees</p>
												
												<div class="rqst-frm1__step-4-content-info-holder">
													<img 
													  class="rqst-frm1__step-4-content-info-icon" 
													  :src="infoIcon"
													>
													<div class="rqst-frm1__step-4-content-info-position">
														<div class="rqst-frm1__step-4-content-info">
															<div class="width--90 margin-a">
																<p class="frm-header clr--white"><strong>Information:</strong> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here</p>
															</div>
														</div>
													</div>
												</div>

											</div
											><div class="width--50 align-r">
												<p class="frm-header bold clr--gray s-margin-r">Php 11,500</p>
											</div>
										</div>
									</div>
									<div class="rqst-frm1__step-4-content-select-option">
										<div class="width--95 margin-a">
											
											<div class="inlineBlock-parent rqst-frm1__step-4-content-option">
												<div class="width--50">
													<p class="frm-header clr--gray">Foreign Guest x 2</p>
												</div
												><div class="width--50 align-r">
													<p class="frm-header clr--gray">Php 4,000</p>
												</div>
											</div>

											<div class="inlineBlock-parent rqst-frm1__step-4-content-option">
												<div class="width--50">
													<p class="frm-header clr--gray">Student Guest x 1</p>
												</div
												><div class="width--50 align-r">
													<p class="frm-header clr--gray">Php 4,000</p>
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
											  :src="infoIcon"
											>
											<div class="rqst-frm1__step-4-content-info-position">
												<div class="rqst-frm1__step-4-content-info">
													<div class="width--90 margin-a">
														<p class="frm-header clr--white"><strong>Information:</strong> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<p class="frm-header clr--gray s-margin-b">8 Guests x Php 50</p>
								</div
								><div class="width--50 align-r align-t">
									<p class="frm-header bold clr--gray s-margin-b">Php 400</p>
								</div>
							</div>

							<div class="inlineBlock-parent rqst-frm1__step-4-content-subtotal">
								<div class="width--50 align-l align-t">
									<p class="frm-header bold clr--light-gray">Subtotal</p>
								</div
								><div class="width--50 align-r align-t">
									<p class="frm-header bold clr--light-gray">Php 11,900</p>
								</div>
							</div>
							<hr>

							<div class="inlineBlock-parent l-margin-b">
								<div class="width--50 align-l align-t">
									<div class="inlineBlock-parent">
										<p class="frm-header clr--gray s-margin-b s-margin-r">Transaction Fees</p>

										<div class="rqst-frm1__step-4-content-info-holder s-margin-b">
											<img 
											  class="rqst-frm1__step-4-content-info-icon" 
											  :src="infoIcon"
											>
											<div class="rqst-frm1__step-4-content-info-position">
												<div class="rqst-frm1__step-4-content-info">
													<div class="width--90 margin-a">
														<p class="frm-header clr--white"><strong>Information:</strong> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div
								><div class="width--50 align-r align-t">
									<p class="frm-header bold clr--gray s-margin-b">Php 25</p>
								</div>
							</div>

							<div class="inlineBlock-parent">
								<div class="width--50 align-l">
									<h5 class="frm-title x-small clr--gray">Total</h5>
								</div
								><div class="width--50 align-r">
									<h5 class="frm-title x-small clr--gray">Php 11,925</h5>
								</div>
							</div>							
							
							<hr>

							<div class="rqst-frm1__step-4-content-terms">
								<div class="align-l">
									<h5 class="frm-title x-small clr--gray m-margin-b l-margin-t">Terms & Conditions of the Visit</h5>
								</div>

								<div class="frm-description l-margin-b">
									<ul><li>The visitor must agree on the Destinations’ policies which apply to the entire area, including the registration office, parking area (if any), and areas along the way to the destination (ie. bodies of water, trails, etc) from registration area. A penalty may apply for violations committed during the visit.</li><li>Conservation fees may vary depending on the selected experience of the visitorand special fees applied. (Note that for special fees, a validated ID needs to be presented upon arrival at the registration area to confirm fees applied. Failure to provide said ID may result to guest not being allowed to take the experience.</li><li>The visitor must have read and reviewed the rules, waiver and health form and agree with the rules and regulations.</li><li>The visitor must ensure that all information provided (guest details, preferred schedule, preferred experience) are correct.</li><li>Allocated slots for Visita are available on a first come first serve and real time basis. Number of available slots may change without prior notice.</li><li>Conservation fees have to be settled immediately for credit card payment, or twenty four (24) hours after booking for other payments, otherwise, the slot will be forfeited.</li><li>All fees are non-refundable regardless of reason.</li><li>Change of dates are allowed when done seven (7) calendar days before the scheduled visit. Changes in dates may only be accommodated once.</li><li>Destination may announce cancellations in case of extreme conditions. Visitor must contact destination for any announcements of such and if the destination will allow rescheduling. In these instances, Destination Manager shall be the one to manually reschedule their visit via the backend of VISITA.</li><li>Additional walk-in guests are NOT allowed. All guests must be registered prior to the visit. Adding of additional guests and changing of names is possible four (4) calendar days before the date of visit to give sufficient time allowance for the settlement of the conservation fees.</li><li>Once visit has been confirmed, a qr code will automatically be sent to the main contact’s email address. Kindly save it as it will be used to check-in your group upon arrival at the destination</li></ul>
									<br>

								</div>

								<div class="inlineBlock-parent align-l m-margin-b">
									<input type="checkbox" name="">
									<h5 class="frm-header clr--gray">I agree to the <a href="" target="_blank">Terms and Conditions, Changes, Refunds and Postponements and Policies.</a> I also agree to pay the total amount shown, which includes <strong>other fees.</strong></h5>
								</div>
								<div class="inlineBlock-parent align-l m-margin-b">
									<input type="checkbox" name="">
									<h5 class="frm-header clr--gray">I agree to the <a href="privacy-policy" target="_blank">Privacy Policy.</a></h5>
								</div>

							</div>

						</div>
					</div>
					<!--  -->
				</div
				><div class="width--40 align-t">
					<div class="width--90 margin-l-a">
						<!-- Step 1 -->
						<FormStepOne 
							v-if="step === 1" 
							:destination="destination" 
							@showStep2="showStep2()"
							:step-data="stepData"
							></FormStepOne>
						<!--  -->
						<!-- Step 2 -->
						<div class="rqst-frm1__steps-form-cards" v-if="step === 2">
							<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
								<div class="align-l">
									<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
									<hr>
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Date:</p>
										<p class="frm-header clr--gray">October 9, 2019</p>
									</div>
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Experience:</p>
										<p class="frm-header clr--gray">Camping</p>
									</div>
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">No. of guests:</p>
										<p class="frm-header clr--gray">5</p>
									</div>
									<div class="inlineBlock-parent">
										<p class="frm-header bold clr--gray">Time:</p>
										<p class="frm-header clr--gray">6:00 AM</p>
									</div>
								</div>
							</div>
							<hr>
							<div class="inlineBlock-parent">
								<div class="width--45">
									<div class="width--95">
										<button
										  class="frm-btn gray"
										  @click="returnStep1()"
										>Back</button>
									</div>
								</div
								><div class="width--45">
									<div class="width--95">
										<button 
										  class="frm-btn green"
										  @click="showStep3()"
										>Next</button>
									</div>
								</div>
							</div>
						</div>
						<!--  -->
						<!-- Step 3 -->
						<div class="rqst-frm1__steps-form-cards" v-if="step === 3">
							<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
								<div class="width--100">
									<div class="align-l m-margin-b">
										<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
										<hr>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">Date:</p>
											<p class="frm-header clr--gray">October 9, 2019</p>
										</div>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">Experience:</p>
											<p class="frm-header clr--gray">Camping</p>
										</div>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">No. of guests:</p>
											<p class="frm-header clr--gray">5</p>
										</div>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">Time:</p>
											<p class="frm-header clr--gray">6:00 AM</p>
										</div>
									</div>
								</div>
								<div class="width--100">
									<div class="align-l">
										<h5 class="frm-title x-small clr--gray">Contact Person</h5>
										<hr>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Name:</p>
														<p class="frm-header clr--gray">Jethro Hitosis</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Email:</p>
														<p class="frm-header clr--gray">jethro@praxxys.ph</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Nationality:</p>
														<p class="frm-header clr--gray">Filipino</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Birthdate:</p>
														<p class="frm-header clr--gray">August 7, 2019</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Contact No.:</p>
														<p class="frm-header clr--gray">+6309565612284</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Emergency No.:</p>
														<p class="frm-header clr--gray">+6309565612284</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Gender:</p>
														<p class="frm-header clr--gray">Male</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Visitor Type:</p>
														<p class="frm-header clr--gray">--</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Special Fees:</p>
														<p class="frm-header clr--gray">--</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Agency Code:</p>
														<p class="frm-header clr--gray">--</p>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<hr>
							<div class="inlineBlock-parent">
								<div class="width--45">
									<div class="width--95">
										<button 
										  class="frm-btn gray"
										  @click="returnStep2()"
										>Back</button>
									</div>
								</div
								><div class="width--45">
									<div class="width--95">
										<button 
										  class="frm-btn green"
										  @click="showStep4()"
										>Next</button>
									</div>
								</div>
							</div>
						</div>
						<!--  -->
						<!-- Step 4 -->
						<div class="rqst-frm1__steps-form-cards" v-if="step === 4">
							<div class="width--90 margin-a rqst-frm1__steps-form-cards-container gnrl-scrll">
								<div class="width--100">
									<div class="align-l m-margin-b">
										<h5 class="frm-title x-small clr--gray">Experience & Schedule</h5>
										<hr>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">Date:</p>
											<p class="frm-header clr--gray">October 9, 2019</p>
										</div>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">Experience:</p>
											<p class="frm-header clr--gray">Camping</p>
										</div>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">No. of guests:</p>
											<p class="frm-header clr--gray">5</p>
										</div>
										<div class="inlineBlock-parent">
											<p class="frm-header bold clr--gray">Time:</p>
											<p class="frm-header clr--gray">6:00 AM</p>
										</div>
									</div>
								</div>
								<div class="width--100">
									<div class="align-l m-margin-b">
										<h5 class="frm-title x-small clr--gray">Contact Person</h5>
										<hr>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Name:</p>
														<p class="frm-header clr--gray">Jethro Hitosis</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Email:</p>
														<p class="frm-header clr--gray">jethro@praxxys.ph</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Nationality:</p>
														<p class="frm-header clr--gray">Filipino</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Birthdate:</p>
														<p class="frm-header clr--gray">August 7, 2019</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Contact No.:</p>
														<p class="frm-header clr--gray">+6309565612284</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Emergency No.:</p>
														<p class="frm-header clr--gray">+6309565612284</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Gender:</p>
														<p class="frm-header clr--gray">Male</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Visitor Type:</p>
														<p class="frm-header clr--gray">--</p>
													</div>
												</div>
											</div>
										</div>

										<div class="inlineBlock-parent">
											<div class="width--50 align-t">
												<div class="width--95">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Special Fees:</p>
														<p class="frm-header clr--gray">--</p>
													</div>
												</div>
											</div
											><div class="width--50 align-t">
												<div class="width--95 margin-l-a">
													<div class="inlineBlock-parent">
														<p class="frm-header bold clr--gray">Agency Code:</p>
														<p class="frm-header clr--gray">--</p>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
								<div class="width--100">
									<div class="align-l">
										<h5 class="frm-title x-small clr--gray">Guest Details</h5>
										<hr>

										<div class="m-margin-b">
											<p class="frm-header bold clr--green">Guest 1:</p>
											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Name:</p>
															<p class="frm-header clr--gray">Jethro Hitosis</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Email:</p>
															<p class="frm-header clr--gray">jethro@praxxys.ph</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Nationality:</p>
															<p class="frm-header clr--gray">Filipino</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Birthdate:</p>
															<p class="frm-header clr--gray">August 7, 2019</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Contact No.:</p>
															<p class="frm-header clr--gray">+6309565612284</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Emergency No.:</p>
															<p class="frm-header clr--gray">+6309565612284</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Gender:</p>
															<p class="frm-header clr--gray">Male</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Visitor Type:</p>
															<p class="frm-header clr--gray">--</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Special Fees:</p>
															<p class="frm-header clr--gray">--</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Agency Code:</p>
															<p class="frm-header clr--gray">--</p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="m-margin-b">
											<p class="frm-header bold clr--green">Guest 2:</p>
											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Name:</p>
															<p class="frm-header clr--gray">Jethro Hitosis</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Email:</p>
															<p class="frm-header clr--gray">jethro@praxxys.ph</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Nationality:</p>
															<p class="frm-header clr--gray">Filipino</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Birthdate:</p>
															<p class="frm-header clr--gray">August 7, 2019</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Contact No.:</p>
															<p class="frm-header clr--gray">+6309565612284</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Emergency No.:</p>
															<p class="frm-header clr--gray">+6309565612284</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Gender:</p>
															<p class="frm-header clr--gray">Male</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Visitor Type:</p>
															<p class="frm-header clr--gray">--</p>
														</div>
													</div>
												</div>
											</div>

											<div class="inlineBlock-parent">
												<div class="width--50 align-t">
													<div class="width--95">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Special Fees:</p>
															<p class="frm-header clr--gray">--</p>
														</div>
													</div>
												</div
												><div class="width--50 align-t">
													<div class="width--95 margin-l-a">
														<div class="inlineBlock-parent">
															<p class="frm-header bold clr--gray">Agency Code:</p>
															<p class="frm-header clr--gray">--</p>
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<hr>
							<div class="inlineBlock-parent">
								<div class="width--45">
									<div class="width--95">
										<button 
										  class="frm-btn gray"
										  @click="returnStep3()"
										>Back</button>
									</div>
								</div
								><div class="width--45">
									<div class="width--95">
										<button class="frm-btn green" data-remodal-target="confirmation-modal">Pay Now</button>
									</div>
								</div>
							</div>
						</div>
						<!--  -->

					</div>
				</div>
			</div>
		</div>
		<!--  -->

		<!-- Modals -->
		<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="confirmation-modal">
			<div class="width--90 margin-a">
				<img 
				  class="gnrl-rmdl__img-icon"
				  :src="questionIcon" 
				>
				<div class="frm-description no-height clr--gray m-margin-b">
					<p>Confirm payment?</p>
				</div>
				<button class="frm-btn green m-margin-b" data-remodal-target="success-modal">Confirm</button>
				<button class="frm-btn gray" data-remodal-action="close">Cancel</button>
			</div>
		</div>
		<!--  -->

		<!-- Modals -->
		<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="success-modal">
			<div class="width--90 margin-a">
				<img 
				  class="gnrl-rmdl__img-icon"
				  :src="successIcon" 
				>
				<div class="frm-description no-height clr--gray m-margin-b">
					<p>Success! You are going to <strong>Mt. Pulag</strong>. A QR code will be sent to your email once your visit is confirmed and approved. You may check your dashboard for the status of your request.</p>
				</div>
				<a href="user/dashboard" class="frm-btn green">Dashboard</a>
			</div>
		</div>
		<!--  -->

	</div>

	</div>
</template>

<script type="text/javascript">
	import StepOne from './steps/StepOne.vue';
	import FormStepOne from './steps/FormStepOne.vue';
	export default {

		props: {
			destination: Object
		},	

		components: {
			StepOne,
			FormStepOne
		},

		data() {
			return {
				stepData: {},
				step: 1,
				activeStep1: true,
				activeStep2: false,
				activeStep3: false,
				activeStep4: false,
				doneStep1: false,
				doneStep2: false,
				doneStep3: false,
				doneStep4: false,
				guestForm: false,
				guestCard: false,
				visitaLogo: 'images/visita-logo.png',	
				infoIcon: 'images/info-icon.png',
				questionIcon: 'images/question-icon.png',
				successIcon: 'images/success-icon.png',
				editButton: 'images/edit-button.png',
				removeButton: 'images/remove-button.png',
				addButton: 'images/add-button.png'
			}
		},

		methods: {
			showStep2() {
				this.step++;
				this.activeStep1 = false;
				this.activeStep2 = true;
				this.doneStep1 = true;
				window.scrollTo(0,0);
			},
			showStep3() {
				this.step++;
				this.activeStep2 = false;
				this.activeStep3 = true;
				this.doneStep2 = true;
				window.scrollTo(0,0);
			},
			showStep4() {
				this.step++;
				this.activeStep3 = false;
				this.activeStep4 = true;
				this.doneStep3 = true;
				window.scrollTo(0,0);
			},
			returnStep1() {
				this.step--;
				this.activeStep1 = true;
				this.activeStep2 = false;
				this.doneStep1 = false;
				window.scrollTo(0,0);
			},
			returnStep2() {
				this.step--;
				this.activeStep2 = true;
				this.activeStep3 = false;
				this.doneStep2 = false;
				window.scrollTo(0,0);
			},
			returnStep3() {
				this.step--;
				this.activeStep3 = true;
				this.activeStep4 = false;
				this.doneStep3 = false;
				window.scrollTo(0,0);
			},
			openGuestForm() {
				this.guestForm = true;
				this.guestCard = true;
			}

		}
	}
</script>