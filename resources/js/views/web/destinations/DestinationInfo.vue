<template>
	<div>
		<section class="dstntns-inf-frm2">
			<div class="frm-cntnr width--85 align-c">
				<div class="inlineBlock-parent">
					<div class="dstntns-inf-frm2__btn-holder width--30 align-l align-t">
						<p class="dstntns-inf-frm2__btn" :class="tab === 0 ? 'active' : null" @click="activeTab(0, destination.overview, 'Overview')">Overview</p>
						<p class="dstntns-inf-frm2__btn" :class="tab === 1 ? 'active' : null" @click="activeTab(1, destination.allocations, 'Experiences')">Experiences</p>
						<p class="dstntns-inf-frm2__btn" :class="tab === 2 ? 'active' : null" @click="activeTab(2, destination.allocations, 'Fees')">Fees</p>
						<p class="dstntns-inf-frm2__btn" :class="tab === 3 ? 'active' : null" @click="activeTab(3, destination.visitor_policies, 'Visitor Policies')">Visitor Policies</p>
						<p class="dstntns-inf-frm2__btn" :class="tab === 4 ? 'active' : null" @click="activeTab(4, destination.terms_conditions, 'Terms & Condtions of Visit Request')">Terms & Condtions of Visit Request</p>
						<p class="dstntns-inf-frm2__btn" :class="tab === 5 ? 'active' : null" @click="activeTab(5, destination.how_to_get_here, 'How to Get Here')">How to Get Here</p>
						<p class="dstntns-inf-frm2__btn" :class="tab === 6 ? 'active' : null" @click="activeTab(6, destination.contact_us, 'Contact Us')">Contact Us</p>
						<a v-if="destination.is_available_for_request" :href="destination.request_url" class="frm-btn green" >Request to Visit</a>
					</div
					><div class="width--70 align-l align-t">
						<div class="dstntns-inf-frm2__content-inner">
							<div class="frm-description clr--gray gnrl-scrll">
								<p><strong>{{ title }}</strong></p>
								<template v-if="tab != 1 && tab != 2">
									<span  v-html="tabInfo"></span>
									<iframe v-if="tab === 0" :src="'https://www.google.com/maps/embed/v1/place?q='+destination.location+'&key=AIzaSyAaWOelGGDTWA2E9riZAqGGnQ8DRYKws6M'"width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
									<!-- <br>
									<br> -->
									<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/bKIIdCNOQwY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
								</template>
								<template v-if="tab === 1 && tab != 2">
									<ul v-for="info in tabInfo">
										<li>{{ info.name }}</li>
									</ul>
								</template>
								<template v-if="tab === 2">
									<span v-html="destination.fees"></span>
								</template>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>
<script>
	export default {
		props: {
			destination: Object
		},

		data() {
			return {
				tab: 0,
				tabInfo: this.destination.overview,
				title: 'Overview'
			}
		},

		methods: {
			activeTab(tab, info, title) {
				this.tab = tab;
				this.title = title;
				this.tabInfo = info;
			}
		}
	}
</script>