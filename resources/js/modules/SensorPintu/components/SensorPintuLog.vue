<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Riwayat {{ data_sensor_pintu.gs_nama }}</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Sensor Pintu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Riwayat {{ data_sensor_pintu.gs_nama }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span> Riwayat {{ data_sensor_pintu.gs_nama }}</span>
                <el-button
                    icon="el-icon-back"
                    @click.prevent="$router.back()">
                    Kembali
                </el-button>
                               
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <label for=""><small>Filter Tanggal</small></label>
                        <div class="d-block">
                            <el-date-picker
                                v-model="filter.date"
                                type="daterange"
                                range-separator="-"
                                format="dd MMMM yyyy"
                                value-format="yyyy-MM-dd"
                                start-placeholder="Tgl Awal"
                                end-placeholder="Tgl Akhir"
                                @change="fetchData">
                            </el-date-picker>
                        </div>
                    </div>
                    <div class="col">
                        <label for=""><small>Filter Status</small></label>
                         <el-checkbox-group @change="fetchData" v-model="filter.status">
                            <el-checkbox label="1">Dibuka</el-checkbox>
                            <el-checkbox label="0">Ditutup</el-checkbox>
                        </el-checkbox-group>
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
                    <el-table-column prop="gs_nama" label="Sensor Pintu">
                        <template slot-scope="scope">
                            {{ scope.row.sensor_pintu.gs_nama }} <br>
                            <small><i>{{ scope.row.sensor_pintu.gs_kode_sensor }}</i></small>
                        </template>
                    </el-table-column>
                    <el-table-column prop="Status" label="Status">
                        <template slot-scope="scope"> 
                            <el-tag v-if="scope.row.status == 1" :type="'success'" effect="dark">
                                Aktif
                            </el-tag>
                            <el-tag v-else :type="'secondary'" effect="dark">
                                Tidak Aktif
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="created_at" label="Tanggal">
                        <template slot-scope="scope">
                            {{ scope.row.created_at | formatDateTime }}
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
                date: [],
                status: [],
                search:'',
            },
            pura_list: [],
            data_sensor_pintu: {
                pura_id: "",
                gs_nama: "",
                gs_sensor_pintu: 0,
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
                    relations: "sensor_pintu",
                    status: this.filter.status,
                    date: this.filter.date,
                    paginate:true,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.sensor-pintu-log.history"), properties).then((response) => {
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

        indexMethod(index) {
            return (this.meta.current_page - 1) * this.meta.per_page + index + 1;
        },

        fetchSensorPintu() {
            axios
                .get(
                    route("api.sensor-pintu.show", {
                        sensor_pintu: this.$route.params.sensor_pintu,
                    })
                )
                .then((response) => {
                    let sensor_pintu = response.data.data;
                    this.data_sensor_pintu = { ...this.data_sensor_pintu, ...sensor_pintu };
                });
        },
    },

    async created() {
        await this.fetchSensorPintu();
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
</style>