<template>
	<div>
		<div class="rqst-frm1__step-1">
			<div class="rqst-frm1__step-1-content">
				<div class="rqst-frm1__step-1-content-img m-margin-b">
					<div class="frm-bckgrnd size-cover" :style="{backgroundImage: 'url('+destination.image+')'}"></div>
				</div>
				<div class="align-l m-margin-b">
					<h5 class="frm-title small clr--gray">{{ destination.name }}</h5>
				</div>
				<div class="inlineBlock-parent">
					<img
					  class="rqst-frm1__step-1-content-icon" 
					  src="images/location-icon.png"
					>	
					<p class="frm-header s-margin-b clr--gray">Location: {{ destination.location }}.</p>
				</div>
				<div class="inlineBlock-parent">
					<img 
					  class="rqst-frm1__step-1-content-icon" 
					  src="images/calendar-icon.png"
					>	
					<p class="frm-header s-margin-b clr--gray">Duration: {{ destination.duration }}</p>
				</div>
				<div class="inlineBlock-parent">
					<img
					  class="rqst-frm1__step-1-content-icon"
					  src="images/recommended-icon.png"
					>	
					<p class="frm-header s-margin-b clr--gray">Recommended for: {{ destination.recommended }}</p>
				</div>
				<div class="inlineBlock-parent">
					<img 
					  class="rqst-frm1__step-1-content-icon" 
					  src="images/activities-icon.png"
					>	
					<p class="frm-header s-margin-b clr--gray">Activities: 
						<template v-for="(experience, key) in destination.allocations">
							{{ experience.name }}<span v-if="key+1 < destination.allocations.length">,</span>
						</template>
					</p>
				</div>

				<hr class="m-margin-b">
				<div class="frm-description">
					<p><strong>About the Destination</strong></p>
					<p v-html="destination.overview"></p>
					<iframe :src="'https://www.google.com/maps/embed/v1/place?q='+destination.location+'&key=AIzaSyAaWOelGGDTWA2E9riZAqGGnQ8DRYKws6M'" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
					<br>
					<br>
					<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/bKIIdCNOQwY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			destination: Object
		}
	}
</script>