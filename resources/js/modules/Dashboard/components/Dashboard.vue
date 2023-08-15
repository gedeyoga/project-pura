<template>
    <div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <span>{{ getDateNow | formatDate }}</span>
        </div>
        <dashboard-user v-if="hasAccess('dashboard.dashboard-user')"></dashboard-user>
        <dashboard-admin v-else-if="hasAccess('dashboard.dashboard-admin')"></dashboard-admin>
    </div>
</template>

<script>
import DashboardUser from "./DashboardUser.vue";
import DashboardAdmin from "./DashboardAdmin.vue";

export default {
    components: {
        DashboardUser, 
        DashboardAdmin       
    },
    data() {
        return {};
    },

    computed: {
        getDateNow() {
            return (new Date()).toLocaleDateString('en-ID')
        }
    },
}
</script>