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
            <button
              class="btn btn-sm btn-icon-text btn-primary"
              @click="newSubmited"
              v-show="level == 3 ? true : false"
            >
              New Submited
            </button>

            <hr />
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th style="width: 5%">File</th>
                  <th>Tanggal Submit</th>
                  <th>Nama Skema Judul Penelitain/PKM</th>
                  <th>Ketua Peneliti Anggota</th>
                  <th>Status Pengajuan</th>
                  <th>Hasil Review</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(list, index) in tableList" :key="list.id">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <i
                      class="fa-regular fa-file-word fa-lg me-1 cursor-pointer"
                      @click="fetchFile(list.file_proposal)"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="`File Proposal : ${list.file_proposal}`"
                    ></i>
                    <i
                      class="fa-regular fa-file-powerpoint fa-lg me-1 cursor-pointer"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="`File Pptx :${list.file_presentasi}`"
                      @click="fetchPptFile(list.file_presentasi)"
                      v-show="list.file_presentasi != null ? true : false"
                    ></i>
                  </td>
                  <td>{{ list.created_at }}</td>
                  <td>
                    {{ list.nama_skema }}<br />{{ list.informasi.judul_penelitian }}
                  </td>
                  <td>
                    {{ list.ketua_peneliti }}<br />
                    <span
                      v-for="(anggota, anggotaIndex) in list.anggota"
                      :key="anggota.id"
                    >
                      {{ anggota.nama_anggota }}
                      <span v-if="anggotaIndex !== list.anggota.length - 1">, </span>
                    </span>
                  </td>
                  <td>
                    <label class="badge bg-danger" v-if="list.status_pengajuan == 'Tolak'"
                      >Tolak</label
                    >
                    <label
                      class="badge bg-warning"
                      v-if="list.status_pengajuan == 'Prosess'"
                      >Proses</label
                    >
                    <label
                      class="badge bg-warning"
                      v-if="list.status_pengajuan == 'In Review'"
                      >In Review</label
                    >
                    <label
                      class="badge bg-success"
                      v-if="list.status_pengajuan == 'Terima'"
                      >Terima</label
                    >
                  </td>
                  <td>
                    <ul style="list-style: none; padding-left: 0">
                      <li
                        v-for="(nilai, nums) in list.datanilai"
                        :key="nilai.id"
                        style="font-size: 12px"
                      >
                        <span style="font-size: 10px">
                          {{ nameReviewer(list.reviewer, nilai.id_reviewer) }}
                          <span class="badge d-block" :class="nilai.hasil_review == 1 || nilai.hasil_review == 2 ? 'bg-success':'bg-danger'"> {{ statusReview(nilai.hasil_review) }} : {{ nilai.total_nilai }}</span>
                        </span>
                        
                        <!-- <span v-if="nilai.hasil_review == 1" class="badge bg-success"
                          >{{ nameReviewer(list.reviewer, nilai.id_reviewer) }} <br />
                          Terima : {{ nilai.total_nilai }}</span
                        >
                        <span v-if="nilai.hasil_review == 2" class="badge bg-success"
                          >{{ nameReviewer(list.reviewer, nilai.id_reviewer) }} <br />
                          Terima/Revisi : {{ nilai.total_nilai }}</span
                        >
                        <span v-if="nilai.hasil_review == 3" class="badge bg-danger"
                          >{{ nameReviewer(list.reviewer, nilai.id_reviewer) }}
                          <br />Tolak : {{ nilai.total_nilai }}</span
                        > -->
                      </li>
                      <li style="font-size: 12px">
                        Total : {{ totalNilai(list.datanilai) }}
                      </li>
                    </ul>
                  </td>
                  <td v-if="list.status_pemenang == 'In Review'">
                    <router-link
                      class="badge bg-info"
                      :to="{ name: 'nilai-submited-penelitian', params: { id: list.id } }"
                      >Lakukan Penilaian</router-link
                    >
                  </td>
                  <td v-else>selesai</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <router-view></router-view>
</template>
<script>
export default {
  data() {
    return {
      tableList: {},
      level: localStorage.getItem("level"),
      uuid: localStorage.getItem("uuid"),
      idsn: null,
      listSkema: {},
      selectSkema: "",
      datatPenelitian: null,
      isClicked: false,
      dataList: {},
      dataValidasi: {},
      dataKontrak: {},
      stateFormKontrak: false,
    };
  },
  created() {
    this.getDataUser();
    // this.getListSkema()
  },
  methods: {
    statusReview(hasil){
        return (hasil == 1 ? 'Terima':(hasil == 2 ? 'Terima/Revisi':'Tolak'))
    },
    nameReviewer(reviewers, id_reviewer) {
      const name = reviewers.find((reviewer) => reviewer.id === id_reviewer);
      return name.nama_reviewer;
    },
    ResultState(result) {
      this.isClicked = false;
      this.tableList = {};
      this.$router.go(0);
    },
    async getDataUser() {
      await this.axios
        .get(`/api/pengguna/${this.uuid}`)
        .then((response) => {
          this.getDataDosen(response.data.email_dosen);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getDataDosen(email) {
      await this.axios
        .get(`/api/dosen/byemail/${email}`)
        .then((responses) => {
          this.idsn = responses.data.id;
          this.getListSubmited();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getListSubmited() {
      try {
        await this.axios
          .get(`/api/penelitian?level=${this.level}&idsn=${this.idsn}`)
          .then((response) => {
            this.tableList = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      } catch (error) {}
    },
    totalNilai(data) {
      if (data && data.length > 0 && data[0].total_nilai !== undefined) {
        const sum = data.reduce(
          (accumulator, currentValue) => accumulator + currentValue.total_nilai,
          0
        );
        return sum / 2;
      }
      return "N/A";
    },
    async fetchDocxFile(data) {
      try {
        const response = await this.axios.get(`/api/filedocx/${data}`, {
          responseType: "blob",
        });
        const blob = new Blob([response.data], {
          type: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        });
        const docxOptions = Object.assign(docx.defaultOptions, {
          debug: true,
          experimental: true,
        });
        const container = document.querySelector("#container-file");
        const files = window.URL.createObjectURL(blob);
        docx.renderAsync(blob, container, null, docxOptions).then((x) => {
          console.log(x);
        });
        $("#previewFile").modal("show");
      } catch (error) {
        console.error("Error fetching PDF:", error);
      }
    },
    async fetchPptFile(filename) {
      try {
        const response = await this.axios.get(`/api/fileppt/${filename}`, {
          responseType: "blob",
        });
        const blob = new Blob([response.data], {
          type:
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        });
        // this.pdfDocument = ;
        // window.URL.createObjectURL()
        window.location.href = `/api/fileppt/${filename}`;
        // $('#previewFile').modal('show');
      } catch (error) {
        console.error("Error fetching docx:", error);
      }
    },
    async fetchFile(filename) {
      try {
        window.location.href = `/api/file/${filename}`;
        // $('#previewFile').modal('show');
      } catch (error) {
        console.error("Error fetching docx:", error);
      }
    },
  },
};
</script>
<style scoped>
tr > th,
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
