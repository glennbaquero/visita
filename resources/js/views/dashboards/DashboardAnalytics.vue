<template>
	<div class="row">
	<!-- 	<div class="col-12">
			<date-range
            @change="filter($event)"
            ></date-range>
		</div> -->
		<div class="col-12 col-sm-12">
			<div class="row">
				<div class="col-sm-6 col-md-4 mb-2">
					<box-widget-two
						card-title="ONLINE RESERVATION"
						:show-visitors-capacity="true"
						:show-groups-capacity="true"
						:total-groups="total_checked_in.online_group"
						:total-visitors="total_checked_in.online_visitor"
						:total-groups-capacity="20"
						:total-visitors-capacity="200"
						total-groups-label="Total Groups Check-In"
						total-visitors-label="Total Visitors Check-In"
					></box-widget-two>
				</div>
				<div class="col-sm-6 col-md-4 mb-2">
					<box-widget-two
						card-title="WALK-INS"
						:total-groups="total_checked_in.walk_in"
						:total-visitors="total_checked_in.walk_in_group"
						total-groups-label="Total Groups Check-In"
						total-visitors-label="Total Visitors Check-In"
					></box-widget-two>
				</div>
				<div class="col-sm-6 col-md-4  mb-2">
					<box-widget-two
						card-title="TOTAL CHECK-INS"
						:total-groups="total.groups"
						:total-visitors="total.guests"
						total-groups-label="Total Groups"
						total-visitors-label="Total Visitors"
					></box-widget-two>
				</div>
				</div>
		</div>

		<div class="col-12 col-sm-12 pt-3">
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<h3 class="font-weight-bold">Revenue</h3>
					<chart
					:items="revenue"
					format="Php"
					type="line"
					title=""
					label=""
					itemBgColor="rgba(54, 162, 235)"
					></chart>
				</div>
				<div class="col-sm-6 col-md-6">
					<h3 class="font-weight-bold">Age</h3>
					<chart
					:items="ages"
					format="Php"
					type="bar"
					title=""
					label=""
					></chart>
				</div>
				<div class="col-sm-6 col-md-6">
					<h3 class="font-weight-bold">Nationality</h3>
					<chart
					:items="nationalities"
					format="Php"
					type="horizontalBar"
					title=""
					label=""
					></chart>
				</div>
				<div class="col-sm-6 col-md-6">
					<chart-with-label
					:items="visitor_types"
					format="Php"
					type="pie"
					title="Tourist"
					label=""
					></chart-with-label>
				</div>
				<div class="col-sm-6 col-md-4">
					<chart-with-label
					:items="source"
					format="Php"
					type="pie"
					title="Source"
					label=""
					></chart-with-label>
				</div>
				<div class="col-sm-6 col-md-4">
					<chart-with-label
					:items="special_fees"
					format="Php"
					type="pie"
					title="Special Fee"
					label=""
					></chart-with-label>
				</div>
				<div class="col-sm-6 col-md-4">
					<chart-with-label
					:items="gender"
					format="Php"
					type="pie"
					title="Gender"
					label=""
					></chart-with-label>
				</div>
			</div>
		</div>

		<loader :loading="loading"></loader>
	</div>
</template>

<script type="text/javascript">
import FetchMixin from '../../mixins/fetch.js';

import DateRange from '../../components/datepickers/DateRange.vue';
import Charts from '../../components/charts/Chart.vue';
import ChartWithLabel from '../../components/charts/ChartWithLabel.vue';
import BoxWidget from '../../components/widgets/BoxWidget.vue';
import BoxWidgetTwo from '../../components/widgets/GroupAndVisitorBoxWidget.vue';
import ProgressChart from '../../components/widgets/ProgressChart.vue';

export default {
	methods: {
		filter(value) {
			this.filters = value;

			this.$nextTick(() => {
				this.fetch();
			});
		},

		fetchSetup() {
			if (!this.has_fetched) {
				this.fetch();
			}
		},

		fetchSuccess(data) {
			this.active = data.active;
			this.count = data.count;
			this.inactive = data.inactive;
			this.login = data.login;
			this.usage = data.usage;
			this.usage_chart = data.usage_chart;
			this.revenue = data.revenue;
			this.visitor_types = data.visitor_types;
			this.ages = data.ages;
			this.nationalities = data.nationalities;
			this.source = data.source;
			this.special_fees = data.special_fees;
			this.gender = data.gender;
			this.total = data.total;
			this.total_checked_in = data.total_checked_in;
			this.checked_in_walkin = data.checked_in_walkin;
		},
	},

	data() {
		return {
			filters: {},

			active: 0,
			count: 0,
			inactive: 0,
			login: 0,
			usage: '0 %',
			usage_chart: [],
			revenue: [],
			visitor_types: [],
			ages: [],
			nationalities: [],
			source: [],
			special_fees: [],
			gender: [],
			total: [],
			total_checked_in: [],
			checked_in_walkin: [],
		}
	},

	computed: {
		fetchParams() {
			return this.filters;
		},
	},

	components: {
		'date-range': DateRange,
		'chart': Charts,
		'box-widget': BoxWidget,
		BoxWidgetTwo,
		ChartWithLabel,
		ProgressChart
	},

	mixins: [ FetchMixin ],
}
</script>