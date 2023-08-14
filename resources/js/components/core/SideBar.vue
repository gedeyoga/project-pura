<template>
    <!-- Sidebar -->
    <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
    >
        <!-- Sidebar - Brand -->
        <a
            class="sidebar-brand d-flex align-items-center justify-content-center"
            href="index.html"
        >
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a
                class="nav-link "
                href="#"
                @click.prevent="$router.push({ name: 'admin.dashboard' })"
            >
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a
            >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <template
            v-if="
                hasAccess('role.role-list') || 
                hasAccess('user.user-list') ||
                hasAccess('jenis_pura.jenis_pura-list')
            "
        >
        <!-- Heading -->
        <div class="sidebar-heading">Master Data</div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item" v-if="hasAccess('jenis_pura.jenis_pura-list')">
            <a
                class="nav-link"
                href="#"
                @click.prevent="$router.push({ name: 'jenis-puras.index' })"
            >
                <i class="fas fa-torii-gate"></i>
                <span>Data Jenis Pura</span></a
            >
        </li>
        <li class="nav-item" v-if="hasAccess('pura.pura-list')">
            <a
                class="nav-link"
                href="#"
                @click.prevent="$router.push({ name: 'puras.index' })"
            >
                <i class="fas fa-gopuram"></i>
                <span>Data Pura</span></a
            >
        </li>
        <li class="nav-item" v-if="hasAccess('sensor_pintu.sensor_pintu-list')">
            <a
                class="nav-link"
                href="#"
                @click.prevent="$router.push({ name: 'sensor-pintu.index'})"
            >
                <i class="fas fa-door-open"></i>
                <span>Sensor Pintu</span></a
            >
        </li>
        <li class="nav-item" v-if="hasAccess('sensor_cctv.sensor_cctv-list')">
            <a
                class="nav-link"
                href="#"
                @click.prevent="$router.push({ name: 'sensor-cctv.index'})"
            >
                <i class="fas fa-video"></i>
                <span>Sensor CCTV</span></a
            >
        </li>
        <li class="nav-item" v-if="hasAccess('user.user-list')">
            <a
                class="nav-link"
                href="#"
                @click.prevent="$router.push({ name: 'users.index' })"
            >
                <i class="fas fa-users"></i>
                <span>Kelola Pengguna</span></a
            >
        </li>
        <li class="nav-item" v-if="hasAccess('role.role-list')">
            <a
                class="nav-link"
                href="#"
                @click.prevent="$router.push({ name: 'roles.index' })"
            >
                <i class="fas fa-users-cog"></i>
                <span>Roles</span></a
            >
        </li>
        <hr class="sidebar-divider" />
        </template>
    </ul>
    <!-- End of Sidebar -->
</template>