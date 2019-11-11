<template>
	
<div>
	
	<div class="gnrl-frm--sldr__item" v-for="destination in destinations">
		<div class="frm-cntnr align-c width--85">
			<div class="vertical-parent">
				<div class="vertical-align align-c">
					<p class="frm-header m-margin-b clr--white">Destination Partner</p>
					<h5 class="frm-title l-margin-b clr--white hm-frm5-fade-up__item">{{ destination.name }}</h5>
					<a href="#" class="frm-btn green" data-remodal-target="hm-frm5--modal-1">Explore Destination</a>
				</div>
			</div>
		</div>
		<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
	</div>

	<div id="gnrl-rmdl" class="remodal custom-width" data-remodal-id="hm-frm5--modal-1">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img src="" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c inlineBlock-parent">
			<div class="width--25 align-l gnrl-rmdl__col">
				<h5 class="frm-title l-margin-b clr--green">Mt. Pulag</h5>
				<div class="gnrl-rmdl__btn-holder">
					<p class="gnrl-rmdl__btn">Icons</p>
					<p class="gnrl-rmdl__btn active">Experiences</p>
					<p class="gnrl-rmdl__btn">Fees</p>
					<p class="gnrl-rmdl__btn">Visitor Policies</p>
					<p class="gnrl-rmdl__btn">Terms & Condtions of Visit Request</p>
				</div>
			</div
			><div class="width--70 gnrl-rmdl__col">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll">
					
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
					this.destinations = response.data.destinations
				})
		}
	},

	data() {
		return {
			item: [],
			destinations: [],
		}
	},

	props: {

		fetchUrl: String,
	}

	
}
</script>