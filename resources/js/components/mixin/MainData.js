export default {
    data() {
        return  {
            user: window.admin_panel.user
        }
    },

    methods : {
        previewImage(url_image){
            this.$imagePreview({
                initIndex: 0,
                images: url_image,
                zIndex: 999999999999999
            });
        },

        hasAccess(permission) {
            let roles = this.user.roles.find((item) => true);

            let data_permission = permission.split('.');
            let module = data_permission[0];
            let permission_list = roles.permissions[module];
            
            if(permission_list) {
                let data = permission_list.find((item) => item.name == permission);
                if (data) {
                    return data.allow;
                }
            }

            return false;
        }
    },
}