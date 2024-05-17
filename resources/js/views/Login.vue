<template>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-lg-flex d-sm-flex d-flex align-items-center justify-content-center"
                        id="card-login">
                        <div class="auth-form-transparent text-left p-3 mt-1 w-75">
                            <div class="mb-3 d-lg-none d-sm-block">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#"
                                            @click="showFormLogin">Login</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" @click="showInformation">Informasi</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="brand-logo mt-5 ">
                                <img src="/assets/images/logop3m.png" alt="logo" class="mx-auto d-block">
                            </div>
                            <h4 class="text-center">Welcome back To!</h4>
                            <h6 class="font-weight-light text-center">SIPMA POLITEKNIK KAMPAR</h6>
                            <form class="pt-3" @submit.prevent="sigins">
                                <div class="form-group">
                                    <label for="exampleInputEmail">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg border-left-0"
                                            id="exampleInputEmail" placeholder="Username" v-model="dataForm.email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg border-left-0"
                                            id="exampleInputPassword" placeholder="Password"
                                            v-model="dataForm.password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-flex d-flex flex-column flex-grow bg-light pt-2 pb-2"
                        id="card-informasi">
                        <div class="mb-3 d-lg-none d-sm-block">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="#" @click="showFormLogin">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" @click="showInformation">Informasi</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card text-dark h-100  bg-ligh w-100">
                            <div class="card-header text-center">INFORMATION</div>
                            <div class="card-body" v-html="dataForm.informasi">

                            </div>
                            <div class="card-footer">
                                <p class="text-dark font-weight-medium text-center align-self-end">Copyright
                                    &copy; 2021
                                    All rights reserved.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <div class="modal fade" id="maintane" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body d-flex justify-content-center ">
                    <div class="misc-wrapper align-self-center text-center">
                        <h2 class="mb-2 mx-2">Under Maintenance!</h2>
                        <p class="mb-4 mx-2">
                            Sorry for the inconvenience but we're performing some maintenance at the moment
                        </p>
                        <div class="mt-4">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/img/illustrations/girl-doing-yoga-light.png"
                                alt="girl-doing-yoga-light" width="500" class="img-fluid"
                                data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                                data-app-light-img="illustrations/girl-doing-yoga-light.png">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
var elmLogin = $('#card-login')
var elmInformasi = $('#card-informasi')
export default {
    name: 'login',
    data() {
        return {
            dataForm: {},
            loggedIn: localStorage.getItem("loggedIn"),
            uuid: localStorage.getItem("uuid"),
            level: localStorage.getItem("level"),
            loginFailed: null,
            dataForm: {}

        }
    },
    created() {
        this.getDataInformasi()
    },
    methods: {
        async getDataInformasi() {
            const response = await this.axios.get('/api/informasi')
            this.dataForm = response.data[0]
        },
        showFormLogin() {
            console.log('show form login')
            $('#card-login').removeClass('d-none');
            $('#card-informasi').addClass('d-none')

        },
        showInformation() {
            console.log('show informasi')
            $('#card-informasi').removeClass('d-none');
            $('#card-login').addClass('d-none')

        },
        async sigins() {
            await this.axios.post('/api/login', this.dataForm).then(response => {
                if (response.data.login) {
                    localStorage.setItem("loggedIn", "true");
                    localStorage.setItem("uuid", response.data.uuid);
                    localStorage.setItem("level", response.data.level);
                    this.loggedIn = true;
                    this.$router.push({ name: 'dashboard' })
                } else {
                    this.loginFailed = false
                    this.$swal(
                        'Login',
                        'email atau password salah',
                        'error'
                    )
                }

            }).catch(error => {
                console.log(error)
            })
        }
    },
    mounted() {
        var myModal = new bootstrap.Modal(document.getElementById('maintane'))
        myModal.show();
        if (this.loggedIn) {
            this.$router.push({ name: 'dashboard' })
        }
    }
}
</script>