<template>
	<div class="card h-100">
		<div class="card-header__style font-weight-bold">{{ cardTitle }}</div>
		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div class="card-body">
					<h3><i class="fas fa-users"></i></h3>
					<span class="primary__font-color overall__rates">{{ totalGroups }}</span><span class="total__rates" v-if="showGroupsCapacity"> / {{ totalGroupsCapacity }}</span>
					<p>{{ totalGroupsLabel }}</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="card-body">
					<h3><i class="fas fa-user"></i></h3>
					<span class="primary__font-color overall__rates">{{ totalVisitors }}</span><span class="total__rates" v-if="showVisitorsCapacity">/ {{ totalVisitorsCapacity }}</span>
					<p>{{ totalVisitorsLabel }}</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			cardTitle: String,
			totalGroups: Number,
			totalGroupsCapacity: {
				default: 0,
				type: Number
			},
			totalVisitors: Number,
			totalVisitorsCapacity: {
				default: 0,
				type: Number
			},
			totalGroupsLabel: String,
			totalVisitorsLabel: String,
			showGroupsCapacity: {
				default: false,
				type: Boolean
			},
			showVisitorsCapacity:  {
				default: false,
				type: Boolean
			},
		}
	}
</script>