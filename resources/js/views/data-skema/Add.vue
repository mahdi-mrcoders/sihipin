<template>
    <div class="content-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Data Skema</h4>
                        <form class="forms-sample" @submit.prevent="create">
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
                                <label for="exampleInputEmail1">Ketua Peneliti Jabfung</label>
                                <select name="" id="" class="form-control" required v-model="dataForm.ketua_jabfung">
                                    <option value="" selected>Pilih Jabfung</option>
                                    <option  v-for="jabfung in listData" :key="jabfung.id" :value="jabfung.nama_jabfung">{{ jabfung.nama_jabfung }}</option>
                                </select>
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
                                    <li v-for="(list,index) in jumlahInput" :key="index">
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
            jumlahInput: 1,
            listData:{},
            dataForm: {
                syarat: []
            }
        }
    },
    created(){
        this.getDataJabfung()
    },
    methods: {
        addInput() {
            this.jumlahInput = this.jumlahInput + 1;
        },
        minusInput() {
            if (this.jumlahInput > 1) {
                this.jumlahInput = this.jumlahInput - 1;
            }
        },
        async getDataJabfung(){
            await this.axios.get('/api/datajabfung').then(response=>{
                this.listData = response.data
            }).catch(error=>{
                console.log(error)
            })
        },
        async create() {
            this.axios.post('/api/dataskema', this.dataForm).then(response => {
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