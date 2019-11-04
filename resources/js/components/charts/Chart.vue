<template>
	<div>
		<canvas ref="elem" :width="width" :height="height"></canvas>
	</div>
</template>

<script type="text/javascript">
import Chart from 'chart.js';
import ArrayHelpers from '../../mixins/array.js';

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
			let ctx = this.$refs.elem.getContext('2d');

			let config = {
			    type: this.type,
			    data: {
				    labels: this.array_pluck(array, this.itemLabel),
			        datasets: [{
			            label: this.label,
			            data: this.array_pluck(array, this.itemData),
			            backgroundColor: this.array_pluck(array, this.itemBgColor),
			            borderColor: '#ddd',
			            borderWidth: 1
			        }]
			    },
			    options: {
			        legend: {
			        	display: true,
			        },
			        title: {
			        	display: true,
			        	text: this.title,
			        	position: this.titlePosition,
			        	fontSize: this.fontSize,
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
	},

	data() {
		return {
			loading:false,
		}
	},

	mixins: [ ArrayHelpers ],
}
</script>