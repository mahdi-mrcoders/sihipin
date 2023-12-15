export const routes = [
    {
        name: "login",
        path: "/",
        meta: { layout: "Login" },
        component: () => import("./views/Login.vue"),
    },
    {
        name: "dashboard",
        path: "/dashboard",
        meta: { layout: "Panel" },
        title:'Dashboard',
        component: () => import("./views/Dashboard.vue"),
    },
    {
        name: "data-dosen",
        path: "/data-dosen",
        redirect: "/data-dosen",
        meta: { layout: "Panel" },
        title:'Data Dosen',
        children: [
            {
                name: "data-dosen",
                path: "/data-dosen",
                title:'Data Dosen',
                component: () => import("./views/data-dosen/Index.vue"),
            },
            {
                name: "data-dosen-add",
                path: "/data-dosen/add",
                title:'Form Tambah Data Dosen',
                component: () => import("./views/data-dosen/Add.vue"),
            },
            {
                name: "data-dosen-edit",
                path: "/data-dosen/:id/edit",
                title:'Form Ubah Data Dosen',
                component: () => import("./views/data-dosen/Edit.vue"),
            },
        ],
    },
    {
        name: "data-pengguna",
        path: "/data-pengguna",
        redirect: "/data-pengguna",
        children: [
            {
                name: "data-pengguna",
                path: "/data-pengguna",
                component: () => import("./views/data-pengguna/Index.vue"),
            },
            {
                name: "data-pengguna-add",
                path: "/data-pengguna/add",
                component: () => import("./views/data-pengguna/Add.vue"),
            },
            {
                name: "data-pengguna-edit",
                path: "/data-pengguna/:id/edit",
                component: () => import("./views/data-pengguna/Edit.vue"),
            },
        ],
    },
    {
        name: "data-usulan-proposal",
        path: "/data-usulan-proposal",
        redirect: "/data-usulan-proposal",
        children: [
            {
                name: "data-usulan-proposal",
                path: "/data-usulan-proposal",
                component: () => import("./views/p3ms/List.vue"),
            },
            {
                name: "data-pengguna-add",
                path: "/data-pengguna/add",
                component: () => import("./views/data-pengguna/Add.vue"),
            },
            {
                name: "data-pengguna-edit",
                path: "/data-pengguna/:id/edit",
                component: () => import("./views/data-pengguna/Edit.vue"),
            },
        ],
    },
    {
        name: "review-usulan-proposal",
        path: "/review-usulan-proposal",
        redirect: "/review-usulan-proposal",
        children: [
            {
                name: "reviw-usulan-proposal",
                path: "/review-usulan-proposal",
                component: () => import("./views/reviewers/List.vue"),
            },
            
        ],
    },
    {
        name: "data-skema",
        path: "/data-skema",
        redirect: "/data-skema",
        children: [
            {
                name: "data-skema",
                path: "/data-skema",
                component: () => import("./views/data-skema/Index.vue"),
            },
            {
                name: "data-skema-add",
                path: "/data-skema/add",
                component: () => import("./views/data-skema/Add.vue"),
            },
            {
                name: "data-skema-edit",
                path: "/data-skema/:id/edit",
                component: () => import("./views/data-skema/Edit.vue"),
            },
            {
                name: "submited-penelitian",
                path: "/skema/submited",
                component: () => import("./views/peneliti/ListSubmited.vue"),
            },
            {
                name: "submited-penelitian-add",
                path: "/skema/:id/submited",
                component: () => import("./views/peneliti/FormSubmited.vue"),
            },
            {
                name: "nilai-submited-penelitian",
                path: "/skema/:id/penilaian",
                component: () => import("./views/reviewers/FormPenilaian.vue"),
            },
            {
                name: "progress-submited-penelitian",
                path: "/skema/:id/uploadprogress",
                component: () =>
                    import("./views/peneliti/FormUploadProgress.vue"),
            },
        ],
    },
    {
        name: "laporan",
        path: "/laporan",
        component: () => import("./views/laporan/List"),
    },
    {
        name: "data-jabfung",
        path: "/data-jabfung",
        component: () => import("./views/jabfung/List"),
    },

    {
        name: "data golongan pangkat",
        path: "/data-golpangkat",
        component: () => import("./views/golpangkat/List"),
    },
    {
        name: "data periode",
        path: "/data-periode",
        component: () => import("./views/periode/List"),
    },
    {
        name: "Profile Saya",
        path: "/my-profile",
        component: () => import("./views/MyProfile"),
    },
    {
        name: "buku panduan",
        path: "/buku-panduan",
        component: () => import("./views/buku-panduan/View.vue"),
    },
    {
        name: "Informasi",
        path: "/informasi",
        component: () => import("./views/Informasi"),
    },
    {
        name: "Data Validasi Kontrak",
        path: "/validasi-submited",
        component: () => import("./views/direktur/List"),
    },

];
