<template>
    <div class="content-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Upload Progress Laporan Penelitian</h4>
                        <form class="forms-sample" @submit.prevent="uploadProgress">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Skema Usulan</label>
                                <input type="text" class="form-control" :required="true" readonly
                                    :value="dataSkema.nama_skema">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Judul Usulan</label>
                                <input type="text" class="form-control" :required="true" readonly
                                    :value="dataSkema.judul_penelitian">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Laporan</label>
                                <input type="text" class="form-control" :value="dataProgres.jenis_laporan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">File</label>
                                <input type="file" class="form-control" :required="true" @change="changeFile">
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <router-link class="btn btn-light" :to='{ name: "submited-penelitian" }'>Cancel</router-link>
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
            dataSkema: {},
            dataProgres: {},
            file: null
        }
    },
    created() {
        this.getDataSkema()
        this.getDataProgress()
    },
    methods: {
        async getDataSkema() {
            await this.axios.get(`/api/penelitian/${this.$route.params.id}`).then(response => {
                // console.log(response.data)
                this.dataSkema.nama_skema = response.data.nama_skema
                this.dataSkema.judul_penelitian = response.data.informasi.judul_penelitian
            }).catch(error => {
                console.log(error)
            })
        },
        async getDataProgress() {
            await this.axios.get(`/api/progress/${this.$route.params.id}`).then(response => {
                if (response.data.data != null) {
                    this.dataProgres.idp = this.$route.params.id
                    this.dataProgres.jenis_laporan = response.data.data.next_laporan
                    if (response.data.data.validasi == 'prosess') {
                        this.$swal({
                            icon: "error",
                            title: "Oops...",
                            text: `Status laporan ${response.data.data.next_laporan} Anda Masih Proses Validasi`,
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Back To Submited Page",
                            allowOutsideClick: false
                        }).then(result => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'submited-penelitian' })
                            } else {
                                this.$router.go(0);
                            }
                        })
                    }
                } else {
                    this.dataProgres.idp = this.$route.params.id
                    this.dataProgres.jenis_laporan = 'Progress'
                }
            }).catch(error => {
                console.log(error)
            })
        },
        changeFile(event) {
            const file = event.target.files[0]
            if (file) {
                this.files = file

            }

        },
        async uploadProgress() {

            const formData = new FormData()
            formData.append('file', this.files)
            formData.append('id_pengajuan', this.dataProgres.idp)
            formData.append('jenis_laporan', this.dataProgres.jenis_laporan)
            // formData.append('validasi', 'proses')

            await this.axios.post('/api/uploadprogress', formData, { headers: { "Content-Type": "multipart/form-data" } }).then(response => {
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    this.$router.push({ name: 'submited-penelitian' })
                })
            }).catch(error => {
                console.log()
            })

        }
    },
}
</script>