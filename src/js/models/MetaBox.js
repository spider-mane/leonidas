export default class MetaBox {
    constructor(data) {
        this.data = data;
    }

    async addNewDeliveryPlatform() {
        try {
            const result = jQuery.post(ajaxurl, this.data);
            this.result = result;
        } catch (error) {
            alert(error);
        }

    }
}