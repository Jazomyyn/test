<template>
    <v-container fluid>
        <h2 class="text-center txt-blue-dark my-5 fw-900">
            {{ title }}
        </h2>

        <v-sheet
            class="mx-auto"
            elevation="8"
            v-show="activities !== null && !withCategory"
        >
            <v-slide-group
                v-model="model"
                class="pa-4"
                center-active
                show-arrows
            >
                <v-slide-item
                    v-for="activity in activities"
                    :key="activity.id"
                    v-slot="{ active, toggle }"
                >
                    <v-card
                        :color="active ? 'cyan lighten-2' : 'grey lighten-2'"
                        class="ma-4"
                        height="500"
                        width="400"
                        @click="toggle"
                    >
                        <v-row
                            class="fill-height h-500 px-5"
                            align="center"
                            justify="center"
                        >
                            <v-card-text>
                                <v-img
                                    :src="activity.image"
                                    height="200"
                                ></v-img>
                                <p class="fz-sm text-right">
                                    <span class="fw-200">Vigencia</span>
                                    {{ activity.init_date }} -
                                    {{ activity.finish_date }}
                                </p>
                                <div class="pt-2 mb-5">
                                    <v-row
                                        align="center"
                                        justify="center"
                                        dense
                                        no-gutters
                                    >
                                        <v-col
                                            v-for="n in activity.popularity"
                                            :key="n"
                                            class="text-center"
                                        >
                                            <v-icon color="yellow darken-3">{{
                                                "mdi-star"
                                            }}</v-icon>
                                        </v-col>
                                    </v-row>
                                </div>
                                <p class="fz-xxl">
                                    {{ activity.title }}
                                </p>
                                <p class="fz-lg">
                                    {{ activity.format_total }} por persona
                                </p>
                            </v-card-text>
                            <v-card-actions>
                                <v-row no-gutters>
                                    <v-col cols="6" class="text-left">
                                        <v-btn
                                            class="ms-5"
                                            dark
                                            color="purple"
                                            @click="reveal = true"
                                        >
                                            Detalles
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <form-reservation
                                            :data="activity"
                                        ></form-reservation>
                                    </v-col>
                                </v-row>
                            </v-card-actions>

                            <v-expand-transition>
                                <v-card
                                    v-if="reveal"
                                    class="transition-fast-in-fast-out v-card--reveal"
                                >
                                    <v-card-text class="pb-0 h-455">
                                        <p class="fz-lg fw-600">Detalles</p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Nombre:</span
                                            >
                                            <span class="text-dark">{{
                                                activity.title
                                            }}</span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Descripción:</span
                                            >
                                            <span class="text-dark">{{
                                                activity.description
                                            }}</span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Vigencia:</span
                                            >
                                            <span class="text-dark">
                                                {{ activity.init_date }} -
                                                {{ activity.finish_date }}
                                            </span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Precio:</span
                                            >
                                            <span class="text-dark"
                                                >{{ activity.format_total }} por
                                                persona</span
                                            >
                                        </p>
                                        <p
                                            class="fz-md"
                                            v-show="
                                                activity.activities_items
                                                    .length > 0
                                            "
                                        >
                                            <span class="txt-blue-dark fw-800"
                                                >Actividades incluidas:</span
                                            >
                                        </p>
                                        <ul
                                            v-show="
                                                activity.activities_items
                                                    .length > 0
                                            "
                                        >
                                            <li
                                                v-for="item in activity.activities_items"
                                                :key="item.id"
                                            >
                                                {{ item.item.name }}
                                            </li>
                                        </ul>
                                    </v-card-text>
                                    <v-card-actions class="pt-0">
                                        <v-row no-gutters>
                                            <v-col cols="6" class="text-left">
                                                <v-btn
                                                    text
                                                    color="purple"
                                                    @click="reveal = false"
                                                >
                                                    Regresar
                                                </v-btn>
                                            </v-col>
                                            <v-col cols="6" class="text-right">
                                                <form-reservation
                                                    :data="activity"
                                                ></form-reservation>
                                            </v-col>
                                        </v-row>
                                    </v-card-actions>
                                </v-card>
                            </v-expand-transition>
                        </v-row>
                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-sheet>
        <v-sheet
            class="mx-auto"
            elevation="8"
            v-show="activities !== null && withCategory"
        >
            <v-slide-group
                v-model="model"
                class="pa-4"
                center-active
                show-arrows
            >
                <v-slide-item
                    v-for="activity in activities"
                    :key="activity.id"
                    v-slot="{ active, toggle }"
                    v-show="activity.category.id === idCategory"
                >
                    <v-card
                        :color="active ? 'cyan lighten-2' : 'grey lighten-2'"
                        class="ma-4"
                        height="500"
                        width="400"
                        @click="toggle"
                    >
                        <v-row
                            class="fill-height h-500 px-5"
                            align="center"
                            justify="center"
                        >
                            <v-card-text>
                                <v-img
                                    :src="activity.image"
                                    height="200"
                                ></v-img>
                                <p class="fz-sm text-right">
                                    <span class="fw-200">Vigencia</span>
                                    {{ activity.init_date }} -
                                    {{ activity.finish_date }}
                                </p>
                                <div class="pt-2 mb-5">
                                    <v-row
                                        align="center"
                                        justify="center"
                                        dense
                                        no-gutters
                                    >
                                        <v-col
                                            v-for="n in activity.popularity"
                                            :key="n"
                                            class="text-center"
                                        >
                                            <v-icon color="yellow darken-3">{{
                                                "mdi-star"
                                            }}</v-icon>
                                        </v-col>
                                    </v-row>
                                </div>
                                <p class="fz-xxl">
                                    {{ activity.title }}
                                </p>
                                <p class="fz-lg">
                                    {{ activity.format_total }} por persona
                                </p>
                            </v-card-text>
                            <v-card-actions>
                                <v-row no-gutters>
                                    <v-col cols="6" class="text-left">
                                        <v-btn
                                            class="ms-5"
                                            dark
                                            color="purple"
                                            @click="reveal = true"
                                        >
                                            Detalles
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <form-reservation
                                            :data="activity"
                                        ></form-reservation>
                                    </v-col>
                                </v-row>
                            </v-card-actions>

                            <v-expand-transition>
                                <v-card
                                    v-if="reveal"
                                    class="transition-fast-in-fast-out v-card--reveal"
                                    style="height: 100% !important"
                                >
                                    <v-card-text class="pb-0 h-455">
                                        <p class="fz-lg fw-600">Detalles</p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Nombre:</span
                                            >
                                            <span class="text-dark">{{
                                                activity.title
                                            }}</span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Descripción:</span
                                            >
                                            <span class="text-dark">{{
                                                activity.description
                                            }}</span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Vigencia:</span
                                            >
                                            <span class="text-dark">
                                                {{ activity.init_date }} -
                                                {{ activity.finish_date }}
                                            </span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Precio:</span
                                            >
                                            <span class="text-dark"
                                                >{{ activity.format_total }} por
                                                persona</span
                                            >
                                        </p>
                                        <p
                                            class="fz-md"
                                            v-show="
                                                activity.activities_items
                                                    .length > 0
                                            "
                                        >
                                            <span class="txt-blue-dark fw-800"
                                                >Actividades incluidas:</span
                                            >
                                        </p>
                                        <ul
                                            v-show="
                                                activity.activities_items
                                                    .length > 0
                                            "
                                        >
                                            <li
                                                v-for="item in activity.activities_items"
                                                :key="item.id"
                                            >
                                                {{ item.item.name }}
                                            </li>
                                        </ul>
                                    </v-card-text>
                                    <v-card-actions class="pt-0">
                                        <v-row no-gutters>
                                            <v-col cols="6" class="text-left">
                                                <v-btn
                                                    text
                                                    color="purple"
                                                    @click="reveal = false"
                                                >
                                                    Regresar
                                                </v-btn>
                                            </v-col>
                                            <v-col cols="6" class="text-right">
                                                <form-reservation
                                                    :data="activity"
                                                ></form-reservation>
                                            </v-col>
                                        </v-row>
                                    </v-card-actions>
                                </v-card>
                            </v-expand-transition>
                        </v-row>
                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-sheet>
        <v-container
            class="text-center txt-blue mb-10"
            v-show="activities === null"
        >
            <h3>No hay actividades</h3>
        </v-container>
    </v-container>
</template>

<script>
import FormReservation from "../../components/reservation/FormReservation";
export default {
    name: "AllActivities",
    components: { FormReservation },
    props: {
        activities: {
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        withCategory: {
            type: Boolean,
            default: false,
        },
        idCategory: {
            type: Number,
            required: false,
        },
    },
    data() {
        return {
            model: null,
            reveal: false,
        };
    },
};
</script>

<style scoped>
.v-card--reveal {
    bottom: 0;
    opacity: 1 !important;
    position: absolute;
    width: 100%;
}
</style>
