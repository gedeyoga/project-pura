<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Pura</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Pura
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>Kelola Pura</span>
                <el-button
                    v-if="hasAccess('pura.pura-create')"
                    type="primary"
                    icon="fas fa-plus"
                    @click="$router.push({ name: 'puras.create' })"
                    >Tambah Pura</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-3">
                        <label for=""><small>Filter Jenis Pura</small></label>
                         <el-select v-model="filter.jp_id" @change="fetchData" placeholder="Pilih Jenis Pura" filterable clearable>
                            <el-option
                            v-for="(item, index) in jenis_pura_list"
                            :key="index"
                            :label="item.jp_nama"
                            :value="item.id">
                            </el-option>
                        </el-select>
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
                    <el-table-column prop="pura_nama" label="Nama Pura">
                        <template slot-scope="scope">
                            <a
                                @click.prevent="
                                    $router.push({
                                        name: 'puras.edit',
                                        params: {
                                            pura: scope.row.id,
                                        },
                                    })
                                "
                                href="#"
                            >
                                {{ scope.row.pura_nama }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="jp_nama" label="Jenis Pura">
                        <template slot-scope="scope">
                            {{ scope.row.jenis_pura.jp_nama }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="pura_ip" label="IP Address">
                        <template slot-scope="scope">
                            {{ scope.row.pura_ip }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="kelurahan.name" label="Kelurahan">
                        <template slot-scope="scope">
                            {{ scope.row.kelurahan.name }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('pura.pura-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="
                                        $router.push({
                                            name: 'puras.edit',
                                            params: {
                                                pura: scope.row.id,
                                            },
                                        })
                                    "
                                ></el-button>
                                <el-button
                                    v-if="hasAccess('pura.pura-delete')"
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
                jp_id: "",
                search: "",
            },
            jenis_pura_list: [],
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
                    relations: "jenis_pura,kelurahan",
                    search : this.filter.search,
                    paginate: true,
                    jp_id: this.filter.jp_id
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.pura.index"), properties).then((response) => {
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
                    route("api.pura.destroy", {
                        pura: row.id,
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

        indexMethod(index) {
            return (this.meta.current_page - 1) * this.meta.per_page + index + 1;
        },

        fetchJenisPura() {
            axios
                .get(route('api.jenis-pura.index'))
                .then((response) => {
                    this.jenis_pura_list = response.data.data;
                })
        },
    },

    mounted() {
        this.fetchData();
        this.fetchJenisPura();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>