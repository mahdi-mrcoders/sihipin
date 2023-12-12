
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
                        <router-link :to='{ name: "data-skema-add" }'
                            class="btn btn-sm btn-icon-text btn-primary" v-show="level == 1 ? true:false">Tambah</router-link>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Program</th>
                                        <th>Nama Skema</th>
                                        <th>Jumlah Anggota</th>
                                        <th>Persyaratan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, index) in tableList" :key="list.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ list.kode_program }}</td>
                                        <td>{{ list.nama_skema }}</td>
                                        <td>{{ list.jumlah_anggota }}</td>
                                        <td>
                                            <label for="">Ketua Peneliti : {{ list.ketua_jabfung }}</label>
                                            <ul>
                                                <li v-for="syarat in list.syarat" :key="syarat.id" style="font-size:12px">{{ syarat.persyaratan }}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <label class="badge bg-success" v-if="list.status_skema == 1">Aktif</label>
                                            <label class="badge bg-danger" v-else>Non Aktif</label>
                                        </td>
                                        <td v-if="level == 1">
                                            <router-link class="badge bg-warning"
                                                :to='{ name: "data-skema-edit", params: { id: list.id } }'>Edit</router-link>
                                            <label class="badge bg-danger cursor-pointer"
                                                @click="deleteData(list.id)">Hapus</label>
                                        </td>
                                        <td v-if="level == 3">
                                            <router-link class="btn btn-primary btn-sm" :to='{name:"submited-penelitian",params: { id: list.id }}'>Submit</router-link>
                                            <button type="button" class="btn btn-primary">Hasil</button>
                                            <button type="button" class="btn btn-primary">Pelaporan</button>
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
            tableList: {},
            level: localStorage.getItem("level")
        }
    },
    created() {
        this.getListSkema()
    },
    methods: {
        async getListSkema() {
            await this.axios.get('/api/dataskema').then(response => {
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
                this.axios.delete(`/api/dataskema/${id}`).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListSkema()
                    })
                }).catch(error=>{
                    console.log(error)
                })


            })
        }
    }
}
</script>