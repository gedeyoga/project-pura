<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Sensor Pintu</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Sensor Pintu
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>Kelola Sensor Pintu</span>
                <el-button
                    v-if="hasAccess('sensor_pintu.sensor_pintu-list')"
                    type="primary"
                    icon="fas fa-plus"
                    @click="$router.push({ name: 'sensor-pintu.create' })"
                    >Tambah Sensor Pintu</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-3" v-if="hasAccess('sensor_pintu.sensor_pintu-all')">
                        <label for=""><small>Filter Pura</small></label>
                        <el-select v-model="filter.pura_id" @change="fetchData" placeholder="Pilih Jenis Pura" filterable clearable>
                            <el-option
                            v-for="(item, index) in pura_list"
                            :key="index"
                            :label="item.pura_nama"
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
                    <el-table-column prop="gs_nama" label="Nama Sensor">
                        <template slot-scope="scope">
                            <a
                                @click.prevent="
                                    $router.push({
                                        name: 'sensor-pintu.edit',
                                        params: {
                                            sensor_pintu: scope.row.id,
                                        },
                                    })
                                "
                                href="#"
                            >
                                {{ scope.row.gs_nama }} 
                            </a> <br>
                            <small>{{ scope.row.gs_kode_sensor }}</small>
                        </template>
                    </el-table-column>
                    <!-- <el-table-column prop="gs_kode_sensor" label="Kode">
                        <template slot-scope="scope">
                            {{ scope.row.gs_kode_sensor }}
                        </template>
                    </el-table-column> -->
                    <el-table-column prop="pura_id" label="Pura">
                        <template slot-scope="scope">
                            {{ scope.row.pura.pura_nama }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="ping_at" label="Terakhir Ping">
                        <template slot-scope="scope">
                            {{ scope.row.ping_at | formatDateTime }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="Status" label="Status" width="100">
                        <template slot-scope="scope">
                            <el-switch
                                v-model="scope.row.gs_sensor_pintu"
                                active-text="Aktif"
                                active-value="1"
                                @change="onUpdateStatus(scope.row)"
                                inactive-value="0">
                            </el-switch>
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('sensor_pintu_log.sensor_pintu_log-list')"
                                    type="success"
                                    icon="el-icon-data-line"
                                    @click="
                                        $router.push({
                                            name: 'sensor-pintu.riwayat',
                                            params: {
                                                sensor_pintu: scope.row.id,
                                            },
                                        })
                                    "
                                ></el-button>
                                <el-button
                                    v-if="hasAccess('sensor_pintu.sensor_pintu-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="
                                        $router.push({
                                            name: 'sensor-pintu.edit',
                                            params: {
                                                sensor_pintu: scope.row.id,
                                            },
                                        })
                                    "
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
            filter: {
                pura_id: "",
                search: "",
            },
            pura_list: [],
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
                    relations: "pura",
                    search : this.filter.search,
                    pura_id : this.filter.pura_id,
                    paginate:true,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.sensor-pintu.index"), properties).then((response) => {
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

        onUpdateStatus(row){
            axios
                .put(route('api.sensor-pintu.update' , {
                    sensor_pintu: row.id
                }) , row)
                .then((response) => {
                    this.loading = false;
                    if(response.status == 200) {
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });
                    }
                })
                .catch(() => {
                    this.loading = false;
                });
        },

        onDelete(row) {
            axios
                .delete(
                    route("api.sensor-pintu.destroy", {
                        sensor_pintu: row.id,
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

        fetchPura() {
            axios
                .get(route('api.pura.index'))
                .then((response) => {
                    this.pura_list = response.data.data;
                })
        },
    },

    mounted() {
        if(this.hasAccess('sensor_pintu.sensor_pintu-all')) {
            this.fetchPura();
        } else {
            if(this.user.pura.length > 0) {
                this.filter.pura_id = this.user.pura[0].id;
            }
        }
        this.fetchData();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>