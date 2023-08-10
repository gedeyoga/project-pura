<template>
    <div>
        <component :is="component"></component>
    </div>
</template>

<script>
import LayoutFull from "../layouts/LayoutFull.vue";
import LayoutAdmin from "../layouts/LayoutAdmin.vue";
import LayoutFrontEnd from "../layouts/LayoutFrontEnd.vue";

export default {
    components: {
        LayoutFull,
        LayoutAdmin,
        LayoutFrontEnd
    },
    data() {
        return {
            input: null,
        };
    },

    computed: {
        component() {
            if (this.$route.meta) {
                if (this.$route.meta.layout == "full") {
                    return "layout-" + this.$route.meta.layout;
                } else if(this.$route.meta.layout == 'front-end') {
                    return "layout-" + this.$route.meta.layout;
                }
            }
            return "layout-admin";
        },
    },
};
</script>