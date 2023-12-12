<template>
    <nav class="bottom-navbar" style="background-color:#FECDA6">
        <div class="container">
            <ul class="nav page-navigation" v-if="level == 1">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <i class="fa-solid fa-house mb-2"></i>
                        <span class="menu-title">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-server mb-2"></i>
                      <span class="menu-title">Master Data</span>
                      <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul>
                            <li class="nav-item">
                                <router-link to="/data-dosen" class="nav-link">
                                    <span class="menu-title"> Dosen</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-skema" class="nav-link">
                                    <span class="menu-title">Skema</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-periode" class="nav-link">
                                    <span class="menu-title">Data Periode</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-jabfung" class="nav-link">
                                    <span class="menu-title">Data Jabfung</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-golpangkat" class="nav-link">
                                    <span class="menu-title">Data Gol/Pangkat</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/buku-panduan" class="nav-link">
                                    <span class="menu-title">Buku Panduan</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <router-link to="/data-pengguna" class="nav-link">
                        <i class="fa-solid fa-users-gear mb-2"></i>
                        <span class="menu-title">Pengguna</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/data-usulan-proposal" class="nav-link">
                        <i class="fa-solid fa-folder-tree mb-2"></i>
                        <span class="menu-title">Data Pengajuan Peneliti</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/laporan" class="nav-link">
                        <i class="fa-solid fa-file-contract mb-2"></i>
                        <span class="menu-title">Laporan</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/informasi" class="nav-link">
                        <i class="fa-solid fa-circle-info mb-2"></i>
                        <span class="menu-title">Inforamtion</span>
                    </router-link>
                </li>
            </ul>
            <ul class="nav page-navigation" v-if="level == 2">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <i class="fa-solid fa-house mb-2"></i>
                        <span class="menu-title">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/review-usulan-proposal" class="nav-link">
                        <i class="mdi mdi-file-document-box menu-icon"></i>
                        <span class="menu-title">Reviewer penelitian</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/informasi" class="nav-link">
                        <i class="fa-solid fa-circle-info mb-2"></i>
                        <span class="menu-title">Inforamtion</span>
                    </router-link>
                </li>
            </ul>
            <ul class="nav page-navigation" v-if="level == 3">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <i class="fa-solid fa-house mb-2"></i>
                        <span class="menu-title">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/skema/submited" class="nav-link">
                        <i class="fa-solid fa-folder-tree mb-2"></i>
                        <span class="menu-title">Submited</span>
                    </router-link>
                </li>
                
                <li class="nav-item">
                    <router-link to="/buku-panduan" class="nav-link">
                        <i class="fa-solid fa-book-open-reader mb-2"></i>
                        <span class="menu-title">Buku Panduan</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/informasi" class="nav-link">
                        <i class="fa-solid fa-circle-info mb-2"></i>
                        <span class="menu-title">Inforamtion</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
export default {
    data() {
        return {
            uuid: localStorage.getItem("uuid"),
            level: localStorage.getItem("level")
        }
    },
    created() {
        // this.getDataUser()
        // console.log(this.level)
    },
    methods: {
        // async getDataUser() {
        //     await this.axios.get(`/api/pengguna/${this.uuid}`).then(response => {
        //         // localStorage.setItem("level", response.data.level);
        //     }).catch(error => {
        //         console.log(error)
        //     })
        // }
    }
}
</script>