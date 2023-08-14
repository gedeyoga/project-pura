<template>
    <el-dialog
        :title="jenis_pura_form.id ? 'Edit Jenis Pura' : 'Tambah Jenis Pura'"
        :visible.sync="show"
        width="40%"
        :close-on-click-modal="false">
        <el-form 
            :model="jenis_pura_form" 
            :rules="rules" 
            ref="jenisPuraForm" 
            label-position="top"
            label-width="120px" 
            v-loading.body="loading"
            class="demo-ruleForm">
            <el-form-item label="Jenis Pura" prop="jp_nama">
                <el-input v-model="jenis_pura_form.jp_nama" placeholder="Cth: Pura Kahyangan"></el-input>
            </el-form-item>
            <el-form-item label="Status" prop="jp_active">
                <el-switch
                    v-model="jenis_pura_form.jp_active"
                    active-text="Aktif"
                    active-value="y"
                    inactive-value="n">
                </el-switch>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button :loading="loading" @click="closeDialog">Batal</el-button>
            <el-button :loading="loading" type="primary" @click="onSubmit">Simpan</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    data() {
        return {
            show: false,
            loading: false,
            jenis_pura_form: {
                jp_nama: '',
                jp_active: 'y',
            },
            rules: {
                jp_nama:[
                    {
                        required:true,
                        message: 'Tidak boleh kosong!',
                    },
                ],
                jp_active: [
                    {
                        required:true,
                        message: 'Tidak boleh kosong!',
                    },
                ]
            }
        }
    },

    methods: {
        openDialog( data ) {
            this.show = true;
            this.$emit('onOpen');

            if(data) {
                this.jenis_pura_form = {
                    ...this.jenis_pura_form,
                    ...data
                };
            } else {
                this.jenis_pura_form = {
                    jp_nama: '',
                    jp_active: 'n'
                };
            }
        },

        closeDialog() {
            this.show = false;
            this.$emit('onClose');
        },

        onSubmit() {
            this.$refs['jenisPuraForm'].validate((valid) => {
                let fields = this.$refs["jenisPuraForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if(valid) {
                     this.$confirm("Apakah anda yakin ?", "Konfirmasi", {
                        confirmButtonText: "Simpan",
                        cancelButtonText: "Batal",
                        type: "warning",
                    }).then((result) => {
                        this.loading = true;

                        if(this.jenis_pura_form.id) {
                            this.updateJenisPura();
                        }else {
                            this.storeJenisPura();
                        }
                    });
                }
            })
        },

        storeJenisPura() {
            axios
                .post(route('api.jenis-pura.store') , this.jenis_pura_form)
                .then((response) => {
                    this.loading = false;
                    if(response.status == 200) {
                        
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });

                        this.closeDialog();
                    }
                })
                .catch(() => {
                    this.loading = false;
                });
        },

        updateJenisPura() {
            axios
                .put(route('api.jenis-pura.update' , {
                    jenis_pura: this.jenis_pura_form.id
                }) , this.jenis_pura_form)
                .then((response) => {
                    this.loading = false;
                    if(response.status == 200) {
                        
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });

                        this.closeDialog();
                    }
                })
                .catch(() => {
                    this.loading = false;
                });
        }
    },

    mounted() {

    }
}
</script>