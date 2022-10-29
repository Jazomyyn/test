<template>
    <v-container fluid class="mb-16">
        <h2 class="text-center txt-blue-dark mt-5 fw-900">
            {{ title }}
        </h2>

        <v-sheet class="mx-auto" elevation="8" v-if="activities !== null">
            <v-slide-group v-model="model" class="pa-4" center-active>
                <v-slide-item
                    v-for="activity in activities"
                    :key="activity.activity.id"
                    v-slot="{ active, toggle }"
                >
                    <v-card
                        :color="active ? 'cyan lighten-2' : 'grey lighten-2'"
                        class="ma-4 w-min scroll-card"
                        @click="toggle"
                    >
                        <v-row
                            class="fill-height h-500 px-5"
                            align="center"
                            justify="center"
                        >
                            <v-card-text>
                                <v-img
                                    :src="activity.activity.image"
                                    height="200"
                                ></v-img>
                                <p class="fz-sm text-right">
                                    <span class="fw-200">Vigencia</span>
                                    {{ activity.activity.init_date }} -
                                    {{ activity.activity.finish_date }}
                                </p>
                                <div class="pt-2 mb-5">
                                    <v-row
                                        align="center"
                                        justify="center"
                                        dense
                                        no-gutters
                                    >
                                        <v-col
                                            v-for="n in activity.activity
                                                .popularity"
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
                                    {{ activity.activity.title }}
                                </p>
                                <p class="fz-lg">
                                    {{ activity.price_total | money }} /
                                    {{ persons + " personas" }}
                                </p>
                            </v-card-text>
                            <v-card-actions>
                                <v-row no-gutters>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        class="text-center text-md-left"
                                    >
                                        <v-btn
                                            dark
                                            color="purple"
                                            @click="reveal = true"
                                        >
                                            Detalles
                                        </v-btn>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        class="text-center text-md-right"
                                    >
                                        <v-btn
                                            class="mr-0 mr-md-5 mt-4 mt-md-0"
                                            elevation="3"
                                            dark
                                            block
                                            color="indigo"
                                            @click="
                                                submit(
                                                    activity.price_total,
                                                    activity.activity.id
                                                )
                                            "
                                        >
                                            Comprar
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-actions>

                            <v-expand-transition>
                                <v-card
                                    v-if="reveal"
                                    class="transition-fast-in-fast-out v-card--reveal w-min scroll-card"
                                >
                                    <v-card-text class="pb-0 h-455 w-100 h-min">
                                        <p class="fz-lg fw-600">Detalles</p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Nombre:</span
                                            >
                                            <span class="text-dark">{{
                                                activity.activity.title
                                            }}</span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Descripción:</span
                                            >
                                            <span class="text-dark">{{
                                                activity.activity.description
                                            }}</span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Vigencia:</span
                                            >
                                            <span class="text-dark">
                                                {{
                                                    activity.activity.init_date
                                                }}
                                                -
                                                {{
                                                    activity.activity
                                                        .finish_date
                                                }}
                                            </span>
                                        </p>
                                        <p class="fz-md">
                                            <span class="txt-blue-dark fw-800"
                                                >Precio:</span
                                            >
                                            <span class="text-dark">
                                                {{
                                                    activity.price_total | money
                                                }}
                                                /
                                                {{ persons + " personas" }}
                                            </span>
                                        </p>
                                        <p
                                            class="fz-md"
                                            v-show="
                                                activity.activity
                                                    .activities_items.length > 0
                                            "
                                        >
                                            <span class="txt-blue-dark fw-800"
                                                >Actividades incluidas:</span
                                            >
                                        </p>
                                        <ul
                                            v-show="
                                                activity.activity
                                                    .activities_items.length > 0
                                            "
                                        >
                                            <li
                                                v-for="item in activity.activity
                                                    .activities_items"
                                                :key="item.id"
                                            >
                                                {{ item.item.name }}
                                            </li>
                                        </ul>
                                    </v-card-text>
                                    <v-card-actions class="pt-0">
                                        <v-row no-gutters>
                                            <v-col
                                                cols="12"
                                                md="6"
                                                class="text-center text-md-left"
                                            >
                                                <v-btn
                                                    text
                                                    color="purple"
                                                    @click="reveal = false"
                                                >
                                                    Regresar
                                                </v-btn>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="6"
                                                class="text-center text-md-right"
                                            >
                                                <v-btn
                                                    class="mr-0 mr-md-5 mt-4 mt-md-0"
                                                    elevation="3"
                                                    dark
                                                    block
                                                    color="indigo"
                                                    @click="
                                                        submit(
                                                            activity.price_total,
                                                            activity.activity.id
                                                        )
                                                    "
                                                >
                                                    Comprar
                                                </v-btn>
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
export default {
    name: "FilterActivities",
    props: {
        activities: {
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        date: {},
        persons: {},
    },
    data() {
        return {
            model: null,
            reveal: false,
            nowDate: new Date().toISOString().substr(0, 10),
        };
    },
    methods: {
        submit(price, idActivity) {
            this.$swal
                .fire({
                    title: "¡Atención!",
                    text: "¿Desea comprar esta actividad?",

                    icon: "question",
                    confirmButtonColor: "#00D8BF",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Aceptar",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append("total_price", price);
                        formData.append("quantity_person", this.persons);
                        formData.append("reservation_date", this.nowDate);
                        formData.append("activity_date", this.date);
                        formData.append("fk_id_activity", idActivity);

                        let route_submit = route("reservation.create");
                        axios.post(route_submit, formData).then((response) => {
                            if (response.data.success) {
                                this.$swal.fire({
                                    title: "¡Hecho!",
                                    text: "Reservación agregada con éxito.",
                                    confirmButtonText: "Confirmar",
                                    icon: "success",
                                    confirmButtonColor: "#00D8BF",
                                });

                                this.$router.push({ name: "reservations" });
                            } else {
                                this.$swal.fire({
                                    title: "¡Error!",
                                    text: "Algo salió mal.",
                                    confirmButtonText: "Confirmar",
                                    icon: "error",
                                    confirmButtonColor: "#00D8BF",
                                });
                            }
                        });
                    }
                });
        },
    },
    filters: {
        money: function (value) {
            if (!value) return "";
            return value.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
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
