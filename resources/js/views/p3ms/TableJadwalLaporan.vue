<template>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Laporan</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="tableList.length > 0">
                <tr v-for="(list, index) in tableList" :key="list.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ list.jenis_laporan }}</td>
                    <td>{{ list.start }}</td>
                    <td>{{ list.end }}</td>
                    <td>
                        <label class="badge bg-warning cursor-pointer" @click="updateJadwal(list)">Edit</label>
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

    <div class="modal fade" id="updateJadwalLaporan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form @submit.prevent="update">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Buat Jadwal baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Jenis Laporan</label>
                                    <input type="text" class="form-control" :value="dataJadwalUpdate.jenis_laporan" >
                                    <input type="hidden" class="form-control" v-model="dataJadwalUpdate.id">
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
            dataJadwalUpdate: {
                jenis_laporan: '',
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
            await this.axios.get('/api/datajadwallaporan').then(response => {
                this.tableList = response.data
                console.log(response.data)
            }).catch(error => {
                console.log(error)
            })
        },
        updateJadwal(data) {
            this.idJadwal = data.id
            this.dataJadwalUpdate.jenis_laporan= data.jenis_laporan
            this.dataJadwalUpdate.start = data.start
            this.dataJadwalUpdate.end = data.end
            $('#updateJadwalLaporan').modal('show')
        },
        startDateChange(ind) {
            this.datePickerConfigEnd.minDate = this.dataJadwal.start[ind]
            // console.log(this.dataJadwal.start[ind])
        },
        startDateChangeUpdate(ind) {
            this.datePickerConfigEnd.minDate = this.dataJadwalUpdate.start
            // console.log(this.dataJadwal.start[ind])
        },
        async update() {
            await this.axios.post(`/api/datajadwallaporan/${this.idJadwal}`, this.dataJadwalUpdate).then(response => {
                if (response.data.status) {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been Saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        $('#updateJadwalLaporan').modal('hide')
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
    }
}
</script>