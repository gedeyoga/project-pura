<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body" v-loading="loading">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ user_count }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2" v-loading="loading">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Sensor Pintu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ sensor_pintu_count }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body" v-loading="loading">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Pura</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ pura_count }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sensor CCTV Paling Sering Aktif <span>{{ getDateNow | formatMonth }}</span></h6>
            </div>
            <div class="card-body">
                <el-table
                    :data="sensor_cctv_list"
                    stripe
                    style="width: 100%"
                    ref="pageTable"
                    v-loading.body="tableIsLoading"
                >
                    <!-- <el-table-column
                        type="index"
                        label="No"
                        :index="indexMethod">
                    </el-table-column> -->
                    <el-table-column prop="cctv_photo" label="Foto CCTV" width="100">
                        <template slot-scope="scope">
                            <el-image
                                style="width: 50px; height: 50px"
                                :src="scope.row.cctv_photo"
                                :preview-src-list="[scope.row.cctv_photo]"
                                :fit="'cover'">
                                <div slot="error" class="image-slot">
                                    <i class="el-icon-picture-outline"></i>
                                </div>
                            </el-image>
                        </template>
                    </el-table-column>
                    <el-table-column prop="gs_kode_sensor" label="Kode Sensor">
                        <template slot-scope="scope">
                            {{ scope.row.gs_kode_sensor }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="pura.pura_nama" label="Pura">
                        <template slot-scope="scope">
                            {{ scope.row.pura.pura_nama }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="Status" label="Status" width="90px">
                        <template slot-scope="scope"> 
                            <el-tag size="mini" v-if="scope.row.cctv_status == 1" :type="'primary'" effect="dark">
                                Aktif
                            </el-tag>
                            <el-tag size="mini" v-else :type="'secondary'" effect="dark">
                                Tidak Aktif
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="jumlah_active" label="Jumlah Aktif">
                        <template slot-scope="scope">
                            {{ scope.row.jumlah_active  }}
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
            <div class="card-footer text-center">
                <el-button @click="$router.push({name: 'sensor-cctv.index'})" size="small" plain type="primary">Lihat Selengkapnya</el-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user_count: 0,
            sensor_pintu_count: 0,
            pura_count: 0,
            loading: false,
            sensor_pintu_list: [],

            sensor_cctv_list: [],
            tableIsLoading: false,
            pura_list: [],
            meta: {
                current_page: 1,
                per_page: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
            filter: {
                role: "",
                search: "",
            },
        };
    },

    methods:{
        fetchDataDashboard() {
            this.loading = true;
            axios.get(route('api.dashboard.admin'))
            .then((response) => {
                this.loading = false;
                this.user_count = response.data.user_count
                this.sensor_pintu_count = response.data.sensor_pintu_count
                this.pura_count = response.data.pura_count
            })
            .catch(() => {
                this.loading = false;
            });
        },

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
                    cctv_status: this.filter.cctv_status,
                    paginate:true,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.sensor-cctv.most-used"), properties).then((response) => {
                if (typeof response !== "undefined") {
                    this.tableIsLoading = false;
                    this.sensor_cctv_list = response.data.data;
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

        indexMethod(index) {
            return (this.meta.current_page - 1) * this.meta.per_page + index + 1;
        },
    },

    computed: {
        getDateNow() {
            return (new Date()).toLocaleDateString('en-ID')
        }
    },

    mounted() {
        this.fetchDataDashboard();
        this.fetchData();
    }
}
</script>