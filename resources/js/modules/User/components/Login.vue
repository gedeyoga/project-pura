<template>
    <div>
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row align-items-center">
                                <div class="col-lg-6 d-none d-lg-block position-relative">
                                    <img class="w-100" src="/image/login-image.jpg" alt="">
                                    <div class="position-absolute d-flex"  style="top: 25px; left: 35px">
                                        <div>
                                            <img style="border-radius: 8px;" :src="$url + '/image/logo.jpg'" width="30px" height="30px" alt="">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-light" style="font-size: 12px;"><strong>PERLINDUNGAN <br> PRATIMA</strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex flex-column align-items-center justify-content-center pt-5">
                                        <div class="mb-3">
                                            <img :src="$url + '/image/logo.jpg'" class="rounded-circle" width="70px" height="70px" alt="">
                                        </div>
                                        <div class="mx-3 text-gray-900 text-center"><strong>PERLINDUNGAN <br> PRATIMA</strong></div>
                                    </div>
                                    <div class="px-5 mt-2 pb-4">
                                        <div>
                                            <h1 class="h4 text-gray-900 mb-4">
                                                Login
                                            </h1>
                                        </div>
                                        <el-form
                                            v-loading="loading"
                                            :model="auth"
                                            :rules="rules"
                                            ref="auth"
                                            label-width="120px"
                                            class="demo-ruleForm"
                                            label-position="top"
                                            size="small"
                                        >
                                            <el-form-item
                                                label="Email"
                                                prop="email"
                                            >
                                                <el-input
                                                    v-model="auth.email"
                                                    placeholder="Masukkan email.."
                                                ></el-input>
                                            </el-form-item>
                                            <el-form-item
                                                label="Password"
                                                prop="password"
                                            >
                                                <el-input
                                                    v-model="auth.password"
                                                    placeholder="Masukkan password.."
                                                    type="password"
                                                ></el-input>
                                            </el-form-item>
                                            <el-button
                                                size="small"
                                                type="primary"
                                                class="btn-block mt-3"
                                                @click="onSubmit"
                                                v-loading="loading"
                                                native-type="button"
                                                >Masuk</el-button
                                            >
                                        </el-form>

                                        <div class="row mt-3">
                                            <div class="col-lg-6 mb-2 lg:mb-0">
                                                <el-button size="small" plain style="width: 100%;" icon="el-icon-wallet" @click="handleClick('https://drive.google.com/file/d/1YwM9pWYVgLKVkb0XL2eRUuvQRmDuJJsL/view')"><span class="ml-2">Pengadaan Biaya</span></el-button>
                                            </div>
                                            <div class="col-lg-6">
                                                <el-button size="small" plain style="width: 100%;" icon="fa fa-wrench" @click="handleClick('https://drive.google.com/file/d/1YwM9pWYVgLKVkb0XL2eRUuvQRmDuJJsL/view')"><span class="ml-2">Panduan Teknis</span></el-button>
                                            </div>
                                        </div>

                                        <!-- <form class="user">
                                            <div class="form-group">
                                                <input
                                                    type="email"
                                                    class="form-control form-control-user"
                                                    id="exampleInputEmail"
                                                    aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address..."
                                                />
                                            </div>
                                            <div class="form-group">
                                                <input
                                                    type="password"
                                                    class="form-control form-control-user"
                                                    id="exampleInputPassword"
                                                    placeholder="Password"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <div
                                                    class="custom-control custom-checkbox small"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="customCheck"
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="customCheck"
                                                        >Remember Me</label
                                                    >
                                                </div>
                                            </div>
                                            <a
                                                href="index.html"
                                                class="btn btn-primary btn-user btn-block"
                                            >
                                                Login
                                            </a>
                                            <hr />
                                            <a
                                                href="index.html"
                                                class="btn btn-google btn-user btn-block"
                                            >
                                                <i
                                                    class="fab fa-google fa-fw"
                                                ></i>
                                                Login with Google
                                            </a>
                                            <a
                                                href="index.html"
                                                class="btn btn-facebook btn-user btn-block"
                                            >
                                                <i
                                                    class="fab fa-facebook-f fa-fw"
                                                ></i>
                                                Login with Facebook
                                            </a>
                                        </form> -->
                                        <!-- <hr /> -->
                                        <!-- <div class="text-center">
                                            <a
                                                class="small"
                                                href="forgot-password.html"
                                                >Forgot Password?</a
                                            >
                                        </div>
                                        <div class="text-center">
                                            <a
                                                class="small"
                                                href="register.html"
                                                >Create an Account!</a
                                            >
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
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
            auth: {
                email: "",
                password: "",
            },
            rules: {
                email: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Email harus diisi!",
                    },
                    {
                        type: "email",
                        trigger: ["blur"],
                        message: "Harap masukkan alamat email yang benar!",
                    },
                ],
                password: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Pasword harus diisi!",
                    },
                ],
            },
            loading: false,
        };
    },
    methods: {
        onSubmit() {
            this.$refs["auth"].validate((valid) => {
                let fields = this.$refs["auth"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.loading = true;
                    axios
                        .post(route("login"), this.auth)
                        .then((response) => {

                            localStorage.setItem('token' , response.data.data.token);
                            
                            this.$message({
                                message: response.data.message,
                                type: "success",
                            });
                           window.location = route('home')

                            this.loading = false;
                        })
                        .catch((response) => {
                            console.log(response.message)
                            this.$message.error(
                                "Terjadi kesalahan saat masuk akun."
                            );
                            this.loading = false;
                        });
                }
            });
        },

        handleClick(link) {
            window.open(link);
        }
    },
};
</script>

<style>
.el-form-item__label {
    padding-bottom: 0 !important;
}
</style>