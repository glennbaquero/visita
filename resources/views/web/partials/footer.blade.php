<footer class="ftr-frm">
	<div class="frm-cntnr align-c width--90">
		<div class="inlineBlock-parent">
			<div class="frm-cntnr__nav-col width--33 align-l">
				<a href="">
					<img src="{{ asset('images/visita-logo.png') }}" class="frm-cntnr__nav-logo">
				</a>
			</div
			><div class="frm-cntnr__nav-col width--33 align-c frm-description clr--white">
				<div class="inlineBlock-parent s-margin-b">
                    <a href="{{ $fb->content }}" target="_blank" class="ftr-frm_img">
                        <img src="{{ asset('images/facebook-icon.png') }}">
                    </a>
                    <a href="{{ $insta->content }}" target="_blank" class="ftr-frm_img">
                        <img src="{{ asset('images/instagram-icon.png') }}">
                    </a>
                    <a href="{{ $twitter->content }}" target="_blank" class="ftr-frm_img big">
                        <img src="{{ asset('images/twitter-icon.png') }}">
                    </a>
                    <a href="{{ $youtube->content }}" target="_blank" class="ftr-frm_img big">
                        <img src="{{ asset('images/youtube-icon.png') }}">
                    </a>
				</div>
				<p>{{ now()->year }} &copy; {{ config('app.name') }}</p>
			</div
			><div class="frm-cntnr__nav-col width--33 align-r">
				<a href="privacy-policy" class="frm-cntnr__nav-link bold">Privacy Policy</a>
			</div>
		</div>
	</div>
</footer>