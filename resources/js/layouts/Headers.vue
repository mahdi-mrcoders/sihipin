<template>
    <nav class="navbar top-navbar col-lg-12 col-12 p-0" style="background-color:#FF9130">
        <div class="container-fluid">
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                <div class="navbar-nav navbar-nav-left">
                    <a class="navbar-brand brand-logo d-flex justify-content-start" :href="'/dashboard'">
                        <img src="/assets/images/logop3m.png" alt="" class="d-block d-lg-none" style="width:15% !important;background-color:#FF9130">
                        <img src="/assets/images/logop3m.png" alt="" class="d-none d-lg-block" style="width:5% !important;background-color:#FF9130">
                        <span class="ms-2 fs-4 fw-bolder text-dark d-none d-lg-block align-self-center">SIPMA (Sistem Informasi Pengabdian Masyarakat)</span>
                        <span class="ms-2 fs-4 fw-bolder text-dark d-block d-lg-none align-self-center">SIPMA</span>
                    </a>
                </div>
                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <span class="nav-profile-name"> <small>{{ user.username }}
                                    <label class="badge bg-info" v-if="user.level == 1">P3M</label>
                                    <label class="badge bg-info" v-if="user.level == 2">Reviewer</label>
                                    <label class="badge bg-info" v-if="user.level == 3">Peneliti</label>
                                    <label class="badge bg-info" v-if="user.level == 4">Direktur</label>
                                </small></span>
                            <span class="online-status"></span>
                            <img :src="foto == '/storage/null' ? '/assets/images/logop3m.png' : foto" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#" @click="myprofile">
                                <i class="mdi mdi-settings text-primary"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#" @click="logout">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    data() {
        return {
            user: {},
            loggedIn: localStorage.getItem('loggedIn'),
            uuid: localStorage.getItem('uuid'),
            foto: null,
            sessionTimeout: 7200, // Waktu dalam detik sebelum sesi timeout
            logoutTimer: null
        }
    },
    created() {
        this.getDataUser()
        this.setupLogoutTimer();
        // Tambahkan event listener untuk menangani aktivitas pengguna
        document.addEventListener("mousemove", this.resetLogoutTimer);
        document.addEventListener("keypress", this.resetLogoutTimer);

    },
    methods: {
        // Mengatur timer untuk logout
        setupLogoutTimer() {
            this.logoutTimer = setTimeout(() => {
                console.log('logout')
                this.logout();
            }, this.sessionTimeout * 1000); // Ubah ke milidetik
        },
        // Mengatur ulang timer untuk logout
        resetLogoutTimer() {
            clearTimeout(this.logoutTimer);
            this.setupLogoutTimer();
        },
        logout() {
            localStorage.removeItem("loggedIn")
            localStorage.removeItem("uuid")
            localStorage.removeItem("level")
            localStorage.clear();
            this.$router.push({ name: 'login' })
        },
        async getDataUser() {
            if (this.uuid != null) {
                await this.axios.get(`/api/pengguna/${this.uuid}`).then(response => {
                    this.user.level = response.data.level
                    this.user.username = response.data.username
                    this.user.email = response.data.email_dosen
                    this.getFoto(response.data.email_dosen)
                }).catch(error => {
                    // console.log(error)
                })
            }

        },
        myprofile() {
            return this.$router.push({ path: '/my-profile' })
        },
        async getFoto(email) {
            const response = await this.axios.get(`/api/dosen/byemail/${email}`)
            this.foto = `/storage/${response.data.foto}`
        }
    },
    mounted() {
        if (!this.loggedIn) {
            this.$router.push({ name: 'login' })
        }
    },
    beforeDestroy() {
        // Membersihkan event listener saat komponen dihancurkan
        document.removeEventListener("mousemove", this.resetLogoutTimer);
        document.removeEventListener("keypress", this.resetLogoutTimer);
    }
}
</script>