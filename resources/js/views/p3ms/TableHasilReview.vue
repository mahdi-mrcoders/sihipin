<template>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="">Filtering By Periode</label>
                <select name="" id="" class="form-control" v-model="selectedFilter" @change="filteredData">
                    <option :value="''">Pilih Periode</option>
                    <option v-for="list in listPeriode" :key="list.id" :value="list.id">{{
                        list.nama_periode }}-{{ list.periode }}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="">Filtering By Skema</label>
                <select name="" id="" class="form-control" v-model="filterSkema" @change="filteredSkema">
                    <option :value="''">Pilih Periode</option>
                    <option v-for="skema in listSkema" :key="skema.id" :value="skema.id"> {{
                        skema.kode_program }} : {{ skema.nama_skema }}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="d-block">Filtering By Rata Nilai</label>
                <button class="btn btn-secondary" @click="sortByRataNilai">Sort By Rata Nilai</button>
            </div>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Usulan</th>
                    <th>Periode</th>
                    <th style="width:20%">Skema judul Usulan</th>
                    <th>Peneliti & anggota</th>
                    <th>Team Reviewer</th>
                    <th>Hasil Reviewer</th>
                    <th>Rata Nilai</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="filterTable.length > 0">
                <tr v-for="(list, index) in filterTable" :key="list.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ list.kode_skema }}-{{ list.id }}</td>
                    <td>{{ list.periode }}</td>
                    <td>{{ list.nama_skema }}<br>{{ list.informasi.judul_penelitian }}</td>
                    <td>Ketua : {{ list.ketua_peneliti }}<br>Jumlah Anggota : {{ list.anggota.length }}</td>
                    <td>
                        <li v-for="(rev, key) in list.reviewer" :key="rev.id" style="list-style-type:none">REV {{ key + 1 }}
                            :
                            {{ rev.nama_reviewer }}</li>
                    </td>
                    <td>
                        <li v-for="(rev, key) in list.reviewer" :key="rev.id" style="list-style-type:none">
                            <span class="d-block">REV {{ key + 1 }} : </span><span>{{ getHasilREview(rev, list.datanilai,
                                key) }}</span>
                        </li>
                    </td>
                    <td>
                        <li style="list-style-type:none">
                            {{ list.ratanilai }}
                        </li>
                    </td>
                    <td>
                        <li style="list-style-type:none">Status usulan : <br>
                            <label class="badge bg-info" v-if="list.status_pengajuan == 'Prosess'">Proses</label>
                            <label class="badge bg-warning" v-if="list.status_pengajuan == 'In Review'">In Review</label>
                            <label class="badge bg-danger" v-if="list.status_pengajuan == 'Tolak'">Tolak </label>
                            <label class="badge bg-success" v-if="list.status_pengajuan == 'Terima'">Terima</label>
                            <i class="fa-solid fa-circle-info fa-lg" v-if="list.status_pengajuan == 'Tolak'"
                                style="cursor:pointer" @click="showInfo(list.alasan_tolak)"></i>
                        </li>
                        <li style="list-style-type:none">Status Review : <br>
                            <label class="badge bg-warning" v-if="list.status_pemenang == 'In Review'">In Review</label>
                            <label class="badge bg-danger" v-if="list.status_pemenang == 'Tolak'">Tolak</label>
                            <label class="badge bg-success" v-if="list.status_pemenang == 'Pemenang'">Selesai</label>
                        </li>
                        <li style="list-style-type:none">
                            No Kontrak :<br> <label for="" v-if="list.kontrak">{{ list.kontrak.no_kontrak }}</label>
                            <label for="" v-else>-</label>
                        </li>
                        <li style="list-style-type:none">
                            <span v-if="list.kontrak">
                                Sign Pihak 1 : {{ list.kontrak.pihak_satu }}<br>
                                Sign Pihak 2 : {{ list.kontrak.pihak_dua }}<br>
                                Sign Mengetahui : {{ list.kontrak.mengetahui }}
                            </span>
                            <span v-else>
                                Sign Pihak 1 : -<br>
                                Sign Pihak 2 : -<br>
                                Sign Mengetahui : -
                            </span>
                        </li>

                    </td>
                    <td>
                        <!-- <label class="badge bg-info" @click="validasiHasil(list)">Validasi Usulan</label>
                        <hr> -->
                        <label class="badge bg-info" @click="validasiPemenang(list)">Validasi Akhir</label>
                        <hr>
                        <label class="badge bg-info" @click="createKontrak(list)">Kontrak Usulan</label>
                    </td>
                </tr>

            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="10">
                        <div class="alert alert-info text-center" role="alert">
                            Belum Ada Data
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedFilter: '',
            filterSkema: '',
            listPeriode: {},
            listSkema: {},
            dataTable: [],
            filterTable: [],
            level: localStorage.getItem("level"),
            uuid: localStorage.getItem('uuid'),
            idsn: null,
            dataPengajuan: {},
            dataKontrak: {},
            sortByRataNilaiFlag:false
        }
    },
    mounted() {
        this.getDataUser()
        this.getPeriode()
        this.getSkema()

    },
    methods: {
        filterAndSortData() {
            if (this.selectedFilter !== '' && this.filterSkema !== '') {
                this.filterTable = this.dataTable.filter(item => {
                    return item.id_periode === this.selectedFilter && item.id_skema === this.filterSkema;
                });
            } else if (this.selectedFilter !== '') {
                this.filterTable = this.dataTable.filter(item => {
                    return item.id_periode === this.selectedFilter;
                });
            } else if (this.filterSkema !== '') {
                this.filterTable = this.dataTable.filter(item => {
                    return item.id_skema === this.filterSkema;
                });
            } else {
                this.filterTable = this.dataTable;
            }

            // Sort by rata nilai if needed
            if (this.sortByRataNilaiFlag) {
                this.filterTable.sort((a, b) => {
                    return b.ratanilai - a.ratanilai;
                });
            }
        },
        sortByRataNilai() {
            this.sortByRataNilaiFlag = true;
            this.filterAndSortData();
        },
        filteredData() {
            this.filterAndSortData();
        },
        filteredSkema() {
            this.filterAndSortData();
        },
        async getPeriode() {
            await this.axios.get('/api/dataperiode').then(response => {
                this.listPeriode = response.data
                response.data.forEach(item => {
                    if (item.status_periode == 'Y') {
                        this.selectedFilter = item.status_periode == 'Y' ? item.id : ''
                    }
                });
            }).catch(error => {

            })
        },
        async getSkema() {
            await this.axios.get('/api/dataskema').then(response => {
                this.listSkema = response.data
            }).catch(error => {

            })
        },
        async getDataUser() {
            await this.axios.get(`/api/pengguna/${this.uuid}`).then(response => {
                this.getDataDosen(response.data.email_dosen)
            }).catch(error => {
                console.log(error)
            })

        },
        async getDataDosen(email) {
            await this.axios.get(`/api/dosen/byemail/${email}`).then(responses => {
                this.idsn = responses.data.id
                this.getListSubmited()
            }).catch(error => {
                console.log(error)
            })
        },
        async getListSubmited() {
            await this.axios.get(`/api/penelitian?level=${this.level}&idsn=${this.idsn}`).then(response => {
                this.dataTable = response.data
                this.filteredData()
            }).catch(error => {
                console.log(error)
            })

        },
        getHasilREview(review, data, index) {

            const nilai = data.find(item => item.id_dosen_reviewer === review.id_dosen)
            if (nilai !== undefined) {
                const hasil = nilai.hasil_review == 1 ? 'Terima' : nilai.hasil_review == 2 ? 'Terima Revisi' : 'Tolak'
                return nilai.total_nilai + ' : ' + hasil
            } else {
                return 'N/A'
            }
        },
        totalNilai(data) {
            if (data && data.length > 0 && data[0].total_nilai !== undefined) {

                const sum = data.reduce((accumulator, currentValue) => accumulator + currentValue.total_nilai, 0);
                return sum / 2
            }
            return 'N/A';
        },
        async validasiHasil(data) {
            const detailData = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
            </ul>
            `;
            const inputOptions = new Promise((resolve) => {
                setTimeout(() => {
                    resolve({
                        "Tolak": "Tolak",
                        "Terima": "Terima"
                    });
                }, 100);
            });

            if (data.datanilai.length == 0) {
                this.$swal({
                    title: "Informasi",
                    text: "Hasil Review Kosong, Tidak Dapat Menvalidasi Usulan",
                    icon: "error"
                });
            } else {
                const { value: status } = await this.$swal({
                    title: "Pilih Status Validasi Usulan",
                    html: detailData,
                    input: "radio",
                    inputOptions,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return "Anda perlu memilih sesuatu!";
                        }
                    }
                });
                if (status) {
                    this.dataPengajuan.id = data.id
                    this.dataPengajuan.status = status
                    await this.axios.post('/api/updatevalidasi', this.dataPengajuan).then(response => {
                        this.getDataUser()
                    }).catch(error => {
                        console.log(error)
                    })

                }
            }

        },
        async validasiPemenang(data) {
            const detailData = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
            </ul>
            `;
            const inputOptions = new Promise((resolve) => {
                setTimeout(() => {
                    resolve({
                        "Tolak": "Gagal",
                        "Pemenang": "Pemenang"
                    });
                }, 100);
            });

            if (data.datanilai.length == 0) {
                this.$swal({
                    title: "Informasi",
                    text: "Hasil Review Kosong, Tidak Dapat Menvalidasi Usulan",
                    icon: "error"
                });
            } else {
                const { value: status } = await this.$swal({
                    title: "Pilih Status Validasi Pemenang",
                    html: detailData,
                    input: "radio",
                    inputOptions,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return "Anda perlu memilih sesuatu!";
                        }
                    }
                });
                if (status) {
                    this.dataPengajuan.id = data.id
                    this.dataPengajuan.status = status
                    await this.axios.post('/api/updatevalidasipemenang', this.dataPengajuan).then(response => {
                        // console.log(response.data)
                        this.getDataUser()
                    }).catch(error => {
                        console.log(error)
                    })

                }
            }

        },
        async createKontrak(data) {
            const detailData = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
            </ul>
            `;
            if (data.datanilai.length == 0) {
                this.$swal({
                    title: "Informasi",
                    text: "Hasil Review Kosong, Tidak Dapat Membuat No Kontrak",
                    icon: "error"
                });
            } else {
                const { value: values } = await this.$swal({
                    title: "Buat Kontrak Usulan Penelitian",
                    input: "text",
                    html: detailData,
                    inputLabel: "Nomor Kontrak",
                    inputValue: data.kontrak == null ? '' : data.kontrak.no_kontrak,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return "You need to write something!";
                        }
                    }
                });
                if (values) {
                    this.dataKontrak.id = data.id
                    this.dataKontrak.level = this.level
                    this.dataKontrak.no_kontrak = values
                    await this.axios.post('/api/createkontrak', this.dataKontrak).then(response => {
                        this.getDataUser()
                        console.log(response.data)
                    }).catch(error => {
                        console.log(error)
                    })
                }
            }

        },
        showInfo(info) {
            this.$swal({
                title: "<strong>Alasan Penolakan</strong>",
                icon: "info",
                html: info,
                showConfirmButton: false,
                showCloseButton: false,
                showCancelButton: true,
                cancelButtonText: `Tutup`,
            });
        }

    }
}
</script>
<style scoped>
tr>th,
td {
    font-size: 14px;
}

i.files:hover {
    cursor: pointer;
}


@media (min-width: 992px) {
    .modal-lg {
        max-width: 60%;
    }
}
</style>
<style>
.custom-swal-html {
    font-size: 12px;

}

div:where(.swal2-container) .swal2-html-containers {
    z-index: 1;
    justify-content: center;
    margin: 1em 1.6em 0.3em;
    padding: 0;
    overflow: auto;
    color: inherit;
    font-size: 13px;
    font-weight: normal;
    line-height: normal;
    text-align: justify;
    word-wrap: break-word;
    word-break: break-word;
}
</style>