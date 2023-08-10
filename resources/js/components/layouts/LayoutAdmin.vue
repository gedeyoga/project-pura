<template>
    <div>
        <admin></admin>
    </div>
</template>

<script>
import { defineAsyncComponent } from "vue";

export default {
    components: {
        Admin: defineAsyncComponent(() =>
            import("../core/Admin.vue")
        ),
    },
};
</script>