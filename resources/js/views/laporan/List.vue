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
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <select name="" id="" class="form-control" v-model="selectedFilter.periode">
                                        <option :value="null">Pilih Periode</option>
                                        <option v-for="list in listPeriode" :key="list.id" :value="list.id">{{
                                            list.nama_periode }}-{{ list.periode }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Skema</label>
                                    <select name="" id="" class="form-control" v-model="selectedFilter.skema">
                                        <option :value="null">Pilih Periode</option>
                                        <option v-for="skema in listSkema" :key="skema.id" :value="skema.id"> {{
                                            skema.kode_program }} : {{ skema.nama_skema }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Status Usulan</label>
                                    <select name="" id="" class="form-control" v-model="selectedFilter.usulan">
                                        <option :value="null">Pilih Status Usulan</option>
                                        <option v-for="stusulan in statusUsulan" :key="stusulan" :value="stusulan"> {{
                                            stusulan }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Status Akhir</label>
                                    <select name="" id="" class="form-control" v-model="selectedFilter.akhir">
                                        <option :value="null">Pilih Status Akhir</option>
                                        <option v-for="stakhir in statusAkhir" :key="stakhir" :value="stakhir">{{ stakhir }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Tangal Pengajuan</label>
                                    <flat-pickr v-model="selectedFilter.datepengajuan" :config="datePickerConfig"
                                        class="form-control"></flat-pickr>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-block" @click="applyFilter">Filter</button>
                                <button class="btn btn-secondary btn-block" @click="resetFilter">Clear Filter</button>
                                <button class="btn btn-warning btn-block" @click="printTable">Print Data</button>
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
                                        <th>Status Usulan</th>
                                        <th>Status Akhir</th>
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
                                        <td>
                                            <label class="badge bg-warning" v-if="list.status_pemenang == 'In Review'">In
                                                Review</label>
                                            <label class="badge bg-danger"
                                                v-if="list.status_pemenang == 'Tolak'">Tolak</label>
                                            <label class="badge bg-success"
                                                v-if="list.status_pemenang == 'Pemenang'">Terima/Pemenang</label>

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
            statusUsulan: ['Tolak', 'Terima'],
            statusAkhir: ['In Review', 'Tolak', 'Pemenang'],
            listSkema: {},
            listPeriode: {},
            filteredItems: [],
            selectedFilter: {
                periode: null,
                skema: null,
                datepengajuan: null,
                usulan: null,
                akhir: null
            },
        }
    },
    mounted() {
        this.getDataUser()
        this.getSkema()
        this.getPeriode()

    },
    methods: {
        resetFilter() {
            this.selectedFilter = {
                periode: null,
                skema: null,
                datepengajuan: null,
                usulan: null,
                akhir: null
            };
            this.applyFilter(); // Reapply filter after resetting
        },
        applyFilter() {
            const { periode, skema, datepengajuan, usulan, akhir } = this.selectedFilter;

            if (!(periode || skema || datepengajuan || usulan || akhir)) {
                this.filteredItems = this.dataTable;
                return;
            }

            const filters = [];

            if (periode != null) {
                filters.push(item => item.id_periode === periode);
            }
            if (skema != null) {
                filters.push(item => item.id_skema === skema);
            }
            if (datepengajuan != null) {
                filters.push(item => item.tanggal_pengajuan === datepengajuan);
            }
            if (usulan != null) {
                filters.push(item => item.status_pengajuan === usulan);
            }
            if (akhir != null) {
                filters.push(item => item.status_pemenang === akhir);
            }

            this.filteredItems = this.dataTable.filter(item =>
                filters.every(filterFunction => filterFunction(item))
            );
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
                console.log(response.data)
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
        },
        printTable() {
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            printWindow.document.open();

            // Retrieve the table HTML content from the DOM
            const tableContent = document.querySelector('.table-responsive').outerHTML;

            // Create a basic HTML structure in the print window
            printWindow.document.write(`
        <html>
          <head>
            <title>Print Table</title>
            <style>
              /* Define styles for the table (optional) */
              /* Include any styles for the table you want to print */
              .table {
                border-collapse: collapse;
                width: 100%;
              }
              .table, th, td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
              }
            </style>
          </head>
          <body>
            ${tableContent}
          </body>
        </html>
      `);

            // Close the HTML structure and document
            printWindow.document.close();

            // Focus and print the window
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    }
}
</script>