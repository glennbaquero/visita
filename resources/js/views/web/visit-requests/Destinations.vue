<template>
	<div>
		<div class="dstntns-frm1__container inlineBlock-parent">
			<div class="dstntns-frm1__col width--55">
				<div class="dstntns-frm1__slider dstntns-frm--sldr__animation">
					<div class="dstntns-frm1__slider-item" v-for="destination in searchableDestinations">
						<div class="dstntns-frm1__slider-item-info-holder margin-a width--85"  >	
						<div class="vertical-parent">
								<div class="vertical-align align-b">
									<div class="dstntns-frm1__slider-item-info">
										<h5 class="frm-title l-margin-b clr--white dstntns-frm--sldr__animation-title">{{ destination.name }}</h5>
										<div 
											class="dstntns-frm--sldr__animation-description frm-description s-margin-b clr--white"
											v-html="destination.short_description"
										>
										</div>
										<div class="dstntns-frm--sldr__animation-button inlineBlock-parent width--100">
											<a 
												:href="destination.viewDestinationUrl" 
												class="frm-btn green s-margin-r"
											>View Destination</a>
											<a :href="destination.requestVisitUrl" class="frm-btn orange" v-if="destination.is_available">Request to Visit</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="frm-bckgrnd size-cover" :style="{backgroundImage: 'url(' + destination.image + ')'}"></div>
						<div class="dstntns-frm1__bgOverlay"></div>
					</div>
				</div>
			</div
			><div class="dstntns-frm1__col width--45">
				<div class="dstntns-frm1__col-inner-holder margin-a width--85">
					<div class="dstntns-frm1__search-holder width--100 align-r">
						<div class="dstntns-frm1__search frm-inpt m-margin-b">
							<input 
							    id="input-destination"
								type="text" 
								list="destinations-list"
								placeholder="Where do you want to go?"
								autocomplete="on"
							/>
							<datalist 
								id="destinations-list"
							>
								<option
									v-for="destination in searchableDestinations" 
									:id="destination.viewDestinationUrl"
									:value="destination.name"
								>
								</option>
							</datalist>
							<!-- <input type="text" v-model="searchItem" placeholder="Where do you want to go?" @keyup="search">
							<button><img src="images/search-button.png"></button> -->
						</div>
					</div>
					<p class="dstntns-frm1__caption frm-header clr--gray">Choose from stunning destinations committed to sustainable tourism.</p>
					<div class="dstntns-frm1__slider-thumbnail-holder">
						<div class="dstntns-frm1__slider-thumbnail" ref="slick">

							<div class="dstntns-frm1__slider-thumbnail-item" v-for="destination in searchableDestinations">
								<div class="dstntns-frm1__slider-thumbnail-item-img m-margin-b">
									<div class="frm-bckgrnd size-cover" :style="{backgroundImage: 'url(' + destination.image + ')'}"></div>
								</div>
								<div class="align-r">
									<p class="frm-header clr--gray">{{ destination.name }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props:{
			destinations: Array
		},

		data() {
			return {
				duplicateDestinations: [],
				searchableDestinations: [],
				searchItem: null
			}
		},

		mounted() {

			this.duplicateDestinations = this.destinations;
			this.searchableDestinations = this.destinations;


			// Search
			$('#input-destination').on('change',function() {
				var opt = $('option[value="'+$(this).val()+'"]');
				var url = opt.attr('id');
				window.location.href = url;
			});

		},

		methods: {
			search() {
				$('.dstntns-frm1__slider-thumbnail').slick('unslick');
				$('.dstntns-frm1__slider').slick('unslick');
				var result = [];
				_.forEach(this.duplicateDestinations, (value) => {
					if(_.includes(value.name.toLowerCase(), this.searchItem.toLowerCase())) {
						result.push(value);
					}
				});


				if(this.searchItem == null) {
					result = [];
					this.searchableDestinations = this.destinations;
				} else {
					this.searchableDestinations = result
				}

				this.reinitSlick();
				
			},

			reinitSlick() {
				$('.dstntns-frm1__slider').slick({
					infinite: this.searchableDestinations.length >= 3,
			        slidesToShow: 1,
			        slidesToScroll: 1,
			        speed: 1000,
			        fade: true,
			        autoplay: false,
			        arrows: false,
			        dots: false,
			        focusOnSelect: false,
			        asNavFor: '.dstntns-frm1__slider-thumbnail'
			    });
				$('.dstntns-frm1__slider-thumbnail').slick({
					infinite: this.searchableDestinations.length >= 3,
			        slidesToShow: 3,
			        slidesToScroll: 1,
			        speed: 1000,
			        autoplay: false,
			        arrows: false,
			        dots: false,
			        focusOnSelect: true,
			        asNavFor: '.dstntns-frm1__slider'
			    });
			}
		}
	}
</script>