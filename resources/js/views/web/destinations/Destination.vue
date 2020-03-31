<template>
	
<div>
	<div class="gnrl-frm--sldr gnrl-frm--sldr2">
		<div class="gnrl-frm--sldr__item" v-for="dest in destination">
			<div class="frm-cntnr align-c width--85">
				<div class="vertical-parent">
					<div class="vertical-align align-c">
						<p class="gnrl-frm--sldr2__animation-title frm-header m-margin-b clr--white">Destination Partner</p>
						<h5 class="gnrl-frm--sldr2__animation-title frm-title l-margin-b clr--white hm-frm5-fade-up__item">{{ dest.destination.name }}</h5>
						<div class="gnrl-frm--sldr2__animation-button">
							<a href="#" class="frm-btn green" data-remodal-target="hm-frm5--modal" @click="exploreDestination(dest)">Explore Destination</a>
						</div>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" :style="{'background-image': 'url('+dest.picture+')'}"></div>
		</div>
	</div>

	<div id="gnrl-rmdl" class="remodal custom-width" data-remodal-id="hm-frm5--modal">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img :src="close_btn" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c inlineBlock-parent">
			<div class="width--25 align-l gnrl-rmdl__col">
				<h5 class="frm-title l-margin-b clr--green">{{ dest.name }}</h5>
				<div class="gnrl-rmdl__btn-holder">
					<p class="gnrl-rmdl__btn" @click="showOverview()" :class="overview ? 'active' : ''">Overview</p>
					<p class="gnrl-rmdl__btn" @click="showExperience()" :class="experience_description ? 'active' : ''">Experiences</p>
					<p class="gnrl-rmdl__btn" @click="showFees()" :class="experience_fee ? 'active' : ''">Fees</p>
					<p class="gnrl-rmdl__btn" @click="showPolicies()" :class="policy ? 'active' : ''">Visitor Policies</p>
					<p class="gnrl-rmdl__btn" @click="showTerms()" :class="terms ? 'active' : ''">Terms & Condtions of Visit Request</p>
					<p class="gnrl-rmdl__btn" @click="showGetHere()" :class="get_here ? 'active' : ''">How to Get Here</p>
					<p class="gnrl-rmdl__btn" @click="showContactUs()" :class="contact_us ? 'active' : ''">Contact Us</p>


				</div>
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="overview">
					<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="dest.overview">
					</div>
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="experience_description">
					<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" >
						<template v-for="experience in dest.experiences">
							<p><strong>{{ experience.name }}</strong></p>
							<p v-html="experience.description"></p>
						</template>
					</div>
					
			</div

			><div class="width--70 gnrl-rmdl__col" v-show="experience_fee">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="dest.fees">
					</div>	
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="policy">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="dest.visitor_policies">
					</div>
					
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="terms">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="dest.terms_conditions">
					</div>
					
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="get_here">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="dest.how_to_get_here">
					</div>
					
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="contact_us">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="dest.contact_us">
					</div>
					
			</div>

		</div>
	</div>

</div>	
	

</template>

<script type="text/javascript">

export default {

	mounted() {

		// this.init()
	},

	methods: {
		init() {
			// axios.get(this.fetchUrl)
			// 	.then(response => {
			// 		this.$nextTick(() => {

			// 			this.destination = response.data.destination
			// 		})
			// 	})
		},

		showOverview() {
			this.overview = true
			this.experience_description = false
			this.experience_fee = false
			this.policy = false
			this.terms = false
			this.get_here = false
			this.contact_us = false
		},

		showExperience() {
			this.overview = false
			this.experience_description = true
			this.experience_fee = false
			this.policy = false
			this.terms = false
			this.get_here = false
			this.contact_us = false
		},

		showFees() {
			this.overview = false
			this.experience_description = false
			this.experience_fee = true
			this.policy = false
			this.terms = false
			this.get_here = false
			this.contact_us = false
		},

		showPolicies() {
			this.overview = false
			this.experience_description = false
			this.experience_fee = false
			this.policy = true
			this.terms = false
			this.get_here = false
			this.contact_us = false
		},

		showTerms() {
			this.overview = false
			this.experience_description = false
			this.experience_fee = false
			this.policy = false
			this.terms = true
			this.get_here = false
			this.contact_us = false
		},

		showGetHere() {
			this.overview = false
			this.experience_description = false
			this.experience_fee = false
			this.policy = false
			this.terms = false
			this.get_here = true
			this.contact_us = false
		},

		showContactUs() {
			this.overview = false
			this.experience_description = false
			this.experience_fee = false
			this.policy = false
			this.terms = false
			this.get_here = false
			this.contact_us = true
		},

		exploreDestination(destination) {
			this.experience = destination.destination.experience;
			this.dest = destination.destination;
		}
	},

	data() {
		return {
			item: [],
			destination: [],
			overview: true,
			experience_description: false,
			experience_fee: false,
			policy: false,
			terms: false,
			get_here: false,
			contact_us: false,
			dest: {},
			close_btn: 'images/close-button.png' 
		}
	},

	props: {

		fetchUrl: String,
		destination: Array
	}

	
}
</script>