export default {
    methods: {
        logoutConfirmation() {
            this.$swal({
                title: "Keluar dari Akun",
                text: "Apakah anda yakin ingin keluar ?",
                type: "warning",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Ya, Keluar",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.value) {
                    this.logout();
                }
            });
        },  
        logout() {
            axios
                .post(
                    route("logout"),
                    {},
                    {
                        headers: {
                            Accept: "application/json", //the token is a variable which holds the token
                        },
                    }
                )
                .then((response) => {
                    this.$swal(
                        "Terima Kasih!",
                        "Anda sedang diarahkan ke halaman login",
                        "success"
                    );
                    window.location.href = response.data.redirect;
                });
        },
    },
};
