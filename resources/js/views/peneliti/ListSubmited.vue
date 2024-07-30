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
                        <button class="btn btn-sm btn-icon-text btn-primary" @click="newSubmited"
                            v-show="level == 3 ? true : false">New Submited</button>

                        <hr>
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Submit</th>
                                    <th style="width:15%">File</th>
                                    <th>Nama Skema & Judul Penelitain/PKM</th>
                                    <th>Ketua Peneliti & Anggota</th>
                                    <th>Status Pengajuan</th>
                                    <th>Status Pelaporan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody v-if="tableList.length > 0">
                                <tr v-for="(list, index) in tableList" :key="list.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ list.created_at }}</td>
                                    <td>
                                        <i class="fa-regular fa-lg me-1 cursor-pointer"
                                            :class="getFileExtension(list.file_proposal)" data-toggle="tooltip"
                                            data-placement="top" :title="`file Usulan : ${list.file_proposal}`"
                                            @click="fetchDocxFile(list.file_proposal)"></i>
                                        <i class="fa-regular fa-file-powerpoint fa-lg me-1 cursor-pointer"
                                            data-toggle="tooltip" data-placement="top"
                                            :title="`File Pptx :${list.file_presentasi}`"
                                            @click="fetchPptFile(list.file_presentasi)"
                                            v-show="list.file_presentasi != null ? true : false"></i>
                                        <span v-for="fileP in list.progress" :key="fileP.id">
                                            <i class="fa-regular fa-lg me-1 cursor-pointer" data-toggle="tooltip"
                                                data-placement="top" :class="getFileExtension(fileP.file_progress)"
                                                :title="`${fileP.jenis_laporan}:${fileP.file_progress}`"
                                                v-show="fileP.validasi != 'No Upload' ? true : false"
                                                @click="fetchDocxFile(fileP.file_progress)"></i>
                                        </span>

                                    </td>
                                    <td>{{ list.nama_skema }}<br>{{ list.informasi.judul_penelitian }}</td>
                                    <td>
                                        Ketua : {{ list.ketua_peneliti }} <br>
                                        <span v-for="(anggota, anggotaIndex) in list.anggota" :key="anggota.id">
                                            {{ anggota.nama_anggota }}
                                            <span v-if="anggotaIndex !== list.anggota.length - 1">, </span>
                                        </span>
                                    </td>
                                    <td>
                                        <ul style="font-size:10px;padding-left:0;margin-bottom:0">
                                            <li style="list-style-type:none">
                                                Usulan : <label class="badge bg-danger"
                                                    v-if="list.status_pengajuan == 'Tolak'">Tolak</label>
                                                <label class="badge bg-info"
                                                    v-if="list.status_pengajuan == 'Prosess'">Proses</label>
                                                <label class="badge bg-warning"
                                                    v-if="list.status_pengajuan == 'In Review'">In
                                                    Review</label>
                                                <label class="badge bg-success"
                                                    v-if="list.status_pengajuan == 'Terima'">Terima</label>
                                                <i class="fa-solid fa-circle-info fa-lg"
                                                    v-if="list.status_pengajuan == 'Tolak'" style="cursor:pointer"
                                                    @click="showInfo(list.alasan_tolak)"></i>
                                            </li>
                                            <li style="list-style-type:none">
                                                Hasil : {{ list.status_pemenang }}
                                            </li>
                                        </ul>

                                    </td>
                                    <td>
                                        <label for="" v-if="list.progress == null">-</label>
                                        <ul style="font-size:10px;padding-left:0;margin-bottom:0" v-else>
                                            <li v-for="progres in list.progress" :key="progres"
                                                style="list-style-type:none">
                                                {{ progres.jenis_laporan }}: <br><span class="badge "
                                                    :class="progres.validasi == 'prosess' ? 'bg-info' : progres.validasi == 'Terima' ? 'bg-success' : 'bg-danger'">{{
                            progres.validasi }}</span>
                                                <i class="fa-solid fa-circle-info fa-lg"
                                                    v-if="progres.validasi == 'Tolak'" style="cursor:pointer"
                                                    @click="showInfo(progres.alasan_tolak)"></i>
                                            </li>
                                        </ul>

                                    </td>
                                    <td>
                                        <ul style="font-size:10px;padding-left:0;margin-bottom:0"
                                            v-if="list.kontrak != null">
                                            Status Validasi No Kontrak : {{ list.kontrak.no_kontrak }}
                                            <li style="list-style-type:none">Pihak 1 : {{ list.kontrak.pihak_satu }}
                                            </li>
                                            <li style="list-style-type:none">Pihak 2 :{{ list.kontrak.pihak_dua }}</li>
                                            <li style="list-style-type:none">Direktur:{{ list.kontrak.mengetahui }}</li>
                                        </ul>
                                        <ul style="font-size:10px;padding-left:0;margin-bottom:0" v-else>
                                            Status Validasi No Kontrak: -
                                            <li style="list-style-type:none">Pihak 1 : </li>
                                            <li style="list-style-type:none">Pihak 2 :</li>
                                            <li style="list-style-type:none">Direktur:</li>
                                        </ul>
                                    </td>
                                    <td v-if="list.status_pengajuan == 'Terima' && list.status_pemenang == 'In Review'">
                                        <label for="" class="badge bg-warning cursor-pointer"
                                            @click="uploadFilePresentasi(list.id)">Upload File Presentasi</label>
                                    </td>
                                    <td
                                        v-else-if="list.status_pengajuan == 'Terima' && list.status_pemenang == 'Pemenang'">
                                        <label class="badge bg-info" @click="validasiKontrak(list)">Validasi
                                            Kontrak</label>
                                        <hr>
                                        <label class="badge bg-info" @click="uploadLaporan(list)"
                                            v-if="actionButtonLaporan(list)">Upload Progress</label>
                                        <label class="badge bg-success"
                                            v-if="!actionButtonLaporan(list)">Selesai</label>
                                    </td>
                                    <td v-if="list.status_pengajuan == 'Tolak' || list.status_pengajuan == 'Prosess'">
                                        <label class="badge bg-secondary" @click="reUploadFile(list.id)">Re Upload File
                                            Usulan</label>
                                    </td>
                                </tr>

                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="9">
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
    <router-view></router-view>
    <div class="modal fade" id="select-skema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Skema</th>
                                    <th>Persyaratan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="skemas in listSkema" :key="skemas.id">
                                    <td>{{ skemas.nama_skema }}</td>
                                    <td>
                                        <ol>
                                            <li v-for="syarats in skemas.syarat" :key="syarats.id">{{
                            syarats.persyaratan }}
                                            </li>
                                        </ol>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"
                                            @click="goToFormSubmited(skemas.id)">Pilih</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="previewFile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closeAndclear"></button>
                </div>
                <div class="modal-body">
                    <div id="container-file" v-show="docxFile != null ? true : false"></div>
                    <object :data="pdfDocument" width="100%" height="700px"
                        v-show="pdfDocument != null ? true : false" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    data() {
        return {
            docxFile: null,
            pdfDocument: null,
            pptfile: null,
            tableList: {},
            level: localStorage.getItem("level"),
            uuid: localStorage.getItem('uuid'),
            idsn: null,
            listSkema: {},
            selectSkema: '',
            datatPenelitian: null,
            isClicked: false,
            dataList: {},
            dataValidasi: {},
            dataKontrak: {},
            stateFormKontrak: false,
            dosens: {},
            dataPeriode: {}
        }
    },
    created() {
        this.getDataUser()
        this.axios.get(`/api/dataperiode?aktif=Y`).then(response => {
            this.dataPeriode = response.data
        }).catch(error => {
            console.log(error)
        })

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
                this.dosens = responses.data
                this.getListSubmited()
            }).catch(error => {
                console.log(error)
            })
        },
        async getListSubmited() {
            try {
                await this.axios.get(`/api/penelitian?level=${this.level}&idsn=${this.idsn}`).then(response => {
                    this.tableList = response.data
                }).catch(error => {
                    console.log(error)
                })
            } catch (error) {

            }

        },
        async getListSkema() {
            await this.axios.get('/api/dataskema').then(response => {
                this.listSkema = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        async checkIsexistKetuaPeneliti() {
            try {
                const response = await this.axios.get(`/api/submitedketua/${this.dataPeriode.id}/${this.idsn}`);
                if (response.data.length > 0) {
                    return false;
                } else {
                    return true;
                }
            } catch (error) {
                // Lakukan penanganan kesalahan/error di sini jika diperlukan
                console.error(error);
                return false; // Atau return nilai default jika terjadi error
            }
        },
        async newSubmited() {
            try {
                const ada = await this.checkIsexistKetuaPeneliti()

                const response = await this.axios.get('/api/dataskema');
                const dataSkema = response.data;
                const jadwalSkema = {};
                const syaratSkema = {};
                const syaratKhusus = {}

                let listSkema = '<option value="">Pilih Skema</option>';

                dataSkema.forEach(items => {
                    if (items.status_skema == 1) {
                        listSkema += `<option value="${items.id}">${items.kode_program} (${items.nama_skema})</option>`;
                        jadwalSkema[items.id] = items.jadwal;
                        syaratSkema[items.id] = items.syarat;
                        syaratKhusus[items.id] = items.ketua_jabfung
                    }

                });
                if (ada) {
                    const swallInstance = this.$swal({
                        title: "Pilih Skema",
                        width: '40em',
                        showCancelButton: true,
                        showConfirmButton: true,
                        html: `<select id="skemaSelect" class="swal2-select mb-3">${listSkema}</select><div class="alert alert-primary" role="alert"><h3>Periode Usulan Aktif : ${this.dataPeriode.periode}</h3><div id="jadwalSkema">Mulai: - Berakhir : -</div>
                    <h3 id="countdown">00 D : 00 H : 00 M : 00 S</h3></div>
                    <h4>List Syarat Skema</h4>
                    <div id="selectedValue" class=""></div>`
                    })

                    swallInstance.then(result => {
                        if (result.isConfirmed) {
                            const val = document.querySelector('.swal2-select').value;
                            if (val && jadwalSkema[val] && this.isWithinTimeFrame(jadwalSkema[val])) {
                                return this.$router.push({ name: 'submited-penelitian-add', params: { id: val } })
                            } else {
                                this.$swal({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Action Tidak Dapat Dilakukan, Portal Sudah Ditutup Atau Belum Dibuka Hubungi Admin",
                                });
                            }
                        }


                    })


                    const selectElement = document.querySelector('.swal2-select');
                    const resultDisplay = document.getElementById('selectedValue');


                    selectElement.addEventListener('change', (event) => {

                        const selectedId = event.target.value;
                        const selectedValue = syaratSkema[selectedId];
                        const selectJadwal = jadwalSkema[selectedId]
                        const displayJadwal = document.getElementById('jadwalSkema')
                        const displayCount = document.getElementById('countdown')
                        const resultSyaratKhusus = this.checkingSyaratKhusus(syaratKhusus[selectedId])
                        let listSyarat = '';
                        listSyarat += `<li class=" p-0">Ketua Peneliti Jabfung wajib ${syaratKhusus[selectedId]}</li>`
                        selectedValue.forEach(list => {
                            listSyarat += `<li class=" p-0">${list.persyaratan}</li>`
                        })
                        if (selectJadwal) {
                            if (resultSyaratKhusus) {
                                this.$swal.resetValidationMessage()
                                this.$swal.enableButtons()
                            } else {
                                this.$swal.showValidationMessage(`Mohon Maaf Jabfung Anda Tidak Sesuai Dengan Persayaratan, JabFung Anda ${this.dosens.jabatan_fungsional}`)
                                this.$swal.disableButtons()

                            }


                            this.updateCountdown(selectJadwal.end, displayCount);
                            this.timer = setInterval(() => {
                                this.updateCountdown(selectJadwal.end, displayCount)
                            }, 1000);


                            displayJadwal.innerHTML = `<span class="fs-6 text">Mulai : ${selectJadwal.start}</span><span class="fs-6 text"> Berakhir : ${selectJadwal.end}</span>`
                        } else {

                            displayJadwal.innerHTML = `<span class="fs-6 text">Mulai : -</span><span class="fs-6 text"> Berakhir : -</span>`
                            clearInterval(this.timer);
                            displayCount.innerHTML = ''
                        }

                        resultDisplay.innerHTML = `<ol class=" mx-auto text-start  mt-2" style="width:25em">${listSyarat}</ol>`;
                    });

                } else {
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: "Maaf Anda Tidak Mengajukan Usulan Baru di Periode Ini Karena anda sudah menjadi ketua peneliti di skema lainnya",
                    });
                }

            } catch (error) {
                console.error(error);
            }
        },
        checkingSyaratKhusus(data) {
            // return this.dosens.jabatan_fungsional == data
            const datas = data.split(',').map(item => item.trim())
            return datas.includes(this.dosens.jabatan_fungsional)
        },
        updateCountdown(targetDate, html) {
            const now = moment();
            const target = moment(targetDate, 'YYYY-MM-DD HH:mm:ss');
            const diff = target.diff(now);

            if (diff > 0) {
                const duration = moment.duration(diff);
                const days = Math.floor(duration.asDays());
                const hours = duration.hours();
                const minutes = duration.minutes();
                const seconds = duration.seconds();

                return html.innerHTML = `${days} D : ${hours} H : ${minutes} M : ${seconds} S`;
            } else {
                clearInterval(this.timer);
                return html.innerHTML = ''
            }

        },
        goToFormSubmited(id) {
            $('#select-skema').modal('hide')
            return this.$router.push({ name: 'submited-penelitian-add', params: { id: id } })
        },
        async validasiKontrak(data) {
            const detailData = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
            </ul>
            `;
            if (data.status_pengajuan != "Terima") {
                this.$swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Action Tidak Dapat Dilakukan, Status masih " + data.status_pengajuan,
                });
            } else {
                if (data.kontrak == null) {
                    this.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: "Action Tidak Dapat Dilakukan, No Kontrak Belum Digenerate, Please Wait ",
                    });
                } else {
                    if (data.kontrak.pihak_dua != null) {
                        this.$swal({
                            icon: "error",
                            title: "Oops...",
                            text: "Anda Sudah Melakukan Validasi Kontrak",
                        });
                    } else {
                        const { value: values } = await this.$swal({
                            title: "Validasi Kontrak Usulan Penelitian",
                            input: "text",
                            html: detailData,
                            inputLabel: "Nomor Kontrak",
                            inputValue: data.kontrak == null ? '' : data.kontrak.no_kontrak,
                            inputAttributes: {
                                disabled: true
                            },
                            showCancelButton: true,
                            inputValidator: (value) => {
                                if (!value) {
                                    return "You need to write something!";
                                }
                            }
                        });
                        if (values) {
                            this.dataKontrak.id = data.id
                            this.dataKontrak.level = this.level
                            this.dataKontrak.no_kontrak = values
                            await this.axios.post('/api/createkontrak', this.dataKontrak).then(response => {
                                this.getDataUser()
                                console.log(response.data)
                            }).catch(error => {
                                console.log(error)
                            })
                        }
                    }

                }

            }

        },
        actionButtonLaporan(data) {
            let showed = true;

            const steps1 = data.progress.find(item => item.steps === 1);
            const steps2 = data.progress.find(item => item.steps === 2);
            const steps3 = data.progress.find(item => item.steps === 3);
            if (steps1.validasi == 'Terima' && steps2.validasi == 'Terima' && steps3.validasi == 'Terima') {
                showed = false
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                });
            }

            return showed
        },
        uploadLaporan(data) {
            const detailData = `
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Kode Usulan :</strong> <br><label class="text-muted lh-sm">${data.kode_skema}-${data.id}</label></li>
                    <li class="list-group-item"><strong>Nama Skema :</strong><br><label class="text-muted lh-sm">${data.nama_skema}</label></li>
                    <li class="list-group-item"><strong>Judul Usulan :</strong> <br><label class="text-muted lh-sm">${data.informasi.judul_penelitian}</label></li>
                </ul>
                 `;

            if (data.status_pengajuan !== 'Terima') {
                this.showStatusError('Oops...', `Action Tidak Dapat Dilakukan, Status masih ${data.status_pengajuan}`);
            } else {
                if (data.kontrak === null) {
                    this.showStatusError('Oops...', 'Action Tidak Dapat Dilakukan, No Kontrak Belum Digenerate, Please Wait');
                } else {
                    if (data.kontrak.pihak_dua !== null & data.kontrak.mengetahui != null) {
                        const steps1 = data.progress.find(item => item.steps === 1);
                        const steps2 = data.progress.find(item => item.steps === 2);
                        const steps3 = data.progress.find(item => item.steps === 3);
                        console.log(steps3)

                        if (this.shouldOpenForm1(steps1)) {
                            this.uploadlaporanStepsOne('Porgress', detailData, steps1, data.id)
                        } else if (this.shouldOpenForm2(steps1, steps2)) {
                            this.uploadlaporanStepsOne('Lap 75', detailData, steps2, data.id)
                        } else if (this.shouldOpenForm3(steps2, steps3)) {
                            this.uploadlaporanStepsOne('upload Akhir', detailData, steps3, data.id)
                        } else if (this.isOnValidationProcess(steps1, steps2, steps3)) {
                            this.showStatusError('Oops...', 'Mohon Maaf Status laporan anda Masih Dalam Proses Validasi');
                        } else if (this.isOnValidationRejected(steps1, steps2, steps3)) {
                            const rejected = data.progress.find(item => item.validasi === 'Tolak' && item.id_pengajuan == data.id)
                            this.uploadlaporanStepsOne(`Re-upload ${rejected.jenis_laporan}`, detailData, rejected, data.id)
                        } else if (!this.isWithinTimeFrame(steps1.times) || !this.isWithinTimeFrame(steps2.times) || !this.isWithinTimeFrame(steps3.times)) {
                            this.showStatusError('Oops...', 'Mohon Maaf Portal Upload Laporan Sudah Di Tutup');
                        }
                    } else if (data.kontrak.mengetahui == null) {
                        this.showStatusError('Oops...', 'Action Tidak Dapat Dilakukan, No Kontrak Belum di validasi direktur, Please Wait');
                    }else{
                        this.showStatusError('Oops...', 'Action Tidak Dapat Dilakukan, No Kontrak Belum di anda validasi, Please Wait');
                    }
                }
            }
        },

        // Fungsi untuk menampilkan pesan error
        showStatusError(title, text) {
            this.$swal({
                icon: 'error',
                title: title,
                text: text,
            });
        },

        // Fungsi untuk mengecek apakah form 1 harus dibuka
        shouldOpenForm1(steps1) {
            return steps1.file_progress === null && steps1.validasi === 'No Upload' && this.isWithinTimeFrame(steps1.times);
        },

        // Fungsi untuk mengecek apakah form 2 harus dibuka
        shouldOpenForm2(steps1, steps2) {
            return this.isWithinTimeFrame(steps2.times) && steps2.file_progress === null && steps2.validasi === 'No Upload' && steps1.validasi === 'Terima';
        },

        // Fungsi untuk mengecek apakah form 3 harus dibuka
        shouldOpenForm3(steps2, steps3) {
            return this.isWithinTimeFrame(steps2.times) && steps3.file_progress === null && steps3.validasi === 'No Upload' && steps2.validasi === 'Terima';
        },

        // Fungsi untuk mengecek apakah sedang dalam proses validasi
        isOnValidationProcess(steps1, steps2, steps3) {
            return steps1.validasi === 'prosess' || steps2.validasi === 'prosess' || steps3.validasi === 'prosess';
        },
        isOnValidationRejected(steps1, steps2, steps3) {
            return steps1.validasi === 'Tolak' || steps2.validasi === 'Tolak' || steps3.validasi === 'Tolak';
        },

        // Fungsi untuk mengecek apakah masih dalam waktu yang ditentukan
        isWithinTimeFrame(times) {
            const curentTime = moment().format('YYYY-MM-DD HH:mm:ss')
            console.log(curentTime+'>='+times.start+'&&'+curentTime+'<='+times.end)
            return curentTime >= times.start && curentTime <= times.end
            // Logika pengecekan waktu yang sesuai dengan kebutuhan Anda
            // Mengembalikan true jika dalam waktu yang ditentukan, atau false sebaliknya
        },

        async uploadlaporanStepsOne(title, detail, progress, id) {
            const { value: file } = await this.$swal({
                title: title,
                html: detail,
                inputLabel: `File Upload ${progress.jenis_laporan} pdf/docx`,
                input: "file",
                inputAttributes: {
                    'accept': '.pdf,.doc,.docx',
                    "aria-label": "Upload your profile picture"
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silahkan Upload File Terlebih dahulu'
                    }
                }
            });
            if (file) {
                const formData = new FormData()
                formData.append('file', file)
                formData.append('id_progress', progress.id)
                formData.append('id_pengajuan', id)
                formData.append('id_jenis_progress', progress.id_jenis_progress)

                await this.axios.post('/api/uploadprogress', formData, { headers: { "Content-Type": "multipart/form-data" } }).then(response => {
                    console.log(response.data)
                    this.getDataUser()
                }).catch(error => {
                    console.log()
                })


            }
        },
        async reUploadFile(id) {
            const { value: file } = await this.$swal({
                title: 'Re Upload File Usulan Proposal',
                inputLabel: `File Upload`,
                input: "file",
                inputAttributes: {
                    "aria-label": "Upload your File"
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silahkan Upload File Terlebih dahulu'
                    }
                }
            });
            if (file) {
                const formData = new FormData()
                formData.append('file', file)
                formData.append('id_pengajuan', id)

                await this.axios.post('/api/reuploadfile', formData, { headers: { "Content-Type": "multipart/form-data" } }).then(response => {
                    console.log(response.data)

                    if (response.data.code == 200) {
                        this.$swal({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been saved",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.getDataUser()
                    }
                }).catch(error => {
                    console.log()
                })


            }
        },
        timeFrameForm(times) {
            const curentTime = moment().format('YYYY-MM-DD HH:mm:ss')
            return curentTime >= times.start && curentTime <= times.end
        },
        async uploadFilePresentasi(id) {
            const { value: file } = await this.$swal({
                title: 'Upload File Presentasi',
                inputLabel: `File Upload File Presentasi`,
                input: "file",
                inputAttributes: {
                    "accept": "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                    "aria-label": "Upload your File Here"
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silahkan Upload File Terlebih dahulu'
                    }
                }
            });
            if (file) {
                const formData = new FormData()
                formData.append('file', file)
                formData.append('_method', 'patch')

                await this.axios.post('/api/uploadppt/' + id, formData, { headers: { "Content-Type": "multipart/form-data" } }).then(response => {
                    console.log(response.data)
                    this.getDataUser()
                }).catch(error => {
                    console.log()
                })


            }
        },
        async fetchDocxFile(data) {
            const ext = data.slice((data.lastIndexOf('.') - 1 >>> 0) + 2)
            if (ext == 'docx') {
                try {
                    // const response = await this.axios.get(`/api/filedocx/${data}`, { responseType: 'blob' });
                    // const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' });
                    // const docxOptions = Object.assign(docx.defaultOptions, {
                    //     debug: true,
                    //     experimental: true
                    // });
                    // this.docxFile = 'sample.docx'
                    // const container = document.querySelector("#container-file");
                    // docx.renderAsync(blob, container, null, docxOptions)
                    //     .then((x) => {
                    //         console.log(x);
                    //     });
                    // $('#previewFile').modal('show');
                    window.location.href = `/api/file/${data}`

                } catch (error) {
                    console.error('Error fetching docx:', error);
                }

            } else {
                try {
                    // const response = await this.axios.get(`/api/filepdf/${data}?data=surat-masuk`, { responseType: 'blob' });
                    // const blob = new Blob([response.data], { type: 'application/pdf' });
                    // this.pdfDocument = window.URL.createObjectURL(blob);
                    // $('#previewFile').modal('show');
                    window.location.href = `/api/file/${data}`
                } catch (error) {
                    console.error('Error fetching PDF:', error);
                }

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
        getFileExtension(filename = null) {
            if (filename != null) {
                const ext = filename.slice((filename.lastIndexOf('.') - 1 >>> 0) + 2)
                if (ext == 'docx') {
                    return 'fa-file-word'
                } else if (ext == 'pdf') {
                    return 'fa-file-pdf'
                }
            }

        },
        closeAndclear() {
            this.docxFile = null
            this.pdfDocument = null
            $('#previewFile').modal('hide');
        },
        showInfo(info) {
            this.$swal({
                title: "<strong>Alasan Penolakan</strong>",
                icon: "info",
                html: info,
                showConfirmButton: false,
                showCloseButton: false,
                showCancelButton: true,
                cancelButtonText: `Tutup`,
            });
        }

    }
}
</script>

<style scoped>
tr>th,
td {
    font-size: 14px;
}

i.files:hover {
    cursor: pointer;
}

@media (min-width: 992px) {
    .modal-lg {
        max-width: 60%;
    }
}
</style>