<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">List User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah User
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>Tambah User</span>
            </div>
            <div class="card-body">
                <el-form
                    :model="data_user"
                    :rules="rules"
                    ref="userForm"
                    size="small"
                    label-position="top"
                    v-loading="loading"
                >
                    <el-form-item label="Nama" prop="name">
                        <el-input
                            v-model="data_user.name"
                            placeholder="Cth: Yoga Permana"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Email" prop="email">
                        <el-input
                            type="email"
                            v-model="data_user.email"
                            placeholder="Cth: permana0912@gmail.com"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Role" prop="role">
                        <el-select
                            v-model="data_user.role"
                            placeholder="Pilih role user.."
                        >
                            <el-option
                                v-for="item in list_roles"
                                :key="item.id"
                                :label="item.name"
                                :value="item.name"
                            ></el-option>
                        </el-select>
                    </el-form-item>

                    <el-checkbox
                        v-if="$route.params.user"
                        v-model="data_user.change_password"
                        >Ganti password ?
                    </el-checkbox>

                    <el-form-item
                        v-if="show_password"
                        label="Password"
                        prop="password"
                    >
                        <el-input
                            type="password"
                            v-model="data_user.password"
                            placeholder="Masukkan password"
                        ></el-input>
                    </el-form-item>

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
                            {{ $route.params.user ? 'Simpan User' : 'Tambah User' }}
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
            data_user: {
                name: "",
                email: "",
                role: "",
                password: "",
                change_password: false,
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
        };
    },
    methods: {
        onSubmit() {
            this.$refs["userForm"].validate((valid) => {
                let fields = this.$refs["userForm"].fields;
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
                                this.$router.push({ name: "users.index" });
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
                    route("api.user.show", {
                        user: this.$route.params.user,
                    })
                )
                .then((response) => {
                    let user = response.data.data;
                    user.role = user.roles[0].name;
                    delete user.roles;
                    delete user.created_at;
                    delete user.updated_at;
                    delete user.email_verified_at;
                    this.data_user = { ...this.data_user, ...user };
                });
        },

        getRoute() {
            if (typeof this.$route.params.user != "undefined") {
                return axios.put(route('api.user.update' , {
                    user: this.$route.params.user
                }) , this.data_user);
            }
            return axios.post(route('api.user.store') , this.data_user);
        },
    },

    watch: {
        "data_user.change_password": function (value) {
            this.show_password = value ? true : false;
        },
    },

    mounted() {
        this.fetchRoles();
        if (typeof this.$route.params.user == "undefined") {
            this.show_password = true;
        } else {
            this.fetchData();
        }
    },
};
</script>