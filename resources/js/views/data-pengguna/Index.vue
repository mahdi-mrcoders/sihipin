
<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
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
                        <router-link :to='{ name: "data-pengguna-add" }'
                            class="btn btn-sm btn-icon-text btn-primary">Tambah</router-link>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email User</th>
                                        <th>Nama User</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, index) in tableList" :key="list.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ list.email_dosen }}</td>
                                        <td>{{ list.username }}</td>
                                        <td>
                                            <span class="badge bg-info" v-if="list.level == 1">P3M</span>
                                            <span class="badge bg-info" v-if="list.level == 2">Reviewer</span>
                                            <span class="badge bg-info" v-if="list.level == 3">Peneliti/Dosen</span>
                                            <span class="badge bg-info" v-if="list.level == 4">Direktur</span>
                                        </td>
                                        <td>
                                            <router-link class="badge bg-warning"
                                                :to='{ name: "data-pengguna-edit", params: { id: list.id_pengguna } }'>Edit</router-link>
                                            <label class="badge bg-danger cursor-pointer"
                                                @click="deleteData(list.id_pengguna)">Hapus</label>
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
    <router-view></router-view>
</template>
<script>
export default {
    data() {
        return {
            tableList: {}
        }
    },
    created() {
        this.getListPengguna()
    },
    methods: {
        async getListPengguna() {
            await this.axios.get('/api/pengguna').then(response => {
                this.tableList = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        deleteData(id) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                this.axios.delete(`/api/pengguna/${id}`).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListPengguna()
                    })
                }).catch(error=>{
                    console.log(error)
                })


            })
        }
    }
}
</script>