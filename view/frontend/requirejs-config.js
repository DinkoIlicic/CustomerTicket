var config = {
    map: {
        '*': {
            primjer1: 'Inchoo_Ticket/js/script-example'
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/checkout-data': {
                'Inchoo_Ticket/js/checkout-data-mixin': true
            }
        }
    },
    deps: ['Inchoo_Ticket/js/script-example']
};