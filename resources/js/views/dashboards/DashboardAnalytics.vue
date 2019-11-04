<template>
	<div class="row">
		<div class="col-12">
			<date-range
            @change="filter($event)"
            ></date-range>
		</div>
		<div class="col-12 col-sm-12">
			<div class="card">
				<div class="card-header bg-light">User Analytics</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="row">
								<box-widget
								class="col-sm-12 col-md-12"
								label="System Usage"
								color="bg-primary"
								icon="fas fa-chart-line"
								:count="usage"
								></box-widget>

								<box-widget
								class="col-sm-6 col-md-6"
								label="Total Users"
								color="bg-warning"
								icon="fa fa-users"
								:count="count"
								></box-widget>

								<box-widget
								class="col-sm-6 col-md-6"
								label="Total Login"
								color="bg-success"
								icon="fas fa-key"
								:count="login"
								></box-widget>

								<box-widget
								class="col-sm-6 col-md-6"
								label="Active Users"
								color="bg-info"
								icon="fas fa-user-check"
								:count="active"
								></box-widget>

								<box-widget
								class="col-sm-6 col-md-6"
								label="Inactive Users"
								color="bg-danger"
								icon="fas fa-user-alt-slash"
								:count="inactive"
								></box-widget>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<chart
							:items="usage_chart"
							type="doughnut"
							title="System Usage"
							></chart>
						</div>
					</div>
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
import BoxWidget from '../../components/widgets/BoxWidget.vue';

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
	},

	mixins: [ FetchMixin ],
}
</script>