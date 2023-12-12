<template>
    <Logins v-if="this.$route.name == 'login'"></Logins>
    <Mains v-else></Mains>    
</template>

<script>
import Mains from "./layouts/Mains.vue"
import Logins from "./views/Login.vue"
export default {
    components:{
        Mains,
        Logins
    },
   
}
</script>