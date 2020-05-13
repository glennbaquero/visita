export default {
    data()
    {
        return {
            PRXPayPal: {
                gateway_url: null,
                settings: {
                    cmd: '_cart',
                    upload: '1',
                    currency_code: null,
                    business: null,
                    handling_cart: 0,
                    discount_amount_cart: 0,
                    return: null,
                    cancel_return: null,
                    notify_url: null,
                    rm: '2',
                    invoice: null,
                },
                cart: [],
            }
        };
    },

    mounted()
    {
        // Populate default vars
        this.$nextTick(function () {

            let prx_paypal_settings =  window.prx_paypal_settings;

            this.PRXPayPal.gateway_url = prx_paypal_settings.gateway_url;
            this.PRXPayPal.settings.business = prx_paypal_settings.business;
            this.PRXPayPal.settings.return = prx_paypal_settings.return;
            this.PRXPayPal.settings.notify_url = prx_paypal_settings.notify_url;
            this.PRXPayPal.settings.cancel_return = prx_paypal_settings.cancel_return;

        });

    },
    computed: {
        PRXPayPalForm()
        {
            let form = document.createElement("form");

            form.method = "POST";
            form.action = this.PRXPayPal.gateway_url;

            for(var key in this.PRXPayPal.settings) {

                let elem = document.createElement("input");

                elem.name = key;
                elem.setAttribute('value', this.PRXPayPal.settings[key]);

                form.appendChild(elem);

            }

            return form;

        }
    },
    methods: {
        PRXPayPalSubmit: function(cart, invoice_reference, currency, discount = 0) {
            
            this.PRXPayPal.settings.invoice = invoice_reference;
            this.PRXPayPal.settings.currency_code = currency;
            this.PRXPayPal.settings.discount_amount_cart = discount;

            let form = this.PRXPayPalForm;

            for(var i = 0; i < cart.length; i++) {


                let item_name = document.createElement("input");
                item_name.name = 'item_name_' + (i + 1);
                item_name.setAttribute('value', cart[i].name);
                form.appendChild(item_name);

                let amount = document.createElement("input");
                amount.name = 'amount_' + (i + 1);
                amount.setAttribute('value', cart[i].price);
                form.appendChild(amount);

                // Quantity
                let qty = document.createElement("input");
                qty.name = 'quantity_' + (i + 1);
                qty.setAttribute('value', cart[i].qty);
                form.appendChild(qty);

            }

            document.body.appendChild(form);
            form.submit();

        }
    }
};