<template>
    <el-dialog
        title="Tambah Permission"
        :visible.sync="dialogVisible"
        width="30%"
        :close-on-click-modal="false"
    >
        <el-form
            :model="permission"
            ref="permissionForm"
            label-position="top"
            v-loading="loading"
        >
            <el-form-item
                label="Permission"
                prop="name"
                :rules="{
                    required: true,
                    message: 'tidak boleh kosong!',
                    trigger: ['blur'],
                }"
            >
                <el-input
                    v-model="permission.name"
                    placeholder="Cth: user.create-user"
                ></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">Batal</el-button>
            <el-button type="primary" @click="onSubmit">Simpan Permission</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: {
        show: false,
    },
    data() {
        return {
            dialogVisible: false,
            permission: {
                name: "",
            },
            loading: false,
        };
    },

    watch: {
        show: function (value) {
            this.dialogVisible = value;
            this.permission.name = '';
        },
        dialogVisible: function (value) {
            this.$emit("update:show", value);
        },
    },

    methods: {
        onSubmit() {
            this.loading = true;
            axios
                .post(route("api.role.permission.store"), this.permission)
                .then((response) => {
                    this.loading = false;
                    this.$notify({
                        title: "Pemberitahuan",
                        message: response.data.message,
                        type: "success",
                    });
                    this.dialogVisible = false;

                    this.$emit('handleSubmitPermission' , response.data.data);
                })
                .catch(() => {
                    this.loading = false;
                });
        },
    },
};
</script>