<template>
    <div class="jenis-pura-list">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Jenis Pura</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Jenis Pura
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>Kelola Jenis Pura</span>
                <el-button
                    v-if="hasAccess('jenis_pura.jenis_pura-create')"
                    type="primary"
                    icon="fas fa-plus"
                    @click="$refs['dialogJenisPuraRef'].openDialog()"
                    >Tambah Jenis Pura</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-4">
                        <label for=""><small>Filter Status</small></label>
                        <el-checkbox-group @change="fetchData" v-model="filter.jp_active">
                            <el-checkbox label="y" border>Aktif</el-checkbox>
                            <el-checkbox label="n" border>Tidak Aktif</el-checkbox>
                        </el-checkbox-group>
                    </div>
                    <div class="col">
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
                    <el-table-column
                        type="index"
                        label="No"
                        :index="indexMethod">
                    </el-table-column>
                    <el-table-column prop="jp_nama" label="Jenis Pura">
                        <template slot-scope="scope">
                            {{ scope.row.jp_nama }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="jp_active" label="Status">
                        <template slot-scope="scope">
                            <el-switch
                                v-model="scope.row.jp_active"
                                active-text="Aktif"
                                active-value="y"
                                @change="onUpdateStatus(scope.row)"
                                inactive-value="n">
                            </el-switch>
                        </template>
                    </el-table-column>
                    <el-table-column prop="created_at" label="Dibuat">
                        <template slot-scope="scope">
                            {{ scope.row.created_at | formatDateTime }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('jenis_pura.jenis_pura-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="$refs['dialogJenisPuraRef'].openDialog(scope.row)"
                                ></el-button>
                                <el-button
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

        <dialog-jenis-pura-form 
            ref="dialogJenisPuraRef"
            @onClose="fetchData()"
        ></dialog-jenis-pura-form>
    </div>
</template>

<script>
import _ from "lodash";
import DialogJenisPuraForm from './DialogJenisPuraForm.vue';

export default {
    components: {
        DialogJenisPuraForm,
    },
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
                jp_active: [],
                search: "",
            },
        };
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
                    jp_active: this.filter.jp_active,
                    search : this.filter.search,
                    paginate: true,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.jenis-pura.index"), properties).then((response) => {
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
                    route("api.jenis-pura.destroy", {
                        jenis_pura: row.id,
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

        onUpdateStatus(row){
            axios
                .put(route('api.jenis-pura.update' , {
                    jenis_pura: row.id
                }) , row)
                .then((response) => {
                    this.loading = false;
                    if(response.status == 200) {
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });
                        this.closeDialog();
                    }
                })
                .catch(() => {
                    this.loading = false;
                });
        },

        indexMethod(index) {
            return (this.meta.current_page - 1) * this.meta.per_page + index + 1;
        }

    },

    mounted() {
        this.fetchData();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
.jenis-pura-list .el-checkbox{
    margin-right: 0 !important;
}
</style>