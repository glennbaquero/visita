<template>
	<div>
		<div :id="'chart-holder-graph-'+chartId">
			<canvas ref="elem" :width="width" :height="height" :id="chartId"></canvas>
		</div>
	</div>
</template>

<script type="text/javascript">
import Chart from 'chart.js';
import ArrayHelpers from 'Mixins/array.js';

export default {
	watch: {
		items(value) {
			if (value) {
				this.initChart(value);
			}
		},
	},
	methods: {
		initChart(array) {
			$('#'+this.chartId).remove();
			$('#chart-holder-graph-'+this.chartId).append('<canvas ref="elem" width="'+this.width+'" height="'+this.height+'" id="'+this.chartId+'"></canvas>')
			var ctx = document.getElementById(this.chartId).getContext("2d");

			let config = {
			    type: this.type,
			    data: {
				    labels: this.array_pluck(array, this.itemLabel),
			        datasets: [{
			            // label: this.label,
			            data: this.array_pluck(array, this.itemData),
			            backgroundColor: this.array_pluck(array, this.itemBgColor),
			            borderColor: this.itemBgColor,
			            borderWidth: 2,
			            pointBackgroundColor: this.itemBgColor,
			            fill: false,
			            borderCapStyle: 'square',
			            pointBorderWidth: 3
			        }]
			    },
			    options: {
			        legend: {
			        	display: false,
			        },
			        title: {
			        	display: true,
			        	text: this.title,
			        	position: this.titlePosition,
			        	fontSize: this.fontSize,
			        },
			        scales: {
		                yAxes: [{
		                    ticks: {
		                        beginAtZero: true
		                    },
		                }],
		                xAxes: [{
		                    ticks: {
		                        beginAtZero: true
		                    }
		                }]
		            }
			    }
			};

			let myChart = new Chart(ctx, config);
		},
	},

	props: {
		items: {
			default: [],
			type: Array,
		},

		format: {
			type: String,
			default: null,
		},

		height: {
			default: 400,
		},

		width: {
			default: 400,
		},

		itemLabel: {
			default: 'label',
			type: String,
		},

		itemData: {
			default: 'data',
			type: String,
		},

		itemBgColor: {
			default: 'backgroundColor',
			type: String,
		},

		label: String,
		title: String,

		fontSize: {
			default: 14,
		},

		titlePosition: {
			default: 'bottom',
			type: String,
		},

		type: {
			default: 'pie',
			type: String,
		},

		chartId: String

	},

	data() {
		return {
			loading:false,
		}
	},

	mixins: [ ArrayHelpers ],
}
</script>