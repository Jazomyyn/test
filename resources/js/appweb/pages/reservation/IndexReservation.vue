<template>
    <div>
        <h1 class="text-center txt-blue-dark txt-header my-5 fw-900">
            Reservaciones
        </h1>
        <v-container>
            <table-component
                :rows="rows"
                :total_rows="total_rows"
                :is_loading="isLoading"
                :toggle_button="false"
                :page_size="queryParams.per_page"
                @on-change-query="onChangeQuery"
                :columns="columns"
            >
            </table-component>
        </v-container>
    </div>
</template>

<script>
import TableComponent from "../../data-table/TableComponent";
import MixinsTable from "../../mixins/MixinsTable";
export default {
    name: "IndexReservation",
    components: { TableComponent },
    mixins: [MixinsTable],
    data() {
        return {
            isLoading: false,
            columns: [
                {
                    label: "Actividad",
                    name: "activity.title",
                    filter: { type: "simple" },
                },
                {
                    label: "Cantidad de personas",
                    name: "quantity_person",
                    filter: { type: "simple" },
                },
                {
                    label: "Precio total",
                    name: "format_total",
                    filter: { type: "simple" },
                },
                {
                    label: "Día de la actividad",
                    name: "activity_date",
                    filter: { type: "date" },
                },
                {
                    label: "Fecha de reservación",
                    name: "reservation_date",
                    filter: { type: "simple" },
                },
                {
                    label: "",
                    name: "actions",
                    slot_name: "action-slot",
                },
            ],
        };
    },
    created() {
        this.URL_INDEX_CONTENT = route("reservation.index_content");
    },

    methods: {
        fetchData(preventSpinner = false) {
            let params = this.prepareParams(preventSpinner);
            this.queryParams.page = 0;
            this.page = 0;
            axios
                .get(this.URL_INDEX_CONTENT, { params: params })
                .then((response) => {
                    this.isLoading = false;
                    this.rows = response.data.data;
                    this.total_rows = response.data.count;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        onChangeQuery(queryParams) {
            this.queryParams = queryParams;
            this.fetchData();
        },
    },
};
</script>

<style scoped></style>
