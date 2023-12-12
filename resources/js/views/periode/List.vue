
<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <h3 class="text-dark font-weight-bold text-capitalize">{{ this.$route.name }}</h3>
                        </li>
                    </ol>
                </nav>
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
                                        <th>Nama Periode</th>
                                        <th>Tahun Periode</th>
                                        <th>Status</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody v-if="tableList.length > 0">
                                    <tr v-for="(list, index) in tableList" :key="list.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ list.nama_periode }}</td>
                                        <td>{{ list.periode }}</td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-success">
                                                <input type="checkbox" :checked="list.status_periode == 'Y' ? true : false"
                                                    @click="updateStatusPeriode(list, $event)">
                                                <span class="toggle-slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label for="" class="badge bg-warning cursor-pointer" @click="editData(list)">
                                                Edit</label>
                                            <label class="badge bg-danger cursor-pointer"
                                                @click="deleteData(list.id)">Hapus</label>
                                        </td>
                                    </tr>

                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5">
                                            <div class="alert alert-info text-center" role="alert">
                                                Belum Ada Data
                                            </div>
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
            statusPeriode: false
        }
    },
    created() {
        this.getListJabfung()
    },
    methods: {
        async getListJabfung() {
            await this.axios.get('/api/dataperiode').then(response => {
                this.tableList = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async tambahData() {
            const { value: formValues } = await this.$swal({
                title: "Tambah Data Periode",
                html: `<div class="form-group">
                      <label for="exampleInputUsername1">Nama Periode</label>
                      <input type="text" class="form-control" id="name_periode">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Tahun Periode</label>
                      <input type="text" class="form-control" id="periode">
                    </div>`,
                showCancelButton: true,
                preConfirm: () => {
                    try {
                        const name_periode = document.getElementById("name_periode").value;
                        const periode = document.getElementById("periode").value;
                        if (name_periode == '' || periode == '') {
                            this.$swal.showValidationMessage('input masih kosong')
                        } else {
                            return {
                                nama_periode: name_periode,
                                periode: periode,
                                status_periode: 'N'
                            }


                        }
                    } catch (error) {

                    }

                },
            });

            if (formValues) {
                await this.axios.post('/api/dataperiode', formValues).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been Saved",
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
        async editData(data) {
            const { value: formValues } = await this.$swal({
                title: "Tambah Data Periode",
                html: `<div class="form-group">
                      <label for="exampleInputUsername1">Nama Periode</label>
                      <input type="text" class="form-control" id="name_periode" value="${data.nama_periode}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Tahun Periode</label>
                      <input type="text" class="form-control" id="periode" value="${data.periode}">
                    </div>`,
                showCancelButton: true,
                preConfirm: () => {
                    try {
                        const name_periode = document.getElementById("name_periode").value;
                        const periode = document.getElementById("periode").value;
                        if (name_periode == '' || periode == '') {
                            this.$swal.showValidationMessage('input masih kosong')
                        } else {
                            return {
                                nama_periode: name_periode,
                                periode: periode,
                                status_periode: data.status_periode,
                                _method: 'patch'
                            }


                        }
                    } catch (error) {

                    }

                },
            });

            if (formValues) {
                await this.axios.post(`/api/dataperiode/${data.id}`, formValues).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been Saved",
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
                this.axios.delete(`/api/datajabfung/${id}`).then(response => {
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
        },
        updateStatusPeriode(data, event) {

            const isChecked = event.target.checked;
            const status_periode = isChecked ? 'Y' : 'N'
            const formDataNow = {
                status_periode: 'Y',
                _method: 'patch'
            }
            const formDataOld = {
                status_periode: 'N',
                _method: 'patch'
            }
            if (status_periode == 'Y') {
                const datas = this.tableList.find(item => item.status_periode === 'Y')

                if (datas) {
                    this.$swal({
                        title: "Are you sure?",
                        text: "Mengaktifkan Periode Ini Dan Menonaktifkan Periode yang sedang aktif",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Aktifkan!"
                    }).then((result) => {
                        if (result.isConfirmed) {

                            this.axios.post(`/api/dataperiode/${data.id}`, formDataNow).then(response => {
                                this.axios.post(`/api/dataperiode/${datas.id}`, formDataOld).then(response => {
                                    this.$swal({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Your work has been Activate",
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then((result) => {
                                        this.getListJabfung()
                                    })
                                }).catch(error => {

                                })
                            }).catch(error => {

                            })
                        }
                    });
                } else {
                    this.axios.post(`/api/dataperiode/${data.id}`, formDataNow).then(response => {
                        this.$swal({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been Activate",
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            this.getListJabfung()
                        })
                    }).catch(error => {

                    })
                }
            } else {
                this.axios.post(`/api/dataperiode/${data.id}`, formDataOld).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been De-Activate",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListJabfung()
                    })
                }).catch(error => {

                })
            }

        }
    }
}
</script>