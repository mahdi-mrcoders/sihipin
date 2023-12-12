<template>
    <button class="btn btn-primary" @click="createJadwal">Buat Jadwal</button>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Skema</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="tableList.length > 0">
                <tr v-for="(list, index) in tableList" :key="list.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ list.periode.nama_periode }} - {{ list.periode.periode }}</td>
                    <td>{{ list.skema.kode_program }} - {{ list.skema.nama_skema }}</td>
                    <td>{{ list.start }}</td>
                    <td>{{ list.end }}</td>
                    <td>
                        <label class="badge bg-warning cursor-pointer" @click="updateJadwal(list)">Edit</label>
                        <label class="badge bg-danger cursor-pointer" @click="deleted(list.id)">Hapus</label>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6">
                        <div class="alert alert-info text-center" role="alert">
                            Belum Ada Data
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="createJadwal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form @submit.prevent="create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Buat Jadwal baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Periode</label>
                            <select class="form-control" id="exampleFormControlSelect2" required
                                v-model="dataJadwal.id_periode">
                                <option>Pilih Periode</option>
                                <option v-for="periode in listPeriode" :key="periode.id" :value="periode.id">{{
                                    periode.nama_periode }} - {{ periode.periode }}</option>
                            </select>
                        </div>
                        <template v-for="(skema, ind) in listSkema" :key="skema.id">
                            <div class="row" v-if="skema.status_skema == '1'">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Nama Skema</label>
                                        <input type="text" class="form-control" :value="skema.nama_skema" :disabled="true">
                                        <input type="hidden" class="form-control" v-model="dataJadwal.id_skema[ind]">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Mulai</label>
                                        <div class="input-group">
                                            <flat-pickr v-model="dataJadwal.start[ind]" :config="datePickerConfigStart"
                                                class="form-control" placeholder="Select date" name="date"
                                                @on-close="startDateChange(ind)" />
                                            <div class="input-group-append">
                                                <button class="btn btn-default" type="button" title="Clear" data-clear>
                                                    <i class="fa fa-times" />
                                                    <span aria-hidden="true" class="sr-only">Clear</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Berakhir</label>
                                        <div class="input-group">
                                            <flat-pickr v-model="dataJadwal.end[ind]" :config="datePickerConfigEnd"
                                                class="form-control" placeholder="Select date" name="date" />
                                            <div class="input-group-append">
                                                <button class="btn btn-default" type="button" title="Clear" data-clear>
                                                    <i class="fa fa-times" />
                                                    <span aria-hidden="true" class="sr-only">Clear</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updateJadwal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form @submit.prevent="update">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Buat Jadwal baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Periode</label>
                            <select class="form-control" id="exampleFormControlSelect2" readonly
                                v-model="dataJadwalUpdate.id_periode">
                                <option>Pilih Periode</option>
                                <option v-for="periode in listPeriode" :key="periode.id" :value="periode.id">{{
                                    periode.nama_periode }} - {{ periode.periode }}</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Nama Skema</label>
                                    <input type="text" class="form-control" :value="skemaUpdate" :disabled="true">
                                    <input type="hidden" class="form-control" v-model="dataJadwalUpdate.id_skema">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Mulai</label>
                                    <div class="input-group">
                                        <flat-pickr v-model="dataJadwalUpdate.start" :config="datePickerConfigStart"
                                            class="form-control" placeholder="Select date" name="date"
                                            @on-close="startDateChangeUpdate(dataJadwalUpdate.start)" />
                                        <div class="input-group-append">
                                            <button class="btn btn-default" type="button" title="Clear" data-clear>
                                                <i class="fa fa-times" />
                                                <span aria-hidden="true" class="sr-only">Clear</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Berakhir</label>
                                    <div class="input-group">
                                        <flat-pickr v-model="dataJadwalUpdate.end" :config="datePickerConfigEnd"
                                            class="form-control" placeholder="Select date" name="date" />
                                        <div class="input-group-append">
                                            <button class="btn btn-default" type="button" title="Clear" data-clear>
                                                <i class="fa fa-times" />
                                                <span aria-hidden="true" class="sr-only">Clear</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Flatpickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { Indonesian } from 'flatpickr/dist/l10n/id.js';
