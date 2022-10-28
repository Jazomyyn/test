<template>
    <div>
        <h1 class="text-center txt-blue-dark txt-header my-5 fw-900">
            ¿Te gusta salir de la rutina?
        </h1>
        <v-container class="image-banner" fluid>
            <h3 class="text-white fw-600 mt-5 ms-5">
                ¡Te proporcionamos las mejores actividades!
            </h3>
            <div>
                <v-form ref="form" lazy-validation>
                    <v-container
                        class="border border-warning rounded ms-5 w-70 mt-5 bg-transparent"
                    >
                        <v-row no-gutters>
                            <v-col cols="12">
                                <div class="mb-3 text-dark fw-600">
                                    Selecciona la fecha en que quieres realizar
                                    la actividad:
                                </div>
                            </v-col>
                            <v-col cols="12" class="px-5">
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="date"
                                            append-icon="mdi-calendar"
                                            :rules="rules.date"
                                            readonly
                                            dense
                                            solo
                                            color="#2B4981"
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="date"
                                        color="#2B4981"
                                        :min="nowDate"
                                        scrollable
                                        locale="es-MX"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="#2B4981"
                                            @click="menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="#2B4981"
                                            @click="$refs.menu.save(date)"
                                        >
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12">
                                <div class="mb-3 text-dark fw-600">
                                    Selecciona la cantidad de personas que irán:
                                </div>
                            </v-col>
                            <v-col cols="12" class="px-5">
                                <v-text-field
                                    v-model="quantityPerson"
                                    append-icon="mdi-account-supervisor"
                                    :rules="rules.persons"
                                    dense
                                    type="number"
                                    min="1"
                                    solo
                                    color="#2B4981"
                                ></v-text-field>
                            </v-col>

                            <v-col class="text-center mt-2" cols="12">
                                <v-btn
                                    class="px-5 py-2 mb-2 fw-bolder"
                                    :loading="loading"
                                    dark
                                    @click="submit"
                                >
                                    Buscar actividades
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </div>
        </v-container>
        <div class="text-right pe-5" v-if="isFilter">
            <v-btn
                class="px-5 my-4 fw-bolder"
                outlined
                color="purple darken-2"
                @click="seeAll"
            >
                Ver todas
            </v-btn>
        </div>
        <div :class="!isFilter ? 'd-block' : 'd-none'">
            <all-activities
                title="Todas las actividades"
                :activities="activities"
            ></all-activities>
            <all-activities
                v-for="category in categories"
                :key="category.id"
                :title="'Actividades de ' + category.name"
                :with-category="true"
                :id-category="category.id"
                :activities="activities"
            ></all-activities>
        </div>
        <div v-if="isFilter">
            <filter-activities
                title="Actividades a tu medida"
                :date="date"
                :persons="quantityPerson"
                :activities="activitiesFilter"
            ></filter-activities>
        </div>
    </div>
</template>

<script>
import AllActivities from "../../components/home/AllActivities";
import FilterActivities from "../../components/home/FilterActivities";
export default {
    name: "IndexHome",
    components: { AllActivities, FilterActivities },
    data() {
        return {
            menu: false,
            loading: false,

            quantityPerson: "",
            date: "",

            nowDate: new Date().toISOString().substr(0, 10),

            rules: {
                date: [(v) => !!v || "La fecha es necesaria."],
                persons: [
                    (v) => !!v || "La cantidad de personas es necesaria.",
                    (v) =>
                        (v && v >= 1) ||
                        "El mínimo de personas es 1, elija una cantidad válida.",
                ],
            },

            activities: null,
            activitiesFilter: null,
            categories: null,
            isFilter: false,
            withCategory: false,
            idCategory: "",
        };
    },
    mounted() {
        this.getAllActivities();
        this.getAllCategories();
    },

    methods: {
        seeAll() {
            this.$refs.form.reset();
            this.isFilter = false;
        },
        submit() {
            let valid = this.$refs.form.validate();
            if (valid) {
                this.loading = true;
                axios
                    .get(
                        route("activities.home_filter", {
                            date: this.date,
                            person: this.quantityPerson,
                        })
                    )
                    .then((response) => {
                        this.loading = false;
                        this.isFilter = true;
                        this.activitiesFilter = response.data.data;

                        window.scrollTo(0, 500);
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.$swal.fire({
                            title: "¡Error!",
                            text: "No encontramos actividades para ti.",
                            confirmButtonText: "Confirmar",
                            icon: "error",
                            confirmButtonColor: "#00D8BF",
                        });
                    });
            }
        },

        getAllActivities() {
            let _route = route("activities.all");
            axios
                .get(_route)
                .then((response) => {
                    if (response.data.success) {
                        this.activities = response.data.data;
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.$swal.fire({
                        title: "¡Error!",
                        text: "No encontramos actividades para ti.",
                        confirmButtonText: "Confirmar",
                        icon: "error",
                        confirmButtonColor: "#00D8BF",
                    });
                });
        },
        getAllCategories() {
            let _route = route("categories.all");
            axios
                .get(_route)
                .then((response) => {
                    if (response.data.success) {
                        this.categories = response.data.data;
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.$swal.fire({
                        title: "¡Error!",
                        text: "No encontramos actividades para ti.",
                        confirmButtonText: "Confirmar",
                        icon: "error",
                        confirmButtonColor: "#00D8BF",
                    });
                });
        },
    },
};
</script>

<style scoped></style>
