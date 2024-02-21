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
            <div class="col-lg-4">
                <div class="card" v-show="level == 1 ? true : false">
                    <div class="card-body">
                        <form class="forms-sample" @submit.prevent="create">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Nama Buku</label>
                                <input type="hidden" v-model="upFile.id">
                                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="nama buku"
                                    v-model="upFile.nama_data" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">File</label>
                                <input type="file" class="form-control" id="exampleInputEmail1" @change="changeFile"
                                    ref="inputFile">
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List File Uploded</h4>
                        <ul class="list-arrow">
                            <li v-for="(data, index) in dataFile" :key="data.id">{{ data.nama_data }} <i
                                    class="fa-solid fa-eye" style="color: #2f8c92;cursor:pointer"
                                    @click="downloadFile(data.file)"></i> <i class="fa-solid fa-square-pen"
                                    style="cursor:pointer" @click="editFile(data)" v-show="level == 1 ? true : false"></i>
                                <i class="fa-solid fa-trash-can" style="color: #c22419;cursor:pointer"
                                    v-show="level == 1 ? true : false"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <object :data="blob" type="application/pdf" width="100%" height="460"></object>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            files: null,
            blob: null, // Inisialisasi variabel untuk menampilkan preview PDF
            upFile: {
                nama_data: '',
                id: ''
            },
            dataFile: {
                nama_data: '',
                id: '',
                file: ''
            },
            level: localStorage.getItem("level")

        };
    },
    created() {
        this.getDataFile()
    },
    methods: {
        changeFile(event) {
            const file = event.target.files[0]
            if (file) {
                if (this.checkFileType(file)) {
                    this.blob = URL.createObjectURL(file)
                    this.files = file
                } else {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Type File Tidak Di izinkan',
                    })
                }
            }

        },
        checkFileType(file) {
            // Definisikan jenis file yang diizinkan, misalnya: application/pdf.
            const allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];

            // Cek apakah jenis file ada dalam daftar jenis file yang diizinkan
            return allowedTypes.includes(file.type);
        },
        async getDataFile() {
            const response = await this.$http.get('/api/bukupanduan');
            this.dataFile = response.data
            if (response.data.length > 0) {
                this.downloadFile(response.data[0].file)

            } else {
                this.downloadFile('preview.pdf')
            }
        },
        editFile(data) {
            this.upFile.id = data.id
            this.upFile.nama_data = data.nama_data
            this.downloadFile(data.file)
        },
        async downloadFile(filename) {
            const response = await this.axios.get(`/api/filepdf/${filename}`, { responseType: 'blob' });
            const blob = new Blob([response.data], { type: 'application/pdf' });
            this.blob = window.URL.createObjectURL(blob);
        },
        async create() {
            // console.log(this.blob)

            const formData = new FormData()
            formData.append('file', this.files)
            formData.append('nama_data', this.upFile.nama_data)

            if (this.upFile.id == '') {
                if (!this.file) {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silahkan Pilih File',
                    })
                } else {
                    const response = await this.axios.post('/api/bukupanduan', formData)
                    if (response.status == 200) {
                        this.$swal({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been saved",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.getDataFile()
                        this.blob = null
                        this.files = null
                        this.upFile.nama_data = ''
                        this.upFile.id = ''
                        this.$refs.inputFile.value = null;
                    } else {
                        console.log(response)
                    }
                }

            } else {
                formData.append('_method', 'patch')
                const response = await this.axios.post(`/api/bukupanduan/${this.upFile.id}`, formData)
                if (response.status == 200) {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been update",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getDataFile()
                    this.blob = null
                    this.files = null
                    this.upFile.nama_data = ''
                    this.upFile.id = ''
                    this.$refs.inputFile.value = null;
                } else {
                    console.log(response)
                }

            }



        },


    }
};

</script>