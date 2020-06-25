<template>
	<div class="row">
		<!-- <div class="col-12"> -->
		<date-picker
		class="mt-2 form-group col-md-4"
		label="Filter by Date"
		placeholder="Choose a date"
		:enableTime="false"
		dateFormat="Y-m-d"
        @change="filter($event, 'date')"
        ></date-picker>
		<!-- </div> -->
		<selector
		class="mt-2 col-md-4"
		:items="destinations"
		v-model="destination"
		item-text="name"
		item-value="id"
		label="Filter by destination"
		@change="filter($event, 'destination');"
		placeholder="Filter by destination"
		></selector>

		<selector
		class="mt-2 col-md-4"
		:items="experiences"
		item-text="name"
		item-value="id"
		label="Filter by experience"
		@change="filter($event, 'experience')"
		placeholder="Filter by experience"
		></selector>
		<div class="col-12 col-sm-12">
			<div class="row">
				<div class="col-sm-6 col-md-4 mb-2">
					<box-widget-two
						card-title="ONLINE RESERVATION"
						:show-visitors-capacity="true"
						:show-groups-capacity="true"
						:total-groups="total_checked_in.online_group"
						:total-visitors="total_checked_in.online_visitor"
						:total-groups-capacity="capacity.groups"
						:total-visitors-capacity="capacity.visitors"
						total-groups-label="Total Groups Check-In"
						total-visitors-label="Total Visitors Check-In"
					></box-widget-two>
				</div>
				<div class="col-sm-6 col-md-4 mb-2">
					<box-widget-two
						card-title="WALK-INS"
						:total-groups="total_checked_in.walk_in_group"
						:total-visitors="total_checked_in.walk_in"
						total-groups-label="Total Groups Check-In"
						total-visitors-label="Total Visitors Check-In"
					></box-widget-two>
				</div>
				<div class="col-sm-6 col-md-4  mb-2">
					<box-widget-two
						card-title="TOTAL CHECK-INS"
						:total-groups="parseInt(total_checked_in.online_group) + parseInt(total_checked_in.walk_in_group)"
						:total-visitors="parseInt(total_checked_in.online_visitor) + parseInt(total_checked_in.walk_in)"
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
					chart-id="revenue"
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
					chart-id="age"
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
					chart-id="nationality"
					:items="nationalities"
					format="Php"
					type="horizontalBar"
					title=""
					label=""
					></chart>
				</div>
				<div class="col-sm-6 col-md-6">
					<chart-with-label
					chart-id="visitor_type"
					:items="visitor_types"
					format="Php"
					type="pie"
					title="Tourist"
					label=""
					></chart-with-label>
				</div>
				<div class="col-sm-6 col-md-4">
					<chart-with-label
					chart-id="source"
					:items="source"
					format="Php"
					type="pie"
					title="Source"
					label=""
					></chart-with-label>
				</div>
				<div class="col-sm-6 col-md-4">
					<chart-with-label
					chart-id="special_fee"
					:items="special_fees"
					format="Php"
					type="pie"
					title="Special Fee"
					label=""
					></chart-with-label>
				</div>
				<div class="col-sm-6 col-md-4">
					<chart-with-label
					chart-id="gender"
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

import Datepicker from 'Components/datepickers/Datepicker.vue';
import Charts from 'Components/charts/Chart.vue';
import ChartWithLabel from 'Components/charts/ChartWithLabel.vue';
import BoxWidget from 'Components/widgets/BoxWidget.vue';
import BoxWidgetTwo from 'Components/widgets/GroupAndVisitorBoxWidget.vue';
import ProgressChart from 'Components/widgets/ProgressChart.vue';
import Select from 'Components/inputs/Select.vue';

export default {
	props: {
		destinations: Array,
	},
	methods: {
		filter(value, name) {
			this.filters[name] = value;
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
			this.capacity = data.capacity;
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
			capacity: [],

			destination: null,
			experiences: null,
		}
	},

	computed: {
		fetchParams() {
			return this.filters;
		},
	},

	watch: {
		destination(val) {
			this.experiences = [];
			_.each(this.destinations, (destination) => {
			    if(destination.id == val) {
			        this.experiences = destination.allocations;
			    }
			})
			this.experiences.push(all)
		}
	},

	components: {
		'date-picker': Datepicker,
		'chart': Charts,
		'box-widget': BoxWidget,
        'selector': Select,
		BoxWidgetTwo,
		ChartWithLabel,
		ProgressChart
	},

	mixins: [ FetchMixin ],
}
</script>