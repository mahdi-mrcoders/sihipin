<template>
    <div class="content-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Data Dosen</h4>
                        <form class="forms-sample" @submit.prevent="create">
                            <div class="form-group">
                                <label for="exampleInputUsername1">NRP</label>
                                <input type="number" class="form-control" v-model="dataForm.nrp" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">NIDN</label>
                                <input type="number" class="form-control" v-model="dataForm.nidn" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Lengkap</label>
                                <input type="text" class="form-control" v-model="dataForm.nama" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Program Studi</label>
                                <select class="form-control border border-secondary" v-model="dataForm.prodi"
                                    :required="true">
                                    <option value="">Pilih Prodi</option>
                                    <option v-for="prodi in dataProdi" :key="prodi.kode_prodi" :value="prodi.singkatan">{{ prodi.nama_prodi }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" v-model="dataForm.email" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">No HP</label>
                                <input type="number" class="form-control" v-model="dataForm.no_hp" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Jabatan Fungsional</label>
                                <select class="form-control" v-model="dataForm.jabatan_fungsional">
                                    <option value="">Pilih data</option>
                                    <option v-for="jabfung in dataJabfung" :key="jabfung.id" :value="jabfung.nama_jabfung">
                                        {{ jabfung.nama_jabfung }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pangkat/Golongan</label>
                                <select class="form-control" v-model="dataForm.pangkat_golongan">
                                    <option value="">Pilih data</option>
                                    <option v-for="golpang in dataGolpang" :key="golpang.id" :value="golpang.nama_pangkat">
                                        {{ golpang.nama_pangkat }}</option>
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <router-link class="btn btn-light" :to='{ name: "data-dosen" }'>Cancel</router-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dataForm: {},
            dataJabfung:{},
            dataGolpang:{},
            dataProdi:{}
        }
    },
    created() {
        this.getProdi()
        this.getListJabfung()
        this.getListGolpang()
    },
    methods: {
        async getProdi(){
            try {
                const response = await this.axios.get('http://siak.poltek-kampar.ac.id/app-v2/api/prodi')
                this.dataProdi = response.data
            } catch (error) {
                console.log(error)
            }
            
        },
        async getListJabfung() {
            await this.axios.get('/api/datajabfung').then(response => {
                this.dataJabfung = response.data
            }).catch(error => {

            })
        },
        async getListGolpang() {
            await this.axios.get('/api/datagolpang').then(response => {
                this.dataGolpang = response.data
            }).catch(error => {

            })
        },
        async create() {
            this.axios.post('/api/datadosen', this.dataForm).then(response => {
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    this.$router.push({ name: 'data-dosen' })
                })
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>