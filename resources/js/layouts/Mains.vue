<template>
    <div class="container-scroller">
        <div class="horizontal-menu" >
            <Headers></Headers>
            <Navigatios></Navigatios>

        </div>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <router-view></router-view>

                <footer class="footer">
                    <div class="footer-wrap">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a
                                    href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a
                                    href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a>
                                templates</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import Headers from "./Headers.vue"
import Navigatios from "./Navigations.vue"
export default {
    components:{
        Headers,
        Navigatios
    },
    data() {
        return {
            stateLayout: true,
            loggedIn: localStorage.getItem('loggedIn'),
            uuid: localStorage.getItem('uuid'),
        }
    },
    mounted(){
        if (!this.loggedIn) {
            return this.$router.push({ name: 'login' })
        }
    }
}
</script>