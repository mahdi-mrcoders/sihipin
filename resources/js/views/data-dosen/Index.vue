
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
                        <router-link :to='{ name: "data-dosen-add" }'
                            class="btn btn-sm btn-icon-text btn-primary">Tambah</router-link>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NRP/NIDN</th>
                                        <th>Nama</th>
                                        <th>Prodi</th>
                                        <th>JabFung</th>
                                        <th>Golongan</th>
                                        <th>No HP</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, index) in tableList" :key="list.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ list.nrp }}/{{ list.nidn }}</td>
                                        <td>{{ list.nama }}</td>
                                        <td>{{ list.prodi }}</td>
                                        <td>{{ list.jabatan_fungsional }}</td>
                                        <td>{{ list.pangkat_golongan }}</td>
                                        <td>{{ list.no_hp }}</td>
                                        <td>{{ list.email }}</td>
                                        <td>
                                            <router-link class="badge bg-warning"
                                                :to='{ name: "data-dosen-edit", params: { id: list.id } }'>Edit</router-link>
                                            <label class="badge bg-danger cursor-pointer"
                                                @click="deleteData(list.id)">Hapus</label>
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
        this.getListDosen()
    },
    methods: {
        async getListDosen() {
            await this.axios.get('/api/datadosen').then(response => {
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
                this.axios.delete(`/api/datadosen/${id}`).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListDosen()
                    })
                }).catch(error=>{
                    console.log(error)
                })


            })
        }
    }
}
</script>