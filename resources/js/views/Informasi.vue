<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <h3 class="text-dark font-weight-bold text-capitalize">{{ this.$route.name }}</h3>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" v-show="level == 1 ? true : false">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" @submit.prevent="create">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Informasi</label>
                                <Editor api-key="njzovfhmb3vks8j71rythikqice89ysip4eh41v9fln6sjjw"
                                    v-model="dataForm.informasi" :init="{
                                        toolbar_mode: 'sliding',
                                        height: 600,
                                        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen',
                                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | fullscreen',
                                    }"/>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" v-show="level == 2 || level == 3 ? true : false">
                <div v-html="dataForm.informasi"></div>
            </div>

        </div>
    </div>
</template>
<script>
import Editor from '@tinymce/tinymce-vue'
export default {
    components: { Editor },
    data() {
        return {
            dataForm: {
                id: '',
                informasi: '',
                
            },
            level: localStorage.getItem("level")
        }
    },
    created() {
        this.getDataInformasi()
    },
    methods: {
        async getDataInformasi() {
            const response = await this.axios.get('/api/informasi')
            console.log(response.data)
            this.dataForm = response.data[0]
        },
        async create() {
            if (this.dataForm.id == '') {
                const response = await this.axios.post('/api/informasi', this.dataForm)
                if (response.status == 200) {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getDataInformasi()
                    })
                } else {
                    console.log(response)
                }

            } else {
                this.dataForm._method = 'patch'
                const response = await this.axios.post('/api/informasi/' + this.dataForm.id, this.dataForm)
                if (response.status == 200) {
                    this.$swal({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.getDataInformasi()
                    })

                } else {
                    console.log(response)
                }
            }

        }
    }
}
</script>