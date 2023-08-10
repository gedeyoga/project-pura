<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List User</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        User
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>List User</span>
                <el-button
                    v-if="hasAccess('user.user-list')"
                    type="primary"
                    icon="fas fa-plus"
                    @click="$router.push({ name: 'users.create' })"
                    >Tambah User</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-3">
                        <span class="filter-text">Filter Role</span>
                        <el-select
                            clearable
                            v-model="filter.role"
                            placeholder="Pilih Role"
                        >
                            <el-option
                                v-for="role in list_roles"
                                :key="role.id"
                                :label="role.name"
                                :value="role.name"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-9">
                        <div
                            class="btn-group float-right"
                        >
                            <el-input
                                prefix-icon="el-icon-search"
                                @keyup.enter.native="fetchData"
                                v-model="filter.search"
                                :placeholder="'Cari..'"
                            >
                                <template slot="append">
                                    <el-button @click="fetchData">
                                        <span class="fa fa-search"></span>
                                    </el-button>
                                </template>
                            </el-input>
                        </div>
                    </div>
                </div>

                <div class="border-bottom"></div>

                <el-table
                    :data="data"
                    stripe
                    style="width: 100%"
                    ref="pageTable"
                    v-loading.body="tableIsLoading"
                >
                    <el-table-column prop="full_name" label="Nama">
                        <template slot-scope="scope">
                            <a
                                @click.prevent="
                                    $router.push({
                                        name: 'users.edit',
                                        params: {
                                            user: scope.row.id,
                                        },
                                    })
                                "
                                href="#"
                            >
                                {{ scope.row.name }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="email" label="Email">
                        <template slot-scope="scope">
                            {{ scope.row.email }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="role" label="Role">
                        <template slot-scope="scope">
                            {{ scope.row.roles[0].name }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('user.user-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="
                                        $router.push({
                                            name: 'users.edit',
                                            params: {
                                                user: scope.row.id,
                                            },
                                        })
                                    "
                                ></el-button>
                                <el-button
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
                                    v-if="user.id != scope.row.id && hasAccess('user.user-delete')"
                                    @click="onDelete(scope.row)"
                                ></el-button>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <div
                    class="pagination-wrap"
                    style="text-align: center; padding-top: 20px"
                >
                    <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page.sync="meta.current_page"
                        :page-sizes="[10, 20, 50, 100]"
                        :page-size="parseInt(meta.per_page)"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="meta.total"
                    ></el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    data() {
        return {
            data: [],
            tableIsLoading: false,
            meta: {
                current_page: 1,
                per_page: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
            list_roles: [],
            filter: {
                role: "",
                search: "",
            },
        };
    },

    watch: {
        'filter.role' : function(value) {
            this.fetchData();
        }
    },
    methods: {
        queryServer(customProperties) {
            const cancelSource = axios.CancelToken.source();
            const properties = {
                params: {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
                    search: this.searchQuery,
                    relations: "roles",
                    roles: this.filter.role,
                    search : this.filter.search
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.user.index"), properties).then((response) => {
                if (typeof response !== "undefined") {
                    this.tableIsLoading = false;
                    this.data = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                    this.order_meta.order_by = properties.order_by;
                    this.order_meta.order = properties.order;
                }
            });
        },
        fetchData() {
            this.tableIsLoading = true;
            if (this.request) this.cancel();
            this.queryServer();
        },
        handleSizeChange(event) {
            console.log(`per page :${event}`);
            this.tableIsLoading = true;
            this.meta.per_page = event;
            this.queryServer();
        },
        handleCurrentChange(event) {
            console.log(`current page :${event}`);
            this.tableIsLoading = true;
            this.meta.current_page = event;
            this.queryServer();
        },
        handleSortChange(event) {
            console.log("sorting", event);
            this.tableIsLoading = true;
            this.queryServer({
                order_by: event.prop,
                order: event.order,
            });
        },
        performSearch: _.debounce(function (query) {
            console.log(`searching:${query.target.value}`);
            this.tableIsLoading = true;
            this.queryServer({
                search: query.target.value,
            });
        }, 300),
        cancel() {
            this.request.cancel();
        },

        onDelete(row) {
            axios
                .delete(
                    route("api.user.destroy", {
                        user: row.id,
                    })
                )
                .then((response) => {
                    this.$notify({
                        title: "Pemberitahuan",
                        message: response.data.message,
                        type: "success",
                    });

                    this.fetchData();
                });
        },

        fetchRoles() {
            axios
                .get(route("api.role.index"), {
                    params: {
                        type: "all",
                    },
                })
                .then((response) => {
                    this.list_roles = response.data.data;
                });
        },
    },

    mounted() {
        this.fetchData();
        this.fetchRoles();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>