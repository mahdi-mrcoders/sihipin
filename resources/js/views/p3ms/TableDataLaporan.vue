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
                <label for="">Searching By Name/Judul Usulan</label>
                <input type="text" v-model="query" @input="search" placeholder="Search..." class="form-control">
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
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="dataTable.length > 0">
                <template v-for="(list, index) in filterTable" :key="list.id">
                    <tr v-if="list.status_pengajuan === 'Terima' && list.status_pemenang === 'Pemenang'">
                        <td>{{ index + 1 }}</td>
                        <td>{{ list.kode_skema }}-{{ list.id }}</td>
                        <td>{{ list.periode }}</td>
                        <td>{{ list.nama_skema }}<br>{{ list.informasi.judul_penelitian }}</td>
                        <td>Ketua : {{ list.ketua_peneliti }}<br>Jumlah Anggota : {{ list.anggota.length }}</td>
                        <td>
                            <li style="list-style-type:none">Status usulan : <br>
                                <label class="badge bg-info" v-if="list.status_pengajuan == 'Prosess'">Proses</label>
                                <label class="badge bg-warning" v-if="list.status_pengajuan == 'In Review'">In
                                    Review</label>
                                <label class="badge bg-danger" v-if="list.status_pengajuan == 'Tolak'">Tolak</label>
                                <label class="badge bg-success" v-if="list.status_pengajuan == 'Terima'">Terima</label>
                            </li>
                            <li style="list-style-type:none">Status Pemenang : <br>
                                <label class="badge bg-warning" v-if="list.status_pemenang == 'In Review'">In
                                    Review</label>
                                <label class="badge bg-danger" v-if="list.status_pemenang == 'Tolak'">Tolak</label>
                                <label class="badge bg-success"
                                    v-if="list.status_pemenang == 'Pemenang'">Pemenang</label>
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
                            <label class="badge bg-info" @click="showDetail(list.id)"
                                :class="{ opened: opened.includes(list.id) }">Lihat Laporan</label>
                        </td>
                    </tr>
                    <tr
                        v-if="opened.includes(list.id) && list.status_pengajuan === 'Terima' && list.status_pemenang === 'Pemenang'">
                        <td colspan="7">
                            <table class="table" style="width:100%">
                                <thead class="table-secondary">
                                    <tr>
                                        <td>No</td>
                                        <td>Progress</td>
                                        <td>File</td>
                                        <td>Uploded</td>
                                        <td>Alasan Tolak</td>
                                        <td>Status</td>
                                        <td>Action</td>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="(progres, ind) in list.progress" :key="progres.id">
                                        <td>{{ ind + 1 }}</td>
                                        <td>{{ progres.jenis_laporan }}</td>
                                        <td><i class="fa-solid fa-download" style="cursor:pointer;"
                                                @click="fetchFile(progres.file_progress)"
                                                v-show="progres.file_progress != null"></i> {{
                    progres.file_progress }}</td>
                                        <td><span v-show="progres.file_progress != null">{{ progres.updated_at }}</span>
                                        </td>
                                        <td>
                                            {{ progres.alasan_tolak }}
                                        </td>
                                        <td>
                                            <label class="badge bg-danger" v-if="progres.validasi == 'No Upload'">No
                                                Upload</label>
                                            <label class="badge bg-info"
                                                v-if="progres.validasi == 'prosess'">Proses</label>
                                            <label class="badge bg-danger"
                                                v-if="progres.validasi == 'Tolak'">Tolak</label>
                                            <label class="badge bg-success"
                                                v-if="progres.validasi == 'Terima'">Terima</label>
                                        </td>

                                        <td>
                                            <label for="" class="badge bg-warning"
                                                v-show="progres.file_progress == null ? false : true"
                                                @click="validasiLaporan(progres.id, list, progres)">Validasi</label>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </td>
                    </tr>
                </template>


            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7">
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
            query: '',
            selectedFilter: '',
            filterSkema: '',
            listPeriode: {},
            listSkema: {},
            opened: [],
            dataTable: {},
            filterTable: [],
            level: localStorage.getItem("level"),
            uuid: localStorage.getItem('uuid'),
            idsn: null,
            dataPengajuan: {},
            dataKontrak: {}
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


        },
        search() {
            this.filterTable = this.dataTable.filter(item => {
                return item.ketua_peneliti.toLowerCase().includes(this.query.toLowerCase()) ||
                    item.informasi.judul_penelitian.toLowerCase().includes(this.query.toLowerCase());
            });
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
                // response.data.forEach(item => {
                //     if (item.status_pengajuan == 'Terima' && item.status_pemenang == 'Pemenang') {
                //         this.dataTable = [item]
                //     }
                // });
            }).catch(error => {
                console.log(error)
            })

        },
        getHasilREview(review, data, index) {
            if (data && data.length > 0 && data[index].total_nilai !== undefined) {
                const nilai = data.find(item => item.id_dosen_reviewer === review.id_dosen)
                const hasil = data[index].hasil_review == 1 ? 'Terima' : data[index].hasil_review == 2 ? 'Terima Revisi' : 'Tolak'
                return nilai.total_nilai + ' : ' + hasil

            }
            return 'N/A';
        },
        totalNilai(data) {
            if (data && data.length > 0 && data[0].total_nilai !== undefined) {

                const sum = data.reduce((accumulator, currentValue) => accumulator + currentValue.total_nilai, 0);
                return sum
            }
            return 'N/A';
        },
        showDetail(id) {
            const index = this.opened.indexOf(id);
            if (index > -1) {
                this.opened.splice(index, 1)
            } else {
                this.opened.push(id)
            }
        },
        async validasiLaporan(id, data, laporan) {
            if (laporan.validasi == 'No Upload') {
                this.$swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Action Tidak Dapat Dilakukan, Peserta Belum Uploda File",
                });
            } else {
                const detailData = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
                <li class="list-group-item"><strong>Laporan :</strong> <br><label class="text-muted lh-sm">${laporan.jenis_laporan}</label></li>
            </ul>
            `;
                const inputOptions = {
                    "Terima": "Terima",
                    "Tolak": "Tolak",
                }
                const defaultValue = "Terima";
                const { value: validasi } = await this.$swal({
                    title: "Pilih Validasi",
                    html: detailData,
                    input: "radio",
                    inputOptions,
                    inputValue: laporan.validasi == 'Prosess' ? '' : laporan.validasi == 'Terima' ? 'Terima' : "Tolak",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return "You need to choose something!";
                        }
                    }
                });
                if (validasi == 'Terima') {
                    const dataProgress = {
                        validasi: validasi,
                        alasan: null,
                        _method: "patch"
                    }
                    await this.axios.post(`/api/validasiprogress/${id}`, dataProgress).then(response => {
                        this.getDataUser()
                    }).catch(error => {
                        console.log(error)
                    })
                } else {
                    const { value: text } = await this.$swal({
                        input: "textarea",
                        inputLabel: "Alasan Penolakan",
                        inputPlaceholder: "Type your message here...",
                        inputAttributes: {
                            "aria-label": "Type your message here"
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Kirim'
                    });
                    if (text) {
                        const dataProgress = {
                            validasi: validasi,
                            alasan: text,
                            _method: "patch"
                        }
                        await this.axios.post(`/api/validasiprogress/${id}`, dataProgress).then(response => {
                            this.getDataUser()
                        }).catch(error => {
                            console.log(error)
                        })
                    }

                }
            }

        },
        async fetchFile(filename) {
            try {
                window.location.href = `/api/file/${filename}`
                // $('#previewFile').modal('show');
            } catch (error) {
                console.error('Error fetching docx:', error);
            }
        },

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