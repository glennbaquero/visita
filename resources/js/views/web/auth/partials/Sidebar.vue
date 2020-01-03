<template>
	<div>
		<div class="width--65 margin-a align-l">

			<a href="user/dashboard" class="dshbrd-frm1__btn-list inlineBlock-parent">
				<img src="asset('images/dashboard-icon.png')" class="dshbrd-frm1__btn-icon" :class="activeMenuOpen">
				<p class="dshbrd-frm1__btn" :class="activeMenuOpen">Dashboard</p>
			</a>

			<a href="user/profile" class="dshbrd-frm1__btn-list inlineBlock-parent">
				<img src="asset('images/profile-icon.png')" class="dshbrd-frm1__btn-icon" :class="activeMenuOpen">
				<p class="dshbrd-frm1__btn" :class="activeMenuOpen">Profile</p>
			</a>

			<a href="#" class="dshbrd-frm1__btn-list inlineBlock-parent">
				<img src="asset('images/log-out-icon.png')" class="dshbrd-frm1__btn-icon">
				<p class="dshbrd-frm1__btn">Log Out</p>
			</a>

		</div>
	</div>
</template>