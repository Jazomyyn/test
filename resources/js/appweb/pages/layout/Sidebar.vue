<template>
    <div>
        <v-app-bar src="https://picsum.photos/1920/1080?random" dark>
            <template v-slot:img="{ props }">
                <v-img
                    v-bind="props"
                    gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
                ></v-img>
            </template>
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

            <v-toolbar-title class="fw-900"
                >Prueba técnica - Jeniffer Jazmyn Flores
                Desales</v-toolbar-title
            >
            <v-spacer></v-spacer>
            <v-btn
                class="mx-2"
                fab
                dark
                small
                color="#2B4981"
                :to="{ name: 'home' }"
            >
                <v-icon dark> mdi-home </v-icon>
            </v-btn>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            absolute
            temporary
            class="st-side"
        >
            <v-list-item class="bg-blue-dark py-10">
                <v-list-item-content class="text-white fw-700">
                    <v-list-item-title class="text-h6">
                        Administrador
                    </v-list-item-title>
                    <v-list-item-subtitle class="text-white fw-500 mt-3">
                        <div>Secciones que se pueden</div>
                        <div>administrar</div>
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>
            <v-list nav rounded class="pt-0">
                <v-list-item-group
                    v-model="group"
                    active-class="deep-purple--text text--accent-4"
                >
                    <v-list-item
                        link
                        class="my-5"
                        :key="index"
                        :to="item.path"
                        v-for="(item, index) in items"
                        onclick="window.scrollTo(0,0)"
                    >
                        <v-list-item-icon class="pointer">
                            <v-icon color="#2B4981">{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title
                                class="fw-900 fz-lg txt-blue-dark"
                            >
                                {{ item.name }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                <v-divider class="mt-16"></v-divider>
                <v-btn
                    class="mx-2 mt-10"
                    color="#2B4981"
                    text
                    :to="{ name: 'home' }"
                >
                    Ir al inicio
                </v-btn>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    data: () => ({
        drawer: false,
        group: null,
        items: [
            {
                icon: "mdi-bookmark-multiple-outline",
                name: "Categorías",
                path: { name: "categories" },
            },
            {
                icon: "mdi-ballot-outline",
                name: "Actividades",
                path: { name: "activities" },
            },
            {
                icon: "mdi-clipboard-text-clock-outline",
                name: "Reservaciones",
                path: { name: "reservations" },
            },
        ],
    }),
};
</script>

<style scoped></style>
