<template>
    <div class="content-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Data Skema</h4>
                        <form class="forms-sample" @submit.prevent="update">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Nama Skema</label>
                                <input type="text" class="form-control" v-model="dataForm.nama_skema" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Jumlah Anggota</label>
                                <input type="number" class="form-control" v-model="dataForm.jumlah_anggota"
                                    :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Status Skema</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" :value="1"
                                                    v-model="dataForm.status_skema">
                                                Aktif
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" :value="0"
                                                    v-model="dataForm.status_skema">
                                                Non Aktif
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Program Skema</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" :value="'P-PKM'"
                                                    v-model="dataForm.program_skema">
                                                PKM
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" :value="'P-PL'"
                                                    v-model="dataForm.program_skema">
                                                Program Penelitian
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="d-block">Syarat Jabfung Ketua Peneliti</label>
                                <div class="form-check form-check-inline" v-for="(jabfung, index) in listData"
                                    :key="jabfung.id">
                                    <input class="form-check-input" type="checkbox" :id="'inlineCheckbox' + index"
                                        :value="jabfung.nama_jabfung" v-model="selectedCheck">
                                    <label class="form-check-label" :for="'inlineCheckbox' + index"
                                        style="margin-left:.5rem">{{
                                            jabfung.nama_jabfung
                                        }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Persyaratan</label>
                                <div class="input-group mb-3" style="width:25%">
                                    <button class="btn btn-info" type="button" id="button-addon1" @click="minusInput"><i
                                            class="fa-solid fa-square-minus fa-lg"></i></button>
                                    <input type="text" class="form-control" aria-describedby="button-addon1"
                                        v-model="jumlahInput" :disabled="true">
                                    <button class="btn btn-info" type="button" @click="addInput"><i
                                            class="fa-solid fa-square-plus fa-lg"></i></button>
                                </div>
                            </div>
                            <div class="form-group">
                                <ol>
                                    <li v-for="(list, index) in jumlahInput" :key="index">
                                        <input type="hidden" class="form-control mt-2 " v-model="dataForm.idsyarat[index]">
                                        <input type="text" class="form-control mt-2 " v-model="dataForm.syarat[index]">
                                    </li>
                                </ol>


                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <router-link class="btn btn-light" :to='{ name: "data-skema" }'>Cancel</router-link>
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
            selectedCheck: [],
            jumlahInput: 1,
            jumlahData: 0,
            listData: {},
            dataForm: {
                syarat: [],
                idsyarat: [],

            }
        }
    },
    created() {
        this.getDataJabfung()
        this.getDataSkema()

    },
    methods: {
        updateSelectedValues(evt) {
            // Update nilai yang terpilih ke array selectedCheck
            this.selectedCheck = this.listData.map(item => item.nama_jabfung);
            console.log(evt.value)
        },
        addInput() {
            this.jumlahInput = this.jumlahInput + 1;
            this.dataForm.idsyarat.push(0);
            this.dataForm.syarat.push('');
        },
        minusInput() {
            if (this.jumlahInput > this.jumlahData) {
                this.jumlahInput = this.jumlahInput - 1;
                this.dataForm.idsyarat.splice(this.jumlahInput, 1)
                this.dataForm.syarat.splice(this.jumlahInput, 1)

            } else {
                this.$swal({
                    title: "Informasi",
                    text: `${this.jumlahData} Data Tidak Boleh Di Hapus hanya boleh di ubah`,
                    icon: "error"
                });
            }

        },
        async getDataJabfung() {
            await this.axios.get('/api/datajabfung').then(response => {
                this.listData = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async getDataSkema() {
            await this.axios.get(`/api/dataskema/${this.$route.params.id}`).then(response => {
                const { nama_skema, jumlah_anggota, kode_program, status_skema, syarat, ketua_jabfung } = response.data
                this.dataForm.nama_skema = nama_skema
                this.dataForm.jumlah_anggota = jumlah_anggota
                this.dataForm.status_skema = status_skema
                this.jumlahInput = response.data.syarat.length
                this.jumlahData = response.data.syarat.length
                this.dataForm.program_skema = kode_program
                this.dataForm.ketua_jabfung = ketua_jabfung
                this.selectedCheck = ketua_jabfung.split(',').map(item => item.trim())
                this.dataForm._method = 'patch'
                syarat.forEach((item) => {
                    const { id, persyaratan } = item
                    this.dataForm.syarat.push(persyaratan)
                    this.dataForm.idsyarat.push(id)
                })

            }).catch(erro => {
                console.log(error)
            })
        },
        async update() {
            this.dataForm.ketua_jabfung = this.selectedCheck
            this.axios.post(`/api/dataskema/${this.$route.params.id}`, this.dataForm).then(response => {
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    this.$router.push({ name: 'data-skema' })
                })
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>