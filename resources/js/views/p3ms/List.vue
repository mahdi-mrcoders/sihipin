
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
                    <div class="card-header bg-primary">
                        <nav class="">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Data Usulan Proposal</button>
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                    aria-selected="false">Usulan Hasil Review</button>
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Laporan Usulan Proposal</button>
                                <button class="nav-link" id="nav-jadwal-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-jadwal" type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false" @click="showTabJadwal">Setting Jadwal Usulan</button>
                                <button class="nav-link" id="nav-laporan-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-laporan" type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false" @click="showTabJadwalLaporan">Setting Jadwal Upload Laporan</button>
                            </div>
                        </nav>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0 border-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <TableDataUsulan></TableDataUsulan>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <TableHasilReview></TableHasilReview>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <TableDataLaporan></TableDataLaporan>
                            </div>
                            <div class="tab-pane fade" id="nav-jadwal" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <TableJadwalUsulan :clicked="isClicked"></TableJadwalUsulan>
                            </div>
                            <div class="tab-pane fade" id="nav-laporan" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <TableJadwalLaporan :clicked="isClickedLaporan"></TableJadwalLaporan>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <router-view></router-view>
</template>
<script>
import TableDataUsulan from './TableDataUsulan'
import TableHasilReview from './TableHasilReview'
import TableDataLaporan from './TableDataLaporan'
import TableJadwalUsulan from './TableJadwalUsulan'
import TableJadwalLaporan from './TableJadwalLaporan'

export default {
    components: { TableDataUsulan, TableHasilReview, TableDataLaporan,TableJadwalUsulan,TableJadwalLaporan },
    data() {
        return {
            isClicked: false,
            isClickedLaporan: false,
        }
    },
    created() {

    },
    methods:{
        showTabJadwal(){
            this.isClicked=true
        },
        showTabJadwalLaporan(){
            this.isClickedLaporan=true
        }
    }

}
</script>
