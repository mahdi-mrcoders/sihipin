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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form-wizard ref="wizard" @on-validate="handleValidation" @on-complete="onComplete"
                            @on-change="validateChange" title="This is a new title" subtitle="And a new subtitle"
                            shape="tab" step-size="xs" back-button-text="Go back!" next-button-text="Go next!"
                            finish-button-text="Submit" color="#9b59b6" :start-index='0'>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Identitas Penelitian/Pengabdian Kepada Masyarakat
                                                </h4>
                                                <form class="forms-sample" ref="form0">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Judul Penelitian</label>
                                                        <textarea name="" id="" rows="3" class="form-control" :required="true"
                                                        v-model="formSubmited.judul_penelitian"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Bidang Ilmu</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.bidang_ilmu">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Skema Hibah</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.skema_hibah" :readonly="true">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Identitias Ketua Peneliti
                                                </h4>
                                                <form class="forms-sample" ref="form1">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Nama Lengkap <br><small
                                                                style="font-size:9px;">lengkapi dengan gelar</small></label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.nama_lengkap">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">NIP/NRP</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.nrp" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">NIDN/NUPN</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.nidn" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Pengkat/Golongan</label>
                                                        <select class="form-control" :required="true"
                                                            v-model="formSubmited.pangkat_golongan" disabled>
                                                            <option v-for="pangkat in listPangkat" :key="pangkat.id"
                                                                :value="pangkat.nama_pangkat">{{ pangkat.nama_pangkat }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Jabatan Fungsional</label>
                                                        <select class="form-control" :required="true"
                                                            v-model="formSubmited.jabatan_fungsional" disabled>
                                                            <option v-for="jabfung in listJabFung" :key="jabfung.id"
                                                                :value="jabfung.nama_jabfung">{{ jabfung.nama_jabfung }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Program Studi</label>
                                                        <select class="form-control" :required="true"
                                                            v-model="formSubmited.prodi" disabled>
                                                            <option v-for="prodi in ListProdi" :key="prodi" :value="prodi.singkatan">
                                                                {{ prodi.singkatan }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Alamat Kantor</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.alamat_kantor">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Telp./Faks Kantor</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.telp_kantor">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Alamat Rumah</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.alamat_rumah">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Telp/HP</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.hp" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Email</label>
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.email" readonly>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Jumlah Anggota Peneliti
                                                </h4>
                                                <form class="forms-sample" ref="form2">
                                                    <div class="form-group" v-for="(jumlah, index) in jumlahAnggota"
                                                        :key="index">
                                                        <label for="exampleInputUsername1">Anggota Peneliti {{ index + 1
                                                        }}</label>
                                                        <input type="text" class="form-control" :required="false"
                                                            v-model="jumlahanggota[index]" @click="showUser(index)">
                                                        <input type="hidden" class="form-control"
                                                            v-model="idanggota[index]">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Lokasi Penelitian/ Pengabdian Kepada Masyarakat
                                                </h4>
                                                <form class="forms-sample" ref="form3">
                                                    <div class="form-group">
                                                        <textarea  rows="5" class="form-control" :required="true"
                                                        v-model="formSubmited.lokasi_penelitian"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Jangka Waktu Penelitian/Pengabdian Kepada Masyarakat
                                                </h4>
                                                <form class="forms-sample" ref="form4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" :required="true"
                                                            v-model="formSubmited.waktu_penelitian">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Biaya Yang Diperlukan
                                                </h4>
                                                <form class="forms-sample" ref="form5">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Biaya Yang DiButuhkan</label>
                                                        <input type="number" class="form-control" :required="true"
                                                            v-model="formSubmited.biaya_penelitian">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                            <tab-content title="" :before-change="validateAsync">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Upload Dokumen
                                                </h4>
                                                <form class="forms-sample" ref="form6">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Upload File</label>
                                                        <input type="file" class="form-control" :required="true"
                                                            @change="changeFile">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tab-content>
                        </form-wizard>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { FormWizard, TabContent } from 'vue3-form-wizard'
import 'vue3-form-wizard/dist/style.css'

export default {
    components: {
        FormWizard,
        TabContent
    },
    data() {
        return {
            formSubmited: {
            },
            jumlahanggota: [],
            idanggota: [],
            files: null,
            blob: null,
            listPangkat: {},
            listJabFung: {},
            ListProdi: {},
            tabIndexs: 0,
            uuid: localStorage.getItem('uuid'),
            jumlahAnggota: 0
        }
    },
    created() {
        this.getDataSkema()
        this.getDataUser()
        this.getProdi()
        this.getListJabfung()
        this.getListGolpang()
    },
    methods: {
        async getProdi() {
            try {
                const response = await this.axios.get('http://siak.poltek-kampar.ac.id/app-v2/api/prodi')
                this.ListProdi = response.data
            } catch (error) {
                console.log(error)
            }

        },
        async getListJabfung() {
            await this.axios.get('/api/datajabfung').then(response => {
                this.listJabFung = response.data
            }).catch(error => {

            })
        },
        async getListGolpang() {
            await this.axios.get('/api/datagolpang').then(response => {
                this.listPangkat = response.data
            }).catch(error => {

            })
        },
        async onComplete() {
            if (!this.blob) {
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan Pilih File',
                })
            }

            const formData = new FormData()
            formData.append('file', this.files)
            for (const key in this.formSubmited) {
                if (this.formSubmited.hasOwnProperty(key)) {
                    const value = this.formSubmited[key]

                    if (Array.isArray(value)) {
                        value.forEach((item) => {
                            formData.append(key, value)
                        })
                    } else {
                        formData.append(key, value)
                    }
                }
            }
            this.jumlahanggota.forEach((d, index) => {
                formData.append('jumlah_anggota[]', this.jumlahanggota[index])
            })

            await this.axios.post('/api/penelitian', formData, { headers: { "Content-Type": "multipart/form-data" } })
                .then((response) => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.$router.push({ name: "submited-penelitian" })
                    })

                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        validateChange(prevIndex, nextIndex) {
            if (nextIndex < this.tabIndexs) {
                this.tabIndexs = nextIndex
                console.log('tabIndex berkurang 1')
            }
        },
        handleValidation(isValid, tabIndex) {


        },
        validateAsync() {
            return new Promise((resolve, reject) => {

                const currentForm = this.$refs[`form${this.tabIndexs}`];
                if (currentForm.reportValidity()) {
                    this.tabIndexs = this.tabIndexs + 1
                    resolve(true)
                } else {

                    resolve(false)
                }

            })
        },
        async getDataSkema() {
            await this.axios.get(`/api/dataskema/${this.$route.params.id}`).then(response => {
                const { id, nama_skema, jumlah_anggota } = response.data
                this.formSubmited.id_skema = id
                this.formSubmited.skema_hibah = nama_skema
                this.jumlahAnggota = jumlah_anggota


            }).catch(erro => {
                console.log(error)
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
            await this.axios.get(`/api/dosen/byemail/${email}`).then(response => {
                this.formSubmited.nama_lengkap = response.data.nama
                this.formSubmited.nrp = response.data.nrp
                this.formSubmited.nidn = response.data.nidn
                this.formSubmited.email = response.data.email
                this.formSubmited.pangkat_golongan=response.data.pangkat_golongan
                this.formSubmited.jabatan_fungsional=response.data.jabatan_fungsional
                this.formSubmited.prodi=response.data.prodi
                this.formSubmited.hp = response.data.no_hp
                this.formSubmited.id_dosen = response.data.id
            }).catch(error => {
                console.log(error)
            })
        },
        changeFile(event) {
            const file = event.target.files[0]
            if (file) {
                if (this.checkFileType(file)) {
                    this.blob = URL.createObjectURL(file)
                    this.files = file
                } else {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Type File Tidak Di izinkan',
                    })
                }
            }

        },
        checkFileType(file) {
            // Definisikan jenis file yang diizinkan, misalnya: application/pdf.
            const allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];

            // Cek apakah jenis file ada dalam daftar jenis file yang diizinkan
            return allowedTypes.includes(file.type);
        },
        async showUser(index) {
            try {
                const response = await this.axios.get(`/api/dosengroup/${this.formSubmited.email}`)
                const optionsData = {}
                response.data.forEach(item => {
                    const listOptions = {}
                    item.dosen.forEach(list => {
                        listOptions[`${list.id}:${list.nama}`] = list.nama
                    })
                    optionsData[item.prodi] = listOptions
                })

                const { value: fruit } = await this.$swal({
                    title: `Select Anggota Penelitia ${index + 1}`,
                    input: "select",
                    inputOptions: optionsData,
                    inputPlaceholder: "Select a Dosen",
                    showCancelButton: true,
                    inputValidator: (value) => {

                        if (value === "") {
                            return 'Pilih Terlebih dahulu'
                        }

                    }
                });
                if (fruit) {
                    let valueOption = fruit.split(':')
                    this.jumlahanggota[index] = valueOption[1]
                    this.idanggota[index] = valueOption[0]

                }
            } catch (error) {
                console.log(error)
            }

        }

    }

}
</script>