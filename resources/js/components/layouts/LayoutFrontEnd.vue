<template>
    <div>
        <header-component></header-component>
        <router-view :key="$router.fullPath"></router-view>
        <footer-component></footer-component>
    </div>
</template>

<script>

import HeaderComponent from "../core/frontend/HeaderComponent.vue";
import FooterComponent from "../core/frontend/FooterComponent.vue";

export default {
    components: {
        HeaderComponent,
        FooterComponent
    },
}
</script>