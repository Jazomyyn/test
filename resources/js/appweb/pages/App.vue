<template>
    <v-app class="bg-body">
        <div>
            <sidebar></sidebar>
            <transition>
                <router-view></router-view>
            </transition>
            <Footer></Footer>
        </div>
    </v-app>
</template>

<script>
import Sidebar from "./layout/Sidebar";
import Footer from "./layout/Footer";
export default {
    name: "App",
    components: { Sidebar, Footer },
};
</script>

<style scoped></style>
