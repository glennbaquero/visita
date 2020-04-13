<template>
    <form-request :submit-url="submitUrl" @load="load" @success="fetch" sync-on-success class="cntct-frm__animation">
        <h5 class="frm-title l-margin-b clr--white">Get Involved</h5>
        <div class="cntct-frm__animation-form width--85 margin-a">
            <div class="cnttc-frm__animation-form inlineBlock-parent l-margin-t">
                <div class="width--50 align-t m-margin-b">
                    <div class="width--95 frm-cntnr align-l">
                        <div class="frm-inpt m-margin-b">
                            <input type="text" name="fullname" placeholder="Full Name">
                        </div>
                        <div class="frm-inpt m-margin-b cntct-frm__number">
                            <input type="number" name="contact_number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" placeholder="Contact Number" maxlength="10">
                        </div>
                        <div class="frm-inpt m-margin-b">
                            <input type="email" name="email" placeholder="Email Address">
                        </div>
                    </div>
                </div
                ><div class="width--50 align-t m-margin-b">
                    <div class="width--95 frm-cntnr align-r">
                        <div class="frm-inpt m-margin-b">
                            <input type="text" name="purpose" placeholder="Purpose">
                        </div>
                        <div class="frm-inpt m-margin-b">
                            <textarea name="message" rows="4" placeholder="Message"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width--100 align-l l-margin-b">
                <p class="frm-header s-margin-b clr--white">Follow us:</p>
                <div class="inlineBlock-parent">
                    <a :href="fb" target="_blank" class="cntct-frm1__img">
                        <img :src="facebookIcon">
                    </a>
                    <a :href="insta" target="_blank" class="cntct-frm1__img">
                        <img :src="instagramIcon">
                    </a>
                    <a :href="twitter" target="_blank" class="cntct-frm1__img big">
                        <img :src="twitterIcon">
                    </a>
                    <a :href="youtube" target="_blank" class="cntct-frm1__img big">
                        <img :src="youtubeIcon">
                    </a>
                </div>
            </div>  
        </div>
        <div class="cntct-frm__animation-button width--100 align-c">
            <action-button type="submit" :disabled="loading" class="frm-btn green">Submit</action-button>
        </div>

        <loader :loading="loading"></loader>
      
    </form-request>
</template>

<script type="text/javascript">
import CrudMixin from '../../../mixins/crud.js';
import ArrayHelpers from '../../../mixins/array.js';

import ActionButton from '../../../components/buttons/ActionButton.vue';
import ImagePicker from '../../..//components/inputs/ImagePicker.vue'

export default {
    props: {
        fb: String,
        insta: String,
        twitter: String,
        insta: String,
        youtube: String,
    },

    methods: {
        fetchSuccess(data) {
            this.item = data.item ? data.item : this.item;
        },
    },

    data() {
        return {
            facebookIcon: 'images/facebook-icon.png',
            instagramIcon: 'images/instagram-icon.png',
            twitterIcon: 'images/twitter-icon.png',
            youtubeIcon: 'images/youtube-icon.png',
        }
    },

    components: {
        'action-button': ActionButton,
        'image-picker': ImagePicker,
    },

    mixins: [ CrudMixin, ArrayHelpers ],
}
</script>