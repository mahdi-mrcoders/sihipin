<template>
    <div class="content-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Data Pengguna</h4>
                        <form class="forms-sample" @submit.prevent="create">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Email User</label>
                                <input type="text" class="form-control" v-model="dataForm.email_dosen" :required="true"
                                    @click="showDataDosen">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengguna</label>
                                <input type="text" class="form-control" v-model="dataForm.username" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="text" class="form-control" v-model="dataForm.password" :required="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Level</label>
                                <select name="" id="" class="form-control form-control-lg" v-model="dataForm.level"
                                    :required="true">
                                    <option value="1">P3M</option>
                                    <option value="2">Reviewer</option>
                                    <option value="3">Peneliti</option>
                                    <option value="4">Direktur</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <router-link class="btn btn-light" :to='{ name: "data-pengguna" }'>Cancel</router-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="data-dosen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-info">
                                <tr>
                                    <th>NRP</th>
                                    <th>NIDN</th>
                                    <th>Email</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="list in tableList" :key="list.id">
                                    <td>{{ list.nrp }}</td>
                                    <td>{{ list.nidn }}</td>
                                    <td>{{ list.email }}</td>
                                    <td>{{ list.nama }}</td>
                                    <td>
                                        <label class="badge bg-danger" style="cursor:pointer" v-if="list.id_pengguna == null" @click="pilihUser(list)">No Created</label>
                                        <label class="badge bg-success" v-else>Created</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            tableList: {}
        }
    },
    methods: {
        showDataDosen() {
            $('#data-dosen').modal('show')
            this.getListDosen()
        },
        async getListDosen() {
            await this.axios.get('/api/listusers').then(response => {
                this.tableList = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        pilihUser(data){
            this.dataForm.email_dosen = data.email
            this.dataForm.username = data.nama
            this.dataForm.password = data.nrp
            $('#data-dosen').modal('hide')
            
        },
        async create() {
            this.axios.post('/api/pengguna', this.dataForm).then(response => {
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    this.$router.push({ name: 'data-pengguna' })
                })
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>