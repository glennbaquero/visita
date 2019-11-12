<template>
	
<div>	
	<div class="gnrl-frm--sldr__item">
		<div class="frm-cntnr align-c width--85">
			<div class="vertical-parent">
				<div class="vertical-align align-c">
					<p class="frm-header m-margin-b clr--white">Destination Partner</p>
					<h5 class="frm-title l-margin-b clr--white hm-frm5-fade-up__item">{{ destination.name }}</h5>
					<a href="#" class="frm-btn green" data-remodal-target="hm-frm5--modal-1">Explore Destination</a>
				</div>
			</div>
		</div>
		<div class="frm-bckgrnd size-cover bring-back" :style="{'background-image': 'url('+destination.picture+')'}"></div>
	</div>

	<div id="gnrl-rmdl" class="remodal custom-width" data-remodal-id="hm-frm5--modal-1">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img src="" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c inlineBlock-parent">
			<div class="width--25 align-l gnrl-rmdl__col">
				<h5 class="frm-title l-margin-b clr--green">{{ destination.name }}</h5>
				<div class="gnrl-rmdl__btn-holder">
					<p class="gnrl-rmdl__btn" @click="showIcon()" :class="icon ? 'active' : ''">Icons</p>
					<p class="gnrl-rmdl__btn" @click="showExperience()" :class="experience_description ? 'active' : ''">Experiences</p>
					<p class="gnrl-rmdl__btn" @click="showFees()" :class="experience_fee ? 'active' : ''">Fees</p>
					<p class="gnrl-rmdl__btn" @click="showPolicies()" :class="policy ? 'active' : ''">Visitor Policies</p>
					<p class="gnrl-rmdl__btn" @click="showTerms()" :class="terms ? 'active' : ''">Terms & Condtions of Visit Request</p>
				</div>
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="icon">
					<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="destination.icon">
					</div>
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="experience_description">
				<template v-for="experience in destination.experiences">
					<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="experience.description">
					</div>
				</template>
					
			</div

			><div class="width--70 gnrl-rmdl__col" v-show="experience_fee">
				<template v-for="experience in destination.experiences">
					<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="experience.fee">
					</div>
				</template>
					
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="policy">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="destination.visitor_policies">
					</div>
					
			</div
			><div class="width--70 gnrl-rmdl__col" v-show="terms">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll" v-html="destination.terms_conditions">
					</div>
					
			</div>

		</div>
	</div>

</div>	
	

</template>

<script type="text/javascript">

export default {

	mounted() {

		this.init()
	},

	methods: {
		init() {
			axios.get(this.fetchUrl)
				.then(response => {
					this.destination = response.data.destination
				})
		},

		showIcon() {
			this.icon = true
			this.experience_description = false
			this.experience_fee = false
			this.policy = false
			this.terms = false
		},

		showExperience() {
			this.icon = false
			this.experience_description = true
			this.experience_fee = false
			this.policy = false
			this.terms = false
		},

		showFees() {
			this.icon = false
			this.experience_description = false
			this.experience_fee = true
			this.policy = false
			this.terms = false
		},

		showPolicies() {
			this.icon = false
			this.experience_description = false
			this.experience_fee = false
			this.policy = true
			this.terms = false
		},

		showTerms() {
			this.icon = false
			this.experience_description = false
			this.experience_fee = false
			this.policy = false
			this.terms = true
		}
	},

	data() {
		return {
			item: [],
			destination: [],
			icon: true,
			experience_description: false,
			experience_fee: false,
			policy: false,
			terms: false
		}
	},

	props: {

		fetchUrl: String,
	}

	
}
</script>