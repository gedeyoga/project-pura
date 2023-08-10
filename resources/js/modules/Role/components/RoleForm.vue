<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Role</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">List Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Role
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>Tambah Role</span>
            </div>
            <div class="card-body">
                <el-form
                    :model="data_role"
                    :rules="rules"
                    ref="roleForm"
                    label-position="top"
                    v-loading="loading"
                >
                    <el-tabs type="card">
                        <el-tab-pane label="Role">
                            <el-form-item label="Nama" prop="name">
                                <el-input
                                    v-model="data_role.name"
                                    placeholder="Cth: Yoga Permana"
                                ></el-input>
                            </el-form-item>
                        </el-tab-pane>
                        <el-tab-pane label="Permissions">
                            <div class="row">
                                <div class="col-6 offset-6">
                                    <div class="float-right">
                                        <el-button
                                            size="small"
                                            type="success"
                                            :icon="'fas fa-plus'"
                                            @click="showDialogPermission = true"
                                            >Tambah Permission</el-button
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    v-for="(item, key) in list_permissions"
                                    :key="key"
                                    class="col-md-6"
                                >
                                    <label for="">Module : {{ key }}</label>
                                    <el-table :data="item" style="width: 100%">
                                        <el-table-column
                                            prop="name"
                                            label="Name"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="akses"
                                            label="Akses"
                                        >
                                            <template slot-scope="scope">
                                                <el-switch
                                                    v-model="
                                                        data_role.permissions[
                                                            key
                                                        ][scope.$index].allow
                                                    "
                                                    active-text="Allow"
                                                    inactive-text="Disabled"
                                                >
                                                </el-switch>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                </div>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
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
                                {{
                                    $route.params.role
                                        ? "Simpan Role"
                                        : "Tambah Role"
                                }}
                            </el-button>
                        </div>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <dialog-permission
            :show.sync="showDialogPermission"
            @handleSubmitPermission="permissionAdded"
        ></dialog-permission>
    </div>
</template>

<script>
import DialogPermission from "./DialogPermission.vue";
export default {
    components: {
        DialogPermission,
    },
    data() {
        return {
            data_role: {
                name: "",
                permissions: {},
            },
            show_password: false,
            loading: false,
            rules: {
                name: [{ required: true, message: "Nama tidak boleh kosong!" }],
                email: [
                    { required: true, message: "Email tidak boleh kosong" },
                    {
                        type: "email",
                        message: "Harap masukkan alamat email dengan benar",
                    },
                ],
                role: [{ required: true, message: "Role tidak boleh kosong!" }],
                password: [
                    { required: true, message: "Password tidak boleh kosong!" },
                ],
            },

            list_roles: [],
            showDialogPermission: false,
            permissions: {},
        };
    },
    computed: {
        list_permissions: function () {
            return this.permissions;
        },
    },
    methods: {
        onSubmit() {
            this.$refs["roleForm"].validate((valid) => {
                let fields = this.$refs["roleForm"].fields;
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
                                this.$router.push({ name: "roles.index" });
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    });
                }
            });
        },

        fetchData() {
            axios
                .get(
                    route("api.role.show", {
                        role: this.$route.params.role,
                    })
                )
                .then((response) => {
                    this.data_role.name = response.data.data.name;
                    let permissions = response.data.data.permissions;

                    // console.log(permissions);

                    for (const module in permissions) {
                        if (this.data_role.permissions[module]) {
                            permissions[module].forEach(
                                (permiission, key) => {

                                    let index_allowed = this.data_role.permissions[module].findIndex((role_permission) => role_permission.name == permiission.name);

                                    this.data_role.permissions[module][index_allowed].allow = permiission.allow;

                                }
                            );

                        }
                    }
                });
        },

        getRoute() {
            if (typeof this.$route.params.role != "undefined") {
                return axios.put(
                    route("api.role.update", {
                        role: this.$route.params.role,
                    }),
                    this.data_role
                );
            }
            return axios.post(route("api.role.store"), this.data_role);
        },

        permissionAdded(data) {
            if (data) {
                if (
                    this.data_role.permissions[data.module] &&
                    this.permissions[data.module]
                ) {
                    this.data_role.permissions[data.module].push(data);
                    this.permissions[data.module].push(data);
                } else {
                    this.data_role.permissions[data.module] = [data];
                    this.permissions[data.module] = [data];
                }
            }
        },

        async fetchPermission() {
            const data = await axios.get(route("api.role.permission.list"));

            return data;
        },
    },

    watch: {
        "data_role.change_password": function (value) {
            this.show_password = value ? true : false;
        },
    },

    async mounted() {
        let response = await this.fetchPermission();
        this.permissions = response.data;
        this.data_role.permissions = JSON.parse(JSON.stringify(response.data));

        if (typeof this.$route.params.role != "undefined") {
            this.fetchData();
        }

        if (typeof this.$route.params.role == "undefined") {
            this.show_password = true;
        } else {
            console.log(this.$route.params.role);
            // this.fetchData();
        }
    },
};
</script>