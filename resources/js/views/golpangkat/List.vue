
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
                        <button type="button" class="btn btn-primary btn-sm" @click="tambahData">Tambah</button>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jabfung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, index) in tableList" :key="list.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ list.nama_pangkat }}</td>
                                        <td>
                                            <label for="" class="badge bg-warning cursor-pointer" @click="editData(list)"> Edit</label>
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
        this.getListJabfung()
    },
    methods: {
        async getListJabfung() {
            await this.axios.get('/api/datagolpang').then(response => {
                this.tableList = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async tambahData() {

            const inputValue = '';
            const { value: name } = await this.$swal({
                title: "Tambah Data Golongan Pangkat",
                input: "text",
                inputLabel: "Nama Golongan Pangkat",
                inputValue,
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return "You need to write something!";
                    }
                }
            });
            if (name) {
                await this.axios.post('/api/datagolpang', { nama_pangkat: name }).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListJabfung()
                    })
                }).catch(error => {
                    console.log()
                })
            }
        },
       async editData(data){
            const inputValue = data.nama_pangkat
            const { value: name } = await this.$swal({
                title: "Ubah Data Golongan Pangkat",
                input: "text",
                inputLabel: "Nama Golongan Pangkat",
                inputValue,
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return "You need to write something!";
                    }
                }
            });
            if (name) {
                await this.axios.post(`/api/datagolpang/${data.id}`, { nama_pangkat: name,_method:'patch' }).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListJabfung()
                    })
                }).catch(error => {
                    console.log()
                })
            }
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
                this.axios.delete(`/api/datagolpang/${id}`).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListJabfung()
                    })
                }).catch(error => {
                    console.log(error)
                })


            })
        }
    }
}
</script>