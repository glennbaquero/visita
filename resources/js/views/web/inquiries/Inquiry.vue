<template>
    <form-request :submit-url="submitUrl" @load="load" @success="fetch" class="inlineBlock-parent" sync-on-success>
        <div class="width--50 align-t m-margin-b">
            <div class="width--95 frm-cntnr align-l">
                <div class="frm-inpt m-margin-b">
                    <input type="text" name="fullname" placeholder="Full Name">
                </div>
                <div class="frm-inpt m-margin-b">
                    <input type="number" name="contact_number" placeholder="Contact Number">
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
        <div class="width--100 align-c">
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
    methods: {
        fetchSuccess(data) {
            this.item = data.item ? data.item : this.item;
        }
    },

    components: {
        'action-button': ActionButton,
        'image-picker': ImagePicker,
    },

    mixins: [ CrudMixin, ArrayHelpers ],
}
</script>