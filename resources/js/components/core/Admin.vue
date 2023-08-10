<template>
    <div>
        <div id="wrapper">
            <side-bar></side-bar>

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <navbar></navbar>
                    <div class="container pb-3">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

require("../../mixins.js");
require("../../components.js");

export default {
    data() {
        return {
            input: null,
        };
    },
};
</script>