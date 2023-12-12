<template>
    <div class="modal fade" id="modal-reviewer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="createReviewer">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Nama Skema</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="inputEmail3" readonly
                                    v-model="dataReview.nama_skema">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Judul</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="inputEmail3" readonly
                                    v-model="dataReview.judul">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Ketua Peneliti</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="inputEmail3" readonly
                                    v-model="dataReview.ketua">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Anggota</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="inputEmail3" readonly
                                    v-model="dataReview.anggota">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Reviewer 1</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="exampleFormControlSelect1"
                                    v-model="dataReview.reviewerId[0]" required @change="selectToNextReview">
                                    <option v-for="riviewers in listReviewer.list_satu" :key="riviewers"
                                        :value="riviewers.id + ':' + riviewers.nama">{{ riviewers.nrp }} - {{
                                            riviewers.nama }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Reviewer 2</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="exampleFormControlSelect1"
                                    v-model="dataReview.reviewerId[1]" required>
                                    <option v-for="riviewers in listReviewer.list_dua" :key="riviewers"
                                        :value="riviewers.id + ':' + riviewers.nama">{{ riviewers.nrp }} - {{
                                            riviewers.nama }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="closeModal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ dataList ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    emits: ['stateResult'],
    props: {
        dataPenelitian: null,
    },
    data() {
        return {
            listReviewer: {},
            dataReview: {
                reviewerId: [],
            },
            dataList: false
        }
    },
    watch: {
        dataPenelitian: function (newVal, oldVal) {
            this.getDataPenelitian(newVal)
            this.getListReviewerUser()
        }
    },
    created() {

    },
    methods: {
        async getDataPenelitian(id) {
            await this.axios.get(`/api/penelitian/${id}`).then(response => {
                const { id, nama_skema, informasi, ketua_peneliti, anggota } = response.data
                this.dataReview.id_pengajuan = id
                this.dataReview.nama_skema = nama_skema
                this.dataReview.judul = informasi.judul_penelitian
                this.dataReview.ketua = ketua_peneliti
                this.dataReview.anggota = anggota.length
                this.getDataReviewer(id)
            }).catch(error => {
                console.log(error)
            })
        },
        async getDataReviewer(id) {
            await this.axios.get(`/api/datareviewer/${id}`).then(response => {
                if (response.data.length > 0) {
                    this.dataList = true
                    const myObj = []
                    response.data.forEach((elm, index) => {
                        this.dataReview.reviewerId[index] = elm.id_dosen + ':' + elm.nama_reviewer
                        myObj.push(elm.id)
                    });
                    this.dataReview.idrev = myObj
                    const data = {
                        target: {
                            value: this.dataReview.reviewerId[0]
                        }

                    }
                    this.selectToNextReview(data)
                } else {
                    this.dataList = false
                    this.dataReview.reviewerId = {}
                }
            }).catch(error => {
                console.log(error)
            })
        },
        async getListReviewerUser() {
            await this.axios.get('/api/listusers/level').then(response => {
                this.listReviewer.list_satu = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async selectToNextReview(event) {
            const values = event.target.value.split(':')
            await this.axios.get(`/api/listusers/level?ids=${values[0]}`).then(response => {
                this.listReviewer.list_dua = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async createReviewer() {
            if (this.dataList == false) {
                await this.axios.post('/api/datareviewer', this.dataReview).then(response => {

                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.closeModal()
                        this.$emit('stateResult', true)
                    })
                }).catch(error => {
                    console.log(error)
                })
            } else {
                this.updateReviewer()
            }

        },
        async updateReviewer() {
            this.dataReview._method = 'patch'
            await this.axios.post(`/api/datareviewer/${this.dataReview.id_pengajuan}`, this.dataReview).then(response => {
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been Updated",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    this.closeModal()
                    this.$emit('stateResult', true)
                })
            }).catch(error => {
                console.log(error)
            })
        },
        closeModal() {
            $('#modal-reviewer').modal('hide')
        },
    }
}
</script>