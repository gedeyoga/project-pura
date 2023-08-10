<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Role</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Role
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>List Role</span>
                <el-button
                    v-if="hasAccess('role.role-create')"
                    type="primary"
                    size="small"
                    icon="fas fa-plus"
                    @click="$router.push({ name: 'roles.create' })"
                    >Tambah Role</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-12">
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
                    <el-table-column prop="name" label="Nama">
                        <template slot-scope="scope">
                            <a
                                @click.prevent="
                                    $router.push({
                                        name: 'roles.edit',
                                        params: {
                                            role: scope.row.id,
                                        },
                                    })
                                "
                                href="#"
                            >
                                {{ scope.row.name }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="name" label="Terakhir Diperbaharui">
                        <template slot-scope="scope">
                            {{ scope.row.updated_at | formatDateTime }}
                        </template>
                    </el-table-column>

                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('role.role-update')"
                                    type="primary"
                                    size="small"
                                    icon="el-icon-edit"
                                    @click="
                                        $router.push({
                                            name: 'roles.edit',
                                            params: {
                                                role: scope.row.id,
                                            },
                                        })
                                    "
                                ></el-button>
                                <el-button
                                    v-if="hasAccess('role.role-delete')"
                                    size="small"
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
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
            axios.get(route("api.role.index"), properties).then((response) => {
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
                    route("api.role.destroy", {
                        role: row.id,
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
        // this.fetchRoles();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>