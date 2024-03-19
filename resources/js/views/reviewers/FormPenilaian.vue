<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body ">
                        <div class="row p-2 border border-info bg-info">
                            <div class="col-sm-6">
                                <h4 class="card-title">Identitas Program</h4>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Skema Usulan</label>
                                    <label for="" class="col-sm-9 font-monospace">{{ pengajuan.nama_skema }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Kode Usulan</label>
                                    <label for="" class="col-sm-9 font-monospace">{{ pengajuan.kode_skema }}-{{ pengajuan.id
                                    }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Judul</label>
                                    <label for="" class="col-sm-9 font-monospace">{{ pengajuan.informasi.judul_penelitian
                                    }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Ketua Tim Pengusul</label>
                                    <label for="" class="col-sm-9 font-monospace">{{ pengajuan.ketua_peneliti }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Jumlah Anggota</label>
                                    <label for="" class="col-sm-9 font-monospace">{{ pengajuan.anggota.length }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Dana Yang Diusulkan</label>
                                    <label for="" class="col-sm-9 font-monospace">{{ formatIdr }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-3 fw-bolder">Dana yang di Setujui</label>
                                    <label for="" class="col-sm-9 font-monospace">-</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="card-title">Identitas Reviewer</h4>
                                <div class="row m-2">
                                    <label for="" class="col-sm-4 fw-bolder">Nama Lengkap</label>
                                    <label for="" class="col-sm-8 font-monospace">{{ userReviewer.nama }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-4 fw-bolder">NRP/NIDN/NUPN</label>
                                    <label for="" class="col-sm-8 font-monospace">{{ userReviewer.nrp }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-4 fw-bolder">Program Studi</label>
                                    <label for="" class="col-sm-8 font-monospace">{{ userReviewer.prodi }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-4 fw-bolder">Jabtan Fungsional</label>
                                    <label for="" class="col-sm-8 font-monospace">{{ userReviewer.jabatan_fungsional
                                    }}</label>
                                </div>
                                <div class="row m-2">
                                    <label for="" class="col-sm-4 fw-bolder">pangkat/Golongan</label>
                                    <label for="" class="col-sm-8 font-monospace">{{ userReviewer.pangkat_golongan
                                    }}</label>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">Kriteria Penilaian</h4>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>N0</th>
                                            <th>Nama Kriteria</th>
                                            <th>Indikator Penilaian</th>
                                            <th>Bobot</th>
                                            <th>Skor</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(kriteria, kriteriaIndex) in data" :key="kriteriaIndex">
                                            <tr v-if="kriteria.indikator.length == 1">
                                                <td>{{ kriteriaIndex + 1 }}</td>
                                                <td>{{ kriteria.nama_kriteria }}</td>
                                                <td>{{ kriteria.indikator[0].indikator_penilaian }}</td>
                                                <td>{{ kriteria.indikator[0].bobot }}</td>
                                                <td>
                                                    <input type="hidden" class="form-control"
                                                        v-model="indikatorId[kriteriaIndex][0]">
                                                    <input type="text" class="form-control" min="0" max="5"
                                                        :value="skorsNilai[kriteriaIndex, 0]"
                                                        @input="limitInputToFiveDigits($event, 0, kriteriaIndex)"
                                                        @keyup="hitungNilai($event, kriteriaIndex, 0, kriteria.indikator[0].bobot)">
                                                </td>
                                                <td><input type="number" class="form-control" :readonly="true"
                                                        :value="hasilNilai[kriteriaIndex][0]"></td>
                                            </tr>
                                            <tr v-if="kriteria.indikator.length > 1">
                                                <td
                                                    :rowspan="kriteria.indikator.length == 1 ? '' : kriteria.indikator.length + 1">
                                                    {{
                                                        kriteriaIndex + 1 }}</td>
                                                <td
                                                    :rowspan="kriteria.indikator.length == 1 ? '' : kriteria.indikator.length + 1">
                                                    {{
                                                        kriteria.nama_kriteria }}</td>

                                            </tr>
                                            <template v-for="(indikator, indikatorIndex) in kriteria.indikator"
                                                :key="indikatorIndex">
                                                <tr v-show="kriteria.indikator.length > 1 ? true : false">
                                                    <td>{{ indikator.indikator_penilaian }} </td>
                                                    <td>{{ indikator.bobot }}</td>
                                                    <td>
                                                        <input type="hidden" class="form-control"
                                                            v-model="indikatorId[kriteriaIndex][indikatorIndex]">
                                                        <input type="text" class="form-control"
                                                            :value="skorsNilai[kriteriaIndex][indikatorIndex]"
                                                            @input="limitInputToFiveDigits($event, kriteriaIndex, indikatorIndex)"
                                                            @keyup="hitungNilai($event, kriteriaIndex, indikatorIndex, indikator.bobot)">
                                                    </td>
                                                    <td><input type="number" class="form-control" :readonly="true"
                                                            :value="hasilNilai[kriteriaIndex][indikatorIndex]"></td>
                                                </tr>
                                            </template>
                                            <tr
                                                v-if="kriteriaIndex === data.length - 1 || data[kriteriaIndex + 1].indikator.length === 0">
                                                <td colspan="3"></td>
                                            </tr>

                                        </template>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Jumlah</td>
                                            <td colspan="3">Nilai Akhir : {{ total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Hasil Penerimaan</td>
                                            <td colspan="3">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                                            id="optionsRadios1" value="1" v-model="selectHasil">
                                                        Terima
                                                        <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                                            id="optionsRadios1" value="2" v-model="selectHasil">
                                                        Terima + Revisi
                                                        <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                                            id="optionsRadios1" value="3" v-model="selectHasil">
                                                        Tolak
                                                        <i class="input-helper"></i></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="6">
                                                <label for="">Catatan Reviwer:</label>
                                                <textarea name="" id="" rows="5" class="form-control border border-dark"
                                                    v-model="catatanReviewer"></textarea>
                                            </td>
                                        </tr> -->
                                    </tfoot>
                                </table>
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Keterangan</h4>
                                    <ol>
                                        <li>Setiap kriteria diberi skor : 0,1, 2, 3, 4, 5 (0= nilai kosong, 1 = Buruk, 2=
                                            Kurang, 3= Cukup, 4 = Baik, 5 = Sangat Baik)</li>
                                        <li>Batas penerimaan (passing grade) = Total nilai 500</li>
                                        <li>Hasil penilaian : diterima/diterima dengan revisi/ditolak* </li>
                                        <li>Jika Di tolak Silahkan ceklis pilihan alasan tolak</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="card-title">Alasan Penolakan</h4>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>N0</th>
                                            <th style="width:25%">Nama Kriteria</th>
                                            <th style="width:25%">Indikator Penilaian</th>
                                            <th>Alasan Penolakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(kriteria, kriteriaIndex) in data" :key="kriteriaIndex">
                                            <tr v-if="kriteria.indikator.length == 1">
                                                <td>{{ kriteriaIndex + 1 }}</td>
                                                <td>{{ kriteria.nama_kriteria }}</td>
                                                <td>{{ kriteria.indikator[0].indikator_penilaian }}</td>
                                                <td>
                                                    <div class="form-check form-check-flat form-check-primary"
                                                        style="font-size:13px">
                                                        <label class="form-check-label" style="font-size:11px">
                                                            <input type="checkbox" class="form-check-input"
                                                                :disabled="stateTolak" :value="kriteria.indikator[0].id"
                                                                v-model="idAlasan">
                                                            {{ kriteria.indikator[0].alasan_tolak }}
                                                            <i class="input-helper"></i></label>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr v-if="kriteria.indikator.length > 1">
                                                <td
                                                    :rowspan="kriteria.indikator.length == 1 ? '' : kriteria.indikator.length + 1">
                                                    {{
                                                        kriteriaIndex + 1 }}</td>
                                                <td
                                                    :rowspan="kriteria.indikator.length == 1 ? '' : kriteria.indikator.length + 1">
                                                    {{
                                                        kriteria.nama_kriteria }}</td>

                                            </tr>
                                            <template v-for="(indikator, indikatorIndex) in kriteria.indikator"
                                                :key="indikatorIndex">
                                                <tr v-show="kriteria.indikator.length > 1 ? true : false">
                                                    <td>{{ indikator.indikator_penilaian }} </td>
                                                    <td>
                                                        <div class="form-check form-check-flat form-check-primary">
                                                            <label class="form-check-label" style="font-size:11px">
                                                                <input type="checkbox" class="form-check-input"
                                                                    :disabled="stateTolak" :value="indikator.id"
                                                                    v-model="idAlasan">
                                                                {{ indikator.alasan_tolak }}
                                                                <i class="input-helper"></i></label>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </template>

                                        </template>
                                    </tbody>

                                </table>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-info btn-lg btn-block" @click="submitPenilaian">Submit

                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body"></div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            userReviewer: {},
            data: [],
            skorsNilai: [],
            hasilNilai: [],
            pengajuan: {
                informasi: {},
                anggota: 0
            },
            indikatorId: [],
            amount: 0,
            stateTolak: true,
            selectHasil: '',
            nilaiAkhir: 0,
            catatanReviewer: '',
            idAlasan: [],
            submitedNilai: {},
            stateSubmit: true
        };
    },
    watch: {
        selectHasil(newVal) {
            this.stateTolak = newVal == 3 ? false : true
        }
    },
    computed: {
        total() {
            return this.hasilNilai.reduce((acc, row) => {
                return acc + row.reduce((accRow, val) => {
                    const value = isNaN(val) ? 0 : val;
                    this.nilaiAkhir = accRow + value;
                    return accRow + value;
                }, 0);
            }, 0);
        },
        formatIdr() {
            return this.amount.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });
        },

    },
    created() {
        this.getUserReviewer()
        this.getDataPengajuan()



    },
    methods: {
        limitInputToFiveDigits(event, indexa, indexb) {
            let inputValue = event.target.value;

            // Menghapus karakter non-numeric
            inputValue = inputValue.replace(/\D/g, '');

            if (inputValue > 5) {
                this.$swal({
                    title: "Out Of Range",
                    text: "Nilai Tidak Boleh Lebih > 5",
                    icon: "error"
                }).then((result) => {
                    this.skorsNilai[indexa][indexb] = 0;
                })
            } else {
                this.skorsNilai[indexa][indexb] = inputValue;
            }

            // Memperbarui nilai di dalam array


        },
        async getUserReviewer() {
            await this.axios.get(`/api/pengguna/${localStorage.getItem('uuid')}`).then(response => {
                this.axios.get(`/api/dosen/byemail/${response.data.email_dosen}`).then((data) => {
                    this.userReviewer = data.data
                    this.getDataPenilaian()
                }).catch(error => {
                    console.log(error)
                })
            }).catch(error => {
                console.log(error)
            })
        },
        async getDataPengajuan() {
            await this.axios.get(`/api/penelitian/${this.$route.params.id}`).then(response => {

                this.pengajuan = response.data
                this.amount = parseInt(response.data.informasi.biaya)
                this.submitedNilai.id_pengajuan = response.data.id
            }).catch(error => {
                console.log(error)
            })
        },
        async getDataPenilaian() {
            await this.axios.get(`/api/datapenilaian?idp=${this.$route.params.id}&idsn=${this.userReviewer.id}`).then(response => {
                this.data = response.data.data
                if (response.data.nilai == null) {
                    this.stateSubmit = true
                } else {
                    this.stateSubmit = false
                    this.submitedNilai.id_penilain_review = response.data.nilai.id_reviewer
                    this.submitedNilai._method = 'patch'
                }
                this.catatanReviewer = response.data.nilai == null ? '' : response.data.nilai.catatan
                this.selectHasil = response.data.nilai == null ? '' : response.data.nilai.hasil_review
                this.idAlasan = response.data.nilai == null ? [] : response.data.nilai.alasan

                response.data.data.forEach((elm, indx) => {
                    this.hasilNilai[indx] = []
                    this.indikatorId[indx] = []
                    this.skorsNilai[indx] = []
                    elm.indikator.forEach((value, key) => {
                        this.indikatorId[indx][key] = value.id
                        this.hasilNilai[indx][key] = value.nilai == null ? 0 : value.nilai
                        this.skorsNilai[indx][key] = value.skor == null ? 0 : value.skor

                    });
                });
            }).catch(error => {
                console.log(error)
            })
        },
        hitungNilai(event, kriteriaIndex, indikatorIndex, bobot) {
            const nilaiInput = parseInt(event.target.value);
            const nilaiBobot = parseInt(bobot);
            if (isNaN(nilaiInput)) {
                this.hasilNilai[kriteriaIndex][indikatorIndex] = [];
                this.skorsNilai[kriteriaIndex][indikatorIndex] = 0

            } else {
                this.skorsNilai[kriteriaIndex][indikatorIndex] = nilaiInput
                this.hasilNilai[kriteriaIndex][indikatorIndex] = nilaiInput * nilaiBobot;
            }
        },
        submitPenilaian() {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Finish!'
            }).then((result) => {
                if (!result.isDismissed) {
                    const NilaiIndikator = [].concat(...this.hasilNilai)
                    const IdIndikator = [].concat(...this.indikatorId)
                    const NilaiSkors = [].concat(...this.skorsNilai)

                    this.submitedNilai.compid = IdIndikator
                    this.submitedNilai.compskors = NilaiSkors
                    this.submitedNilai.compnilai = NilaiIndikator
                    this.submitedNilai.totalnilai = this.total
                    this.submitedNilai.hasil = this.selectHasil
                    this.submitedNilai.catatan = this.catatanReviewer
                    this.submitedNilai.alasan = this.idAlasan
                    this.submitedNilai.id_dosen = this.userReviewer.id
                    console.log(this.submitedNilai)
                    if (this.stateSubmit) {
                        this.axios.post('/api/datapenilaian', this.submitedNilai).then(response => {
                            this.$swal({
                                title: "Success",
                                text: "Penilaian Berhasil Dilakukan Anda Akan dikembalikan Helaman Sebelumnya",
                                icon: "success"
                            }).then((result) => {
                                this.$router.push({ name: 'review-usulan-proposal' })
                            })
                        }).catch(error => {
                            console.log(error)
                        })
                    } else {
                        this.axios.post(`/api/datapenilaian/${this.$route.params.id}`, this.submitedNilai).then(response => {
                            console.log(response.data)
                            // this.$swal({
                            //     title: "Success",
                            //     text: "Penilaian Berhasil Dilakukan Anda Akan dikembalikan Helaman Sebelumnya",
                            //     icon: "success"
                            // }).then((result) => {
                            //     this.$router.push({ name: 'review-usulan-proposal' })
                            // })
                        }).catch(error => {
                            console.log(error)
                        })
                    }

                }

            })
        }
    }
}
</script>