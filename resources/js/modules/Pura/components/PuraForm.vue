<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pura</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">List Pura</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Pura
                    </li>
                </ol>
            </nav>
        </div>

        <el-form
            :model="data_pura"
            :rules="rules"
            ref="puraForm"
            label-position="top"
            v-loading="loading"
        >
            <div class="card">
                <div
                    class="card-header d-flex justify-content-between align-items-center"
                >
                    <span>Data Pura</span>
                </div>
                <div class="card-body">
                    <el-form-item label="Nama Pura" prop="pura_nama">
                        <el-input
                            v-model="data_pura.pura_nama"
                            placeholder="Cth: Pura Besakih"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="IP Address" prop="pura_ip">
                        <el-input
                            v-model="data_pura.pura_ip"
                            placeholder="Cth: 192.168.1.1"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Jenis Pura" prop="jp_id">
                        <el-select v-model="data_pura.jp_id" placeholder="Select">
                            <el-option
                            v-for="(item, index) in jenis_pura_list"
                            :key="index"
                            :label="item.jp_nama"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="Foto Pura" prop="foto_puras">        
                        <el-upload
                            action="#"
                            list-type="picture-card"
                            :auto-upload="false"
                            :on-change="handleChange"
                            :file-list="foto_list"
                            accept="image/png,image/jpg,image/jpeg"
                            :on-remove="handleRemove">
                            <i class="el-icon-plus"></i>
                        </el-upload>
                    </el-form-item>
                </div>
            </div>

            <div class="card mt-3">
                <div
                    class="card-header d-flex justify-content-between align-items-center"
                >
                    <span>Lokasi Pura</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <el-form-item label="Provinsi" prop="province_id">
                                <el-select v-model="data_pura.province_id" filterable @change="fetchKabupaten" placeholder="Pilih Provinsi">
                                    <el-option
                                    v-for="(item, index) in provinsi"
                                    :key="index"
                                    :label="item.name"
                                    :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div class="col-md-3">
                            <el-form-item label="Kabupaten" prop="district_id">
                                <el-select v-model="data_pura.regency_id" filterable @change="fetchKecamatan" placeholder="Pilih Kelurahan">
                                    <el-option
                                        v-for="(item, index) in kabupaten"
                                        :key="index"
                                        :label="item.name"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div class="col-md-3">
                            <el-form-item label="Kecamatan" prop="regencies_id">
                                <el-select v-model="data_pura.district_id" filterable @change="fetchKelurahan" placeholder="Pilih Kecamatan">
                                    <el-option
                                    v-for="(item, index) in kecamatan"
                                    :key="index"
                                    :label="item.name"
                                    :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div class="col-md-3">
                            <el-form-item label="Kelurahan" prop="kel_id" :rules="{required: true, message: 'Tidak boleh kosong'}">
                                <el-select v-model="data_pura.kel_id" filterable placeholder="Pilih Kelurahan">
                                    <el-option
                                        v-for="(item, index) in kelurahan"
                                        :key="index"
                                        :label="item.name"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                    </div>
                    <el-form-item label="Cari Lokasi">
                        <el-input id="searchBox" v-model="searchAddress" class="mb-3" type="text" ref="searchMap" placeholder="Cari alamat.."></el-input>
                        <gmap-map
                            ref="mapRef"
                            :center="center"
                            :zoom="zoom"
                            map-type-id="roadmap"
                            style="width: 100%; height: 300px"
                            >
                            <gmap-marker
                                :key="index"
                                v-for="(m, index) in markers"
                                :position="m"
                                :title="'Geser Marker'"
                                :clickable="true"
                                :draggable="true"
                                @click="center=m"
                                @dragend="handleDragendMarker"
                            />
                        </gmap-map>
                    </el-form-item>
                    <el-form-item label="Alamat" prop="pura_alamat">
                        <el-input
                            :readonly="true"
                            type="textarea"
                            col="3"
                            v-model="data_pura.pura_alamat"
                            placeholder="Cth: Desa Besakih"
                        ></el-input>
                    </el-form-item>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="text-center">
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
                        {{ $route.params.pura ? 'Simpan Pura' : 'Tambah Pura' }}
                        </el-button
                        >
                    </div>
                </div>
            </div>
        </el-form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            map:null,
            center: {lat: 0, lng: 0},
            zoom: 4, 
            data_pura: {
                pura_nama: "",
                jp_id: "",
                kel_id: "",
                pura_alamat: "",
                pura_ip: "",
                pura_lat: null,
                pura_lng: null,
                province_id: null,
                regency_id: null,
                district_id: null,
            },
            markers: [],
            provinsi: [],
            kecamatan: [],
            kabupaten: [],
            kelurahan: [],
            jenis_pura_list: [],
            searchAddress: null,
            loading: false,
            rules: {
                pura_nama: [{ required: true, message: "Tidak boleh kosong!" }],
                pura_alamat: [{ required: true, message: "Tidak boleh kosong!" }],
                pura_ip: [{ required: true, message: "Tidak boleh kosong!" }],
                kel_id: [{ required: true, message: "Tidak boleh kosong!" }],
                jp_id: [{ required: true, message: "Tidak boleh kosong!" }],
            },

            list_roles: [],
            map: null,
            foto_list: [],
        };
    },
    methods: {
        onSubmit() {
            this.$refs["puraForm"].validate((valid) => {
                let fields = this.$refs["puraForm"].fields;
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
                                this.$router.push({ name: "puras.index" });
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    });
                }
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

        fetchData() {
            axios
                .get(
                    route("api.pura.show", {
                        pura: this.$route.params.pura,
                    })
                )
                .then( async (response) => {
                    let pura = response.data.data;
                    this.data_pura = { ...this.data_pura, ...pura };

                    this.foto_list = this.data_pura.foto_pura.map((item) => {
                        return {
                            name: 'foto',
                            url: item.fp_url,
                        };
                    });

                    await this.fetchKabupaten(this.data_pura.province_id);
                    await this.fetchKecamatan(this.data_pura.regency_id);
                    await this.fetchKelurahan(this.data_pura.district_id);

                    this.setCenter({
                        lat: this.data_pura.pura_lat,
                        lng: this.data_pura.pura_lng,
                    })

                    this.pushMarker(this.center)
                });
        },

        getRoute() {

            let formData = new FormData();

            for (const key in this.data_pura) {
                formData.append(key , this.data_pura[key]);
            }

            let foto_puras = [];
            this.foto_list.forEach((item) => {
                if(item.hasOwnProperty('raw')) {
                    foto_puras.push(item.raw);
                }else {
                    foto_puras.push(item.url);
                }
            });

            foto_puras.forEach((item , index) => {
                formData.append('foto_puras['+index+'][file]' , item);
            });

            if (typeof this.$route.params.pura != "undefined") {
                formData.append('_method', 'put');

                return axios.post(route('api.pura.update' , {
                    pura: this.$route.params.pura
                }) , formData);
            }
            return axios.post(route('api.pura.store') , formData);
        },

        fetchProvinsi() {
            axios
                .get(route('api.wilayah.provinces'))
                .then((response) => {
                    this.provinsi = response.data;
                })
        },

        fetchKabupaten(province_id) {
            console.log(province_id);
            axios
                .get(route('api.wilayah.regencies') , {
                    params: {
                        province_id: province_id
                    }
                })
                .then((response) => {
                    this.kabupaten = response.data;
                })
        },
        
        fetchKecamatan(regency_id) {
            axios
                .get(route('api.wilayah.districts') , {
                    params: {
                        regency_id: regency_id
                    }
                })
                .then((response) => {
                    this.kecamatan = response.data;
                })
        },

        fetchKelurahan(district_id) {
            axios
                .get(route('api.wilayah.villages') , {
                    params: {
                        district_id: district_id
                    }
                })
                .then((response) => {
                    this.kelurahan = response.data;
                })
        },

        fetchJenisPura() {
            axios
                .get(route('api.jenis-pura.index'))
                .then((response) => {
                    this.jenis_pura_list = response.data.data;
                })
        },

        handleChange(file , fileList) {
            this.foto_list = fileList;
        },

        handleRemove(file, fileList) {
            this.foto_list = fileList;
        },

        pushMarker(location) {
            this.markers.splice(0, 1);
            this.markers.push(location);
        },

        handleDragendMarker(marker) {
            this.setCenter({
                lat: marker.latLng.lat(),
                lng: marker.latLng.lng(),
            })

            this.getGeocoder(marker.latLng);
        },

        getGeocoder(latLng){
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: latLng })
                .then((response) => {
                    if (response.results[0]) {
                        this.data_pura.pura_alamat = response.results[0].formatted_address;
                        this.searchAddress = response.results[0].formatted_address;
                    } 
                })
                .catch((e) => window.alert("Geocoder failed due to: " + e));
        },

        setCenter(location) {
            this.center = location;
            this.map.setZoom(15);
        },

        initSearchAddress() {
            let searchBox = document.getElementById('searchBox')
            let autocomplete = new google.maps.places.SearchBox(searchBox);

            autocomplete.addListener("places_changed", (res) => {
                const place = autocomplete.getPlaces();
                this.setCenter({
                    lat: place[0].geometry.location.lat(),
                    lng: place[0].geometry.location.lng(),
                })

                this.getGeocoder(place[0].geometry.location);

                this.pushMarker(this.center)
                
            })
        }
    },

    watch: {
        "data_pura.change_password": function (value) {
            this.show_password = value ? true : false;
        },
        'center': function(value) {
            this.data_pura.pura_lat = value.lat;
            this.data_pura.pura_lng = value.lng;
        }
    },

    created() {
        this.fetchProvinsi();
        this.fetchJenisPura();
    },

    mounted() {
        
        this.fetchRoles();
        if (typeof this.$route.params.pura == "undefined") {
            this.show_password = true;
        } else {
            this.fetchData();
        }

        this.$refs['mapRef'].$mapPromise.then((map) => {
            this.map = map;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    this.setCenter({lat: lat, lng: lng});
                    this.pushMarker(this.center)
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }

            this.initSearchAddress();
        });
    },
};
</script>