<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-6 mb-4 mb-xl-0">
                <div class="d-lg-flex align-items-center">
                    <div>
                        <h3 class="text-dark font-weight-bold mb-2">{{ this.$route.name }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <select name="" id="" class="form-control" v-model="selectedFilter.periode">
                                        <option :value="''">Pilih Periode</option>
                                        <option v-for="list in listPeriode" :key="list.id" :value="list.id">{{
                                            list.nama_periode }}-{{ list.periode }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Skema</label>
                                    <select name="" id="" class="form-control" v-model="selectedFilter.skema">
                                        <option :value="''">Pilih Periode</option>
                                        <option v-for="skema in listSkema" :key="skema.id" :value="skema.id"> {{
                                            skema.kode_program }} : {{ skema.nama_skema }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Tangal Pengajuan</label>
                                    <flat-pickr v-model="selectedFilter.datepengajuan" :config="datePickerConfig"
                                        class="form-control"></flat-pickr>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-block" @click="applyFilter">Filter</button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode & Program</th>
                                        <th>Nama Skema</th>
                                        <th>Dosen Pengaju</th>
                                        <th>Judul</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status Pengaju</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, index) in filteredItems" :key="list.id">
                                        <td>{{ index + 1 }}</td>
                                        <td> {{ list.periode }} - {{ list.kode_skema }} </td>
                                        <td>{{ list.nama_skema }}</td>
                                        <td>{{ list.ketua_peneliti }}</td>
                                        <td>{{ list.informasi.judul_penelitian }}</td>
                                        <td>{{ list.tanggal_pengajuan }}</td>
                                        <td>
                                            <label class="badge bg-info"
                                                v-if="list.status_pengajuan == 'Prosess'">Proses</label>
                                            <label class="badge bg-warning" v-if="list.status_pengajuan == 'In Review'">In
                                                Review</label>
                                            <label class="badge bg-danger"
                                                v-if="list.status_pengajuan == 'Tolak'">Tolak</label>
                                            <label class="badge bg-success"
                                                v-if="list.status_pengajuan == 'Terima'">Terima</label>

                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Flatpickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
export default {
    components: { 'flat-pickr': Flatpickr },
    data() {
        return {
            dataTable: [],
            level: localStorage.getItem("level"),
            uuid: localStorage.getItem('uuid'),
            idsn: null,
            datatPenelitian: null,
            searchTerm: '',
            datePickerConfig: {
                enableTime: false, // Aktifkan waktu
                dateFormat: 'Y-m-d', // Format tampilan tanggal dan waktu
            },
            dateSelect: '',
            listSkema: {},
            listPeriode: {},
            filteredItems: [],
            selectedFilter: {
                periode:null,
                skema:null,
                datepengajuan:null
            },
        }
    },
    // computed: {
    //     filteredItems() {
    //         const searchTerm = this.searchTerm.toLowerCase();
    //         return this.dataTable.filter(item => {
    //             return item.kode_skema.toLowerCase().includes(searchTerm) ||
    //                 item.periode.toLowerCase().includes(searchTerm) ||
    //                 item.tanggal_pengajuan.toLowerCase().includes(searchTerm)
    //         });
    //     }
    // },
    mounted() {
        this.getDataUser()
        this.getSkema()
        this.getPeriode()
        
    },
    methods: {
        applyFilter() {
            const searchTerm = this.selectedFilter;
            if(searchTerm.periode || searchTerm.skema || searchTerm.datepengajuan){
                    this.filteredItems = this.dataTable.filter(item => {
                        if(searchTerm.periode != null && searchTerm.skema == null && searchTerm.datepengajuan == null){
                            return item.id_periode === this.selectedFilter.periode 
                        }else if(searchTerm.periode != null && searchTerm.skema != null && searchTerm.datepengajuan == null){
                            return item.id_periode === this.selectedFilter.periode && item.id_skema == this.selectedFilter.skema;
                        }else if(searchTerm.periode != null && searchTerm.skema != null && searchTerm.datepengajuan != null){
                            return item.id_periode === this.selectedFilter.periode && item.id_skema == this.selectedFilter.skema && item.tanggal_pengajuan == searchTerm.datepengajuan;
                        }
                        
                });
            }else{
                this.filteredItems = this.dataTable
            }
           
        },
        ResultState(result) {
            this.isClicked = false
            this.tableList = {}
            this.$router.go(0);

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
                this.applyFilter()
            }).catch(error => {
                console.log(error)
            })

        },
        async getSkema() {
            await this.axios.get('/api/dataskema').then(response => {
                this.listSkema = response.data
            }).catch(error => {

            })
        },
        async getPeriode() {
            await this.axios.get('/api/dataperiode').then(response => {
                this.listPeriode = response.data
            }).catch(error => {

            })
        }
    }
}
</script>