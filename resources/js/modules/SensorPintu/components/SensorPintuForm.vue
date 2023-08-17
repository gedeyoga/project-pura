<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                {{ $route.params.sensor_pintu ? 'Edit Sensor Pintu' : 'Tambah Sensor Pintu' }}
            </h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">List Sensor Pintu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $route.params.sensor_pintu ? 'Edit Sensor Pintu' : 'Tambah Sensor Pintu' }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>
                    {{ $route.params.sensor_pintu ? 'Edit Sensor Pintu' : 'Tambah Sensor Pintu' }}
                </span>
            </div>
            <div class="card-body">
                <el-form
                    :model="data_sensor_pintu"
                    :rules="rules"
                    ref="sensor_pintuForm"
                    label-position="top"
                    v-loading="loading"
                >
                    <el-form-item label="Data Pura" prop="pura_id" v-if="hasAccess('sensor_pintu.sensor_pintu-all')">
                        <el-select v-model="data_sensor_pintu.pura_id" placeholder="Pilih pura" filterable clearable>
                            <el-option
                            v-for="(item, index) in pura_list"
                            :key="index"
                            :label="item.pura_nama"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Nama Sensor" prop="gs_nama">
                        <el-input
                            v-model="data_sensor_pintu.gs_nama"
                            placeholder="Cth: Sensor A"
                        ></el-input>
                    </el-form-item>
                    <!-- <el-form-item label="Token" prop="token">
                        <el-input
                            v-model="data_sensor_pintu.token"
                            placeholder="Masukkan token.."
                        ></el-input>
                    </el-form-item> -->
                    <div class="row">
                        <div class="col-md-6">
                             <el-form-item label="Sensor Pintu" prop="gs_sensor_pintu">
                                <el-switch
                                    v-model="data_sensor_pintu.gs_sensor_pintu"
                                    active-text="Aktif"
                                    active-value="1"
                                    inactive-value="0"
                                    inactive-text="Tidak Aktif">
                                </el-switch>
                            </el-form-item>
                        </div>
                        <!-- <div class="col-md-6">
                             <el-form-item label="Guard State" prop="guard_state">
                                <el-switch
                                    v-model="data_sensor_pintu.guard_state"
                                    active-text="Aktif"
                                    active-value="1"
                                    inactive-value="0"
                                    inactive-text="Tidak Aktif">
                                </el-switch>
                            </el-form-item>
                        </div> -->
                    </div>
                    <el-form-item>
                        <div class="text-center mt-3">
                            <el-button
                                v-loading="loading"
                                @click.prevent="$router.back()"
                                >Kembali</el-button
                            >
                            <el-button
                                v-loading="loading"
                                type="primary"
                                @click="onSubmit()"
                            >
                            {{ $route.params.sensor_pintu ? 'Simpan Sensor Pintu' : 'Tambah Sensor Pintu' }}
                            </el-button
                            >
                        </div>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data_sensor_pintu: {
                pura_id: "",
                gs_nama: "",
                token: "",
                gs_sensor_pintu: 0,
                guard_state: 0,
            },
            loading: false,
            rules: {
                pura_id: [{ required: true, message: "Tidak boleh kosong!" }],
                gs_nama: [{ required: true, message: "Tidak boleh kosong!" }],
                token: [{ required: true, message: "Tidak boleh kosong!" }],
                gs_sensor_pintu: [{ required: true, message: "Tidak boleh kosong!" }],
                guard_state: [{ required: true, message: "Tidak boleh kosong!" }],
            },

            pura_list: [],
        };
    },
    methods: {
        onSubmit() {
            this.$refs["sensor_pintuForm"].validate((valid) => {
                let fields = this.$refs["sensor_pintuForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.$confirm("Apakah anda yakin ?", "Konfirmasi", {
                        confirmButtonText: "Simpan",
                        cancelButtonText: "Batal",
                        type: "warning",
                    }).then((result) => {
                        this.loading = true;

                        this.getRoute()
                            .then((response) => {
                                this.loading = false;
                                this.$notify({
                                    title: "Pemberitahuan",
                                    message: response.data.message,
                                    type: "success",
                                });
                                this.$router.push({ name: "sensor-pintu.index" });
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    });
                }
            });
        },
        fetchPura() {
            axios
                .get(route("api.pura.index"))
                .then((response) => {
                    this.pura_list = response.data.data;
                });
        },

        fetchData() {
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

        getRoute() {
            if (typeof this.$route.params.sensor_pintu != "undefined") {
                return axios.put(route('api.sensor-pintu.update' , {
                    sensor_pintu: this.$route.params.sensor_pintu
                }) , this.data_sensor_pintu);
            }
            return axios.post(route('api.sensor-pintu.store') , this.data_sensor_pintu);
        },
    },

    watch: {
        "data_sensor_pintu.change_password": function (value) {
            this.show_password = value ? true : false;
        },
    },

    mounted() {
        if(this.hasAccess('sensor_pintu.sensor_pintu-all')) {
            this.fetchPura();
        }else {
            if(this.user.pura.length > 0) {
                this.data_sensor_pintu.pura_id = this.user.pura[0].id;
            }
        }
        if (typeof this.$route.params.sensor_pintu == "undefined") {
            // this.show_password = true;
        } else {
            this.fetchData();
        }
    },
};
</script>