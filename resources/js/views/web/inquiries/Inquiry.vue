<template>
    <form-request :submit-url="submitUrl" @load="load" @success="fetch" sync-on-success>


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
           <!--  <button type="submit" class="frm-btn green">Submit</button> -->
            <action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
        </div>

        <!-- <card>
            <template v-slot:header>Basic Information</template>
            <div class="row">
                <div class="form-group col col-sm-12 col-md-12">
                    <label>Name</label>
                    <input v-model="item.name" name="name" type="text" class="form-control input-sm">
                </div>

                <image-picker
                class="form-group col-sm-12 col-md-12 mt-2"
                :value="item.image_path"
                label="Image"
                name="image_path"
                placeholder="Choose a File"
                ></image-picker>

            </div>

            <template v-slot:footer>
                <action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
                
            </template> 
        </card> -->

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

    data() {
        return {
            page_items: [],
        }
    },

    components: {
        'action-button': ActionButton,
        'image-picker': ImagePicker,
    },

    mixins: [ CrudMixin, ArrayHelpers ],
}
</script>