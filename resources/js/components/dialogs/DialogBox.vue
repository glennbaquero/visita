<template>
	<div ref="modal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="card" :class="type_class">
					<div class="card-header">
						<h5 class="modal-title">{{ title }}</h5>
						<button @click="close" type="button" class="close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="card-body" v-html="message"></div>
					<div v-if="array_count(buttons)" class="card-footer text-right">
				    	<button v-for="button in buttons" :type="button.type" :class="button.class" @click="button.action"><span :class="button.icon"></span>{{ button.label }}</button>
				    </div>
				</div>
				
			</div>
		</div>
	</div>
</template>

<script>
import { EventBus } from '../../EventBus.js';
import ArrayMixin from '../../mixins/array.js';

export default {
	mounted() {
		this.element = $(this.$refs.modal);

		this.element.on('hidden.bs.modal', function (e) {
			EventBus.$emit('hide-dialog');
		})

		EventBus.$on('show-dialog', (data) => {
			this.title = data.title;
			this.type = data.type;
			this.message = data.message;
			this.options = data.options ? data.options : {};

			this.$nextTick(() => {
				this.buttons = this.options.buttons;
				this.setButtons();
			});

			this.$nextTick(() => {
				this.show();
			});
		});
	},

	methods: {
		show() {
			this.element.modal('show');
		},

		close() {
			this.element.modal('hide');
		},

		setButtons() {
			if (this.array_count(this.buttons)) {
				this.buttons.forEach(button => {
					button.type = button.type ? button.type : 'button';
					button.label = button.label ? button.label : '';
					button.icon = button.icon ? button.icon : '';
					button.class = button.class ? button.class : '';
					button.action = button.action ? button.action : () => {};
				});
			}
		},
	},

	computed: {
		type_class() {
			switch(this.type) {
				case 'error':
					return 'text-white bg-danger';
				case 'warning':
					return 'text-white bg-warning';
				case 'success':
					return 'text-white bg-success';
				case 'info':
					return 'text-white bg-info';
			}
		}
	},

	data() {
		return {
			element: null,
			title: null,
			message: null,
			type: null,
			options: {},
			buttons: [],
		}
	},

	mixins: [ ArrayMixin ],
}
</script>