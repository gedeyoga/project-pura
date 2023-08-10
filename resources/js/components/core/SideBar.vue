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
                class="nav-link"
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
                hasAccess('user.user-list')
            "
        >
        <!-- Heading -->
        <div class="sidebar-heading">Master Data</div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#collapseUser"
                aria-expanded="true"
                aria-controls="collapseUser"
            >
                <i class="fas fa-users"></i>
                <span>User</span>
            </a>
            <div
                id="collapseUser"
                class="collapse"
                aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar"
            >
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Manajemen User</h6>
                    <a
                        v-if="hasAccess('user.user-list')"
                        class="collapse-item"
                        href="#"
                        @click.prevent="$router.push({ name: 'users.index' })"
                        >User</a
                    >
                    <a
                        v-if="hasAccess('role.role-list')"
                        class="collapse-item"
                        href="#"
                        @click.prevent="$router.push({ name: 'roles.index' })"
                        >Role</a
                    >
                </div>
            </div>
        </li>
        </template>

        <template
            v-if="
                hasAccess('category.category-list')
            "
        >
        <!-- Heading -->
        <div class="sidebar-heading">Manajemen Content</div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#collapseBlog"
                aria-expanded="true"
                aria-controls="collapseBlog"
            >
                <i class="fas fa-users"></i>
                <span>Blog</span>
            </a>
            <div
                id="collapseBlog"
                class="collapse"
                aria-labelledby="headingBlog"
                data-parent="#accordionSidebar"
            >
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Manajemen Content</h6>
                    <a
                        v-if="hasAccess('post.post-list')"
                        class="collapse-item"
                        href="#"
                        @click.prevent="
                            $router.push({ name: 'posts.index' })
                        "
                        >Postingan</a
                    >
                    <a
                        v-if="hasAccess('category.category-list')"
                        class="collapse-item"
                        href="#"
                        @click.prevent="
                            $router.push({ name: 'categories.index' })
                        "
                        >Kategori</a
                    >
                </div>
            </div>
        </li>
        </template>

        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <img
                class="sidebar-card-illustration mb-2"
                :src="$url + '/image/undraw_rocket.svg'"
                alt="..."
            />
            <p class="text-center mb-2">
                <strong>SB Admin Pro</strong> is packed with premium features,
                components, and more!
            </p>
            <a
                class="btn btn-success btn-sm"
                href="https://startbootstrap.com/theme/sb-admin-pro"
                >Upgrade to Pro!</a
            >
        </div>
    </ul>
    <!-- End of Sidebar -->
</template>