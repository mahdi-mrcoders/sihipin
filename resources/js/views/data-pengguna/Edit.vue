<template>
    <div class="content-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Data Pengguna</h4>
                        <form class="forms-sample" @submit.prevent="update">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Email User</label>
                                <input type="text" class="form-control" v-model="dataForm.email_dosen" :required="true"
                                    :disabled="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengguna</label>
                                <input type="text" class="form-control" v-model="dataForm.username" :required="true" :disabled="true">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="text" class="form-control" v-model="dataForm.password">
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
</template>
<script>
export default {
    data() {
        return {
            dataForm: {}
        }
    },
    created() {
        this.getDataPengguna()
    },
    methods: {
        async getDataPengguna() {
            await this.axios.get(`/api/pengguna/${this.$route.params.id}`).then(response => {
                const { email_dosen,username,level } = response.data
                this.dataForm.email_dosen = email_dosen
                this.dataForm.username = username
                this.dataForm.level = level
                this.dataForm.password = ''
                this.dataForm._method = 'patch'
                console.log(response.data)
            }).catch(erro => {
                console.log(error)
            })
        },
        async update() {
            this.axios.post(`/api/pengguna/${this.$route.params.id}`, this.dataForm).then(response => {
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