<template>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>File</th>
                    <th>Kode Usulan</th>
                    <th>Periode</th>
                    <th style="width:20%">Skema judul Usulan</th>
                    <th>Peneliti & anggota</th>
                    <th>Team Reviewer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="dataTable.length > 0">
                <tr v-for="(list, index) in dataTable" :key="list.id">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <i class="fa-regular fa-file-word fa-lg me-1 cursor-pointer"
                            @click="fetchDocxFile(list.file_proposal)" data-toggle="tooltip" data-placement="top"
                            :title="`File Proposal : ${list.file_proposal}`"></i>
                        <i class="fa-regular fa-file-powerpoint fa-lg me-1 cursor-pointer" data-toggle="tooltip"
                            data-placement="top" :title="`File Pptx :${list.file_presentasi}`"
                            @click="fetchPptFile(list.file_presentasi)"
                            v-show="list.file_presentasi != null ? true : false"></i>
                    </td>
                    <td>{{ list.kode_skema }}-{{ list.id }}</td>
                    <td>{{ list.periode }}</td>
                    <td>{{ list.nama_skema }}<br>{{ list.informasi.judul_penelitian }}</td>
                    <td>Ketua : {{ list.ketua_peneliti }}<br>Jumlah Anggota : {{ list.anggota.length }}</td>
                    <td>
                        <li v-for="(rev, key) in list.reviewer" :key="rev.id" style="list-style-type:none">REV {{ key + 1 }}
                            :
                            {{ rev.nama_reviewer }}</li>
                    </td>
                    <td>
                        <label class="badge bg-danger" @click="validasiHasil(list)">Tolak Usulan</label>
                        <hr>
                        <label class="badge bg-info" @click="setReviewer(list.id)">Terima dan Atur Reviewer</label>
                    </td>
                </tr>

            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="8">
                        <div class="alert alert-info text-center" role="alert">
                            Belum Ada Data
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <FormModalReviewer :dataPenelitian="datatPenelitian" @stateResult="ResultState($event)"></FormModalReviewer>

    <div class="modal fade" id="previewFile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="container-file"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormModalReviewer from './FormModalReviewer'
export default {
    components: { FormModalReviewer },
    data() {
        return {
            dataTable: {},
            level: localStorage.getItem("level"),
            uuid: localStorage.getItem('uuid'),
            idsn: null,
            datatPenelitian: null,
            docxFile: null,
            dataPengajuan: {},

        }
    },
    mounted() {
        this.getDataUser()
    },
    methods: {
        ResultState(result) {
            this.isClicked = false
            this.tableList = {}
            this.$router.go(0);

        },
        async getDataUser() {
            await this.axios.get(`/api/pengguna/${this.uuid}`).then(response => {
                this.getDataDosen(response.data.email_dosen)
            }).catch(error => {
                console.log(error)
            })

        },
        async getDataDosen(email) {
            await this.axios.get(`/api/dosen/byemail/${email}`).then(responses => {
                this.idsn = responses.data.id
                this.getListSubmited()
            }).catch(error => {
                console.log(error)
            })
        },
        async getListSubmited() {
            await this.axios.get(`/api/penelitian?level=${this.level}&idsn=${this.idsn}`).then(response => {
                this.dataTable = response.data
            }).catch(error => {
                console.log(error)
            })

        },
        setReviewer(data) {
            this.datatPenelitian = data
            $('#modal-reviewer').modal('show')
            this.isClicked = true
        },
        async fetchDocxFile(data) {
            try {
                const response = await this.axios.get(`/api/filedocx/${data}`, { responseType: 'blob' });
                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' });
                const docxOptions = Object.assign(docx.defaultOptions, {
                    debug: true,
                    experimental: true
                });
                const container = document.querySelector("#container-file");
                const files = window.URL.createObjectURL(blob);
                docx.renderAsync(blob, container, null, docxOptions)
                    .then((x) => {
                        console.log(x);
                    });
                $('#previewFile').modal('show');
            } catch (error) {
                console.error('Error fetching PDF:', error);
            }
        },
        async fetchPptFile(filename) {
            try {
                const response = await this.axios.get(`/api/fileppt/${filename}`, { responseType: 'blob' });
                const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.presentationml.presentation' });
                // this.pdfDocument = ;
                // window.URL.createObjectURL()
                window.location.href = `/api/fileppt/${filename}`
                // $('#previewFile').modal('show');
            } catch (error) {
                console.error('Error fetching docx:', error);
            }
        },
        async validasiHasil(data) {
            const detailData = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
            </ul>
            `;
            const inputOptions = new Promise((resolve) => {
                setTimeout(() => {
                    resolve({
                        "Tolak": "Tolak",
                        // "Terima": "Terima"
                    });
                }, 100);
            });


            const { value: status } = await this.$swal({
                title: "Validasi Usulan Di Tolak",
                html: detailData,
                input: "radio",
                inputValue: "Tolak",
                inputOptions,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return "Anda perlu memilih sesuatu!";
                    }
                }
            });
            if (status) {
                this.dataPengajuan.id = data.id
                this.dataPengajuan.status = status
                await this.axios.post('/api/updatevalidasi', this.dataPengajuan).then(response => {
                    this.getDataUser()
                }).catch(error => {
                    console.log(error)
                })

            }


        },
    }
}
</script>