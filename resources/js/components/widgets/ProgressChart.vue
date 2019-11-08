<template>
	<div class="progress" style="height: 40px; width: 100%">
	  	<div class="progress-bar bg-success" :style="{ width : onlineReservation}">{{ onlineReservation }}</div>
	  	<div class="progress-bar bg-warning" :style="{ width : walkIn}"> {{ walkIn }} </div>
	</div>
</template>
<script>
	export default{
		props: {
			onlineReservation: {
				default: 0,
				type: Number
			},
			walkIn: {
				default: 0,
				type: Number
			},
		}
	}
</script>