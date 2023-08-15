<template>
    <div>
       <div class="row">
            <div class="col">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body" v-loading="loading">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                   Nama Pura</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ user.pura[0].pura_nama }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-gopuram fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body" v-loading="loading">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ user_count }}</div>
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
                                    Total Sensor Pintu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ sensor_pintu_count }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-video fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sensor CCTV</h6>
                    </div>
                    <div class="card-body">
                        <el-table
                            :data="sensor_cctv_list"
                            stripe
                            style="width: 100%"
                            ref="pageTable"
                            v-loading.body="loading"
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
                            <el-table-column prop="created_at" label="Tanggal">
                                <template slot-scope="scope">
                                    {{ scope.row.created_at | formatDateTime }}
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                    <div class="card-footer text-center">
                        <el-button @click="$router.push({name: 'sensor-cctv.index'})" size="small" plain type="primary">Lihat Selengkapnya</el-button>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sensor Pintu</h6>
                    </div>
                    <div class="card-body">
                        <el-table
                            :data="sensor_pintu_list"
                            stripe
                            style="width: 100%"
                            ref="pageTable"
                            v-loading.body="loading"
                        >
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
                            <el-table-column prop="Status" label="Status">
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
                        </el-table>
                    </div>
                     <div class="card-footer text-center">
                        <el-button @click="$router.push({name: 'sensor-pintu.index'})" size="small" plain type="primary">Lihat Selengkapnya</el-button>
                    </div>
                </div>
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
            loading: false,
            sensor_cctv_list: [],
            sensor_pintu_list: [],
        };
    },

    methods:{
        fetchDataDashboard() {
            this.loading = true;
            axios.get(route('api.dashboard.user'))
            .then((response) => {
                this.loading = false;
                this.user_count = response.data.user_count
                this.sensor_pintu_count = response.data.sensor_pintu_count
                this.sensor_pintu_list = response.data.sensor_pintu_list
                this.sensor_cctv_list = response.data.sensor_cctv_list
            })
            .catch(() => {
                this.loading = false;
            });
        },

        onUpdateStatus(row){
            this.loading = true;
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
    },

    mounted() {
        this.fetchDataDashboard();
    }
}
</script>