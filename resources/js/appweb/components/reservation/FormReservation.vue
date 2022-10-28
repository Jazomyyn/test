<template>
    <v-dialog v-model="dialog" width="500" persistent>
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                class="mr-5"
                elevation="3"
                dark
                v-on="on"
                color="indigo"
                v-bind="attrs"
            >
                Hacer reservación
            </v-btn>
        </template>

        <v-card :outlined="true" class="bg-blue-dark">
            <v-form ref="form" lazy-validation>
                <v-container>
                    <v-row class="justify-center" no-gutters>
                        <v-row class="justify-end">
                            <v-col cols="1">
                                <v-icon dark @click="goBack" class="m-1">{{
                                    "mdi-close"
                                }}</v-icon>
                            </v-col>
                        </v-row>
                        <v-col cols="12" class="text-center">
                            <v-card-title
                                class="d-flex justify-content-center p-0 txt-beige"
                            >
                                <div>Hacer reservación</div>
                            </v-card-title>
                            <v-divider></v-divider>
                        </v-col>
                        <v-img :src="data.image" height="150"></v-img>

                        <v-col cols="11" class="mt-5 mb-3">
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
                                        label="Selecciona una fecha"
                                        readonly
                                        dense
                                        solo
                                        color="#0FA5E8"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="date"
                                    color="#0FA5E8"
                                    :min="nowDate"
                                    scrollable
                                    locale="es-MX"
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="#0FA5E8"
                                        @click="menu = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="#0FA5E8"
                                        @click="
                                            $refs.menu.save(date);
                                            validateActivity;
                                        "
                                    >
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="11" class="mb-3">
                            <v-text-field
                                v-model="quantityPerson"
                                append-icon="mdi-account-supervisor"
                                :rules="rules.persons"
                                dense
                                type="number"
                                min="1"
                                solo
                                @input="validateActivity"
                                label="¿Para cuántas personas?"
                                color="#2B4981"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="11">
                            <p class="fz-md">
                                <span class="txt-gray-dark fw-800"
                                    >Nombre:</span
                                >
                                <span class="txt-beige">{{ data.title }}</span>
                            </p>

                            <p class="fz-md">
                                <span class="txt-gray-dark fw-800"
                                    >Vigencia:</span
                                >
                                <span class="txt-beige">
                                    {{ data.init_date }} -
                                    {{ data.finish_date }}
                                </span>
                            </p>

                            <p
                                class="fz-md"
                                v-show="data.activities_items.length > 0"
                            >
                                <span class="txt-gray-dark fw-800"
                                    >Actividades incluidas:</span
                                >
                            </p>
                            <ul
                                v-show="data.activities_items.length > 0"
                                class="txt-beige"
                            >
                                <li
                                    v-for="item in data.activities_items"
                                    :key="item.id"
                                >
                                    {{ item.item.name }}
                                </li>
                            </ul>
                            <p class="fz-lg text-right">
                                <span class="txt-beige fw-900"
                                    >Precio total:</span
                                >
                                <span class="txt-beige fw-900">{{
                                    price | money
                                }}</span>
                            </p>
                        </v-col>

                        <v-col class="text-center px-5" cols="12">
                            <v-btn
                                class="text-capitalize bg-green fw-700"
                                large
                                :disabled="disable"
                                :loading="loading"
                                block
                                @click="submit"
                            >
                                Comprar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "FormReservation",
    props: {
        data: {
            type: Object,
        },
    },

    created() {},

    data() {
        return {
            dialog: false,
            loading: false,
            disable: false,

            quantityPerson: "",
            date: "",
            menu: false,

            isValid: false,
            price: 0,

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
        };
    },
    methods: {
        validateActivity() {
            let valid = this.$refs.form.validate();
            if (valid) {
                axios
                    .get(
                        route("activities.validate_calculate", {
                            date: this.date,
                            quantityPersons: this.quantityPerson,
                            idActivity: this.data.id,
                        })
                    )
                    .then((response) => {
                        if (response.data.data.isValid) {
                            this.isValid = true;
                            this.price = response.data.data.price;
                        } else {
                            this.isValid = false;
                            this.price = 0;
                            this.$refs.form.reset();
                            this.$swal.fire({
                                title: "¡Lo sentimos!",
                                text: "Esta actividad no está disponible en tu fecha deseada. Intenta con otra.",
                                confirmButtonText: "Confirmar",
                                icon: "error",
                                confirmButtonColor: "#00D8BF",
                            });
                        }
                    })
                    .catch((error) => {
                        this.disable = true;
                        this.isValid = false;
                        this.price = 0;
                        this.$refs.form.reset();
                        this.$swal.fire({
                            title: "¡Error!",
                            text: "Algo salió mal",
                            confirmButtonText: "Confirmar",
                            icon: "error",
                            confirmButtonColor: "#00D8BF",
                        });
                    });
            }
        },
        submit() {
            let valid = this.$refs.form.validate();
            if (valid && this.isValid) {
                const formData = new FormData();
                formData.append("total_price", this.price);
                formData.append("quantity_person", this.quantityPerson);
                formData.append("reservation_date", this.nowDate);
                formData.append("activity_date", this.date);
                formData.append("fk_id_activity", this.data.id);

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
                        this.loading = false;
                        this.dialog = false;
                        this.isValid = false;
                        this.price = 0;
                        this.$refs.form.reset();
                        this.$router.push({ name: "reservations" });
                    } else {
                        this.loading = false;
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
        },

        goBack() {
            this.dialog = false;
            this.price = 0;
            this.disable = false;
            this.$refs.form.reset();
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

<style scoped></style>