import 'flatpickr/dist/themes/material_blue.css';
export default {
    components: { 'flat-pickr': Flatpickr },
    props: {
        clicked: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            idJadwal: null,
            tableList: {},
            listPeriode: {},
            listSkema: {},
            skemaUpdate: '',
            dataJadwal: {
                id_skema: [],
                start: [],
                end: []
            },
            dataJadwalUpdate: {
                id_periode: '',
                id_skema: '',
                start: '',
                end: '',
                _method: 'patch'
            },
            datePickerConfigStart: {
                wrap: true,
                altFormat: "Y-m-d H:i",
                altInput: true,
                enableTime: true,
                defaultHour: 0,
                locale: Indonesian
            },
            datePickerConfigEnd: {
                wrap: true,
                altFormat: "Y-m-d H:i",
                altInput: true,
                enableTime: true,
                defaultHour: 0,
                locale: Indonesian,
            },
        }
    },
    watch: {
        clicked: function (newVal, oldVal) {
            if (newVal) {
                this.getListJadwal()
            }
        }
    },
    methods: {
        async getListJadwal() {
            await this.axios.get('/api/datajadwalusulan').then(response => {
                this.tableList = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async getListPeriode() {
            try {
                const response = await this.axios.get('/api/dataperiode');
                this.listPeriode = response.data
            } catch (error) {

            }
        },
        async createJadwal() {
            try {
                this.getListPeriode()
                const skema = await this.axios.get('/api/dataskema');
                this.listSkema = skema.data

                skema.data.forEach((item, index) => {
                    if (item.status_skema == 1) {
                        this.dataJadwal.id_skema[index] = item.id
                        this.dataJadwal.start[index] = ''
                        this.dataJadwal.end[index] = ''
                    }

                });
                $('#createJadwal').modal('show')
            } catch (error) {

            }

        },
        updateJadwal(data) {
            this.getListPeriode()
            this.idJadwal = data.id
            this.skemaUpdate = data.skema.nama_skema
            this.dataJadwalUpdate.id_periode = data.periode.id
            this.dataJadwalUpdate.id_skema = data.skema.id
            this.dataJadwalUpdate.start = data.start
            this.dataJadwalUpdate.end = data.end
            $('#updateJadwal').modal('show')
        },
        startDateChange(ind) {
            this.datePickerConfigEnd.minDate = this.dataJadwal.start[ind]
            // console.log(this.dataJadwal.start[ind])
        },
        startDateChangeUpdate(ind) {
            this.datePickerConfigEnd.minDate = this.dataJadwalUpdate.start
            // console.log(this.dataJadwal.start[ind])
        },
        async create() {
            await this.axios.post('/api/datajadwalusulan', this.dataJadwal).then(response => {
                if (response.data.status) {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been Saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        $('#createJadwal').modal('hide')
                        this.getListJadwal()
                    })

                } else {
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: response.data.message,
                    });
                }
            }).catch(error => {
                console.log(error)
            })
        },
        async update() {
            await this.axios.post(`/api/datajadwalusulan/${this.idJadwal}`, this.dataJadwalUpdate).then(response => {
                if (response.data.status) {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been Saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        $('#updateJadwal').modal('hide')
                        this.getListJadwal()
                    })

                } else {
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: response.data.message,
                    });
                }
            }).catch(error => {
                console.log(error)
            })
        },
        deleted(id) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                this.axios.delete(`/api/datajadwalusulan/${id}`).then(response => {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been delete",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getListJadwal()
                    })
                }).catch(error => {
                    console.log(error)
                })


            })
        }
    }
}
</script>