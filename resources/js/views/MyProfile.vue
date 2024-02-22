<template>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5 w-75"
                        :src="profile.foto == null ? '/assets/images/profile.jpg' : profile.foto" @click="changeFoto">
                    <span class="font-weight-bold"> {{ profile.nama }} </span>
                    <span class="text-black-50">{{ profile.email }}</span>
                    <span></span>
                </div>
            </div>
            <div class="col-md-9 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Nama Lengkap </label>
                            <input type="text" class="form-control" placeholder="first name" v-model="profile.nama">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">NRP </label>
                            <input type="text" class="form-control" placeholder="first name" v-model="profile.nrp">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">NIDN </label>
                            <input type="text" class="form-control" placeholder="first name" v-model="profile.nidn">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="labels">Program Studi</label>
                            <input type="text" class="form-control" placeholder="enter phone number" v-model="profile.prodi"
                                readonly @click="setProdi(profile.prodi)">
                        </div>
                        <div class="col-md-4">
                            <label class="labels">Jabatan Fungsional</label>
                            <input type="text" class="form-control" placeholder="enter phone number"
                                v-model="profile.jabatan_fungsional" readonly
                                @click="setJabfung(profile.jabatan_fungsional)">
                        </div>
                        <div class="col-md-4">
                            <label class="labels">Pangkat / Golongan</label>
                            <input type="text" class="form-control" placeholder="enter phone number"
                                v-model="profile.pangkat_golongan" readonly @click="setGolPang(profile.pangkat_golongan)">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">No HP</label>
                            <input type="text" class="form-control" placeholder="country" v-model="profile.no_hp">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Email</label>
                            <input type="text" class="form-control" v-model="profile.email" placeholder="state" readonly>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button me-1" type="button" @click="update">Update
                            Profile</button>
                        <button class="btn btn-warning profile-button" type="button">Update Password</button>
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
            profile: {},
            user: {},
            uuid: localStorage.getItem('uuid')
        }
    },
    created() {
        this.getDataUser()
    },
    methods: {
        async getDataUser() {
            await this.axios.get(`/api/pengguna/${this.uuid}`).then(response => {
                this.user = response.data
                this.getDataDosen(response.data.email_dosen)
            }).catch(error => {
                console.log(error)
            })

        },
        async getDataDosen(email) {
            await this.axios.get(`/api/dosen/byemail/${email}`).then(responses => {
                this.profile = responses.data
                if(responses.data.foto != null){
                    this.profile.foto = `/storage/${responses.data.foto}`
                }
                
            }).catch(error => {
                console.log(error)
            })
        },
        async setProdi(prodi) {
            const { value: fruit } = await this.$swal({
                title: "Pilih Program Studi Anda",
                input: "select",
                inputValue: prodi,
                inputOptions: {
                    TPS: 'TPS',
                    PPM: 'PPM',
                    TIF: 'TIF',
                    ABI: 'ABI',
                    TPKS: 'TPKS'
                },
                inputPlaceholder: "Select a fruit",
                showCancelButton: true,
                inputValidator: (value) => {
                    if (value === " ") {
                        return 'pilih salah satu prodi'
                    }
                }
            });
            if (fruit) {
                this.profile.prodi = fruit
            }
        },
        async setJabfung(jabfung) {
            try {
                const response = await this.axios.get('/api/datajabfung')
                const optionJabfung = {}
                response.data.forEach(item => {
                    optionJabfung[item.nama_jabfung] = item.nama_jabfung
                });
                const { value: fruit } = await this.$swal({
                    title: "Pilih Program Jabfung Anda",
                    input: "select",
                    inputValue: jabfung,
                    inputOptions: optionJabfung,
                    inputPlaceholder: "Pilih Jabatan Fungsional",
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (value === " ") {
                            return 'pilih salah satu'
                        }
                    }
                });
                if (fruit) {
                    this.profile.jabatan_fungsional = fruit
                }
            } catch (error) {

            }

        },
        async setGolPang(golpang) {
            try {
                const response = await this.axios.get('/api/datagolpang')
                const optiongolpang = {}
                
                response.data.forEach(item => {
                    optiongolpang[item.nama_pangkat] = item.nama_pangkat
                });
                const { value: fruit } = await this.$swal({
                    title: "Pilih Program Golongan Pangkat Anda",
                    input: "select",
                    inputValue: golpang,
                    inputOptions: optiongolpang,
                    inputPlaceholder: "Pilih Jabatan Fungsional",
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (value === " ") {
                            return 'pilih salah satu'
                        }
                    }
                });
                if (fruit) {
                    this.profile.pangkat_golongan = fruit
                }
            } catch (error) {

            }
        },
        async update() {
            this.profile._method = 'patch'
            this.axios.post(`/api/datadosen/${this.profile.id}`, this.profile).then(response => {
                this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    this.$router.go()
                })
            }).catch(error => {
                console.log(error)
            })
        },
        async changeFoto() {
            const { value: file } = await this.$swal({
                title: "Select image",
                input: "file",
                inputAttributes: {
                    "accept": "image/*",
                    "aria-label": "Upload your profile picture"
                },
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return "You need to upload foto!";
                    }
                }
            });
            if (file) {
                console.log(file)
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.$swal({
                        title: "Your uploaded picture",
                        imageUrl: e.target.result,
                        imageAlt: "The uploaded picture",
                        showDenyButton: true
                    }).then(result => {
                        if (result.isDenied) {
                            this.changeFoto()
                        }
                        if (result.isConfirmed) {
                            const formData = new FormData()
                            formData.append('file', file)
                            formData.append('_method', 'patch')

                            this.axios.post(`/api/dosenfoto/${this.profile.id}`, formData, { headers: { "Content-Type": "multipart/form-data" } }).then(response => {
                                this.$router.go()
                            }).catch(error => {
                                console.log()
                            })
                        }
                    })
                };
                reader.readAsDataURL(file);
            }
        }
    }

}
</script>