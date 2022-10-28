<template>
    <div>
        <h1 class="text-center txt-blue-dark txt-header my-5 fw-900">
            Actividades
        </h1>
        <v-container class="my-10">
            <table-component
                :rows="rows"
                :total_rows="total_rows"
                :is_loading="isLoading"
                :toggle_button="true"
                :update_status_url="URL_STATUS"
                :page_size="queryParams.per_page"
                @on-change-query="onChangeQuery"
                :columns="columns"
            >
                <template v-slot:image="{ data }">
                    <img class="img-grid-category my-2" :src="data.image" />
                </template>
                <template v-slot:category="{ data }">
                    <v-select
                        v-model="data.fk_id_category"
                        :items="items"
                        item-text="name"
                        item-value="id"
                        dense
                        class="mt-5"
                        outlined
                        color="#8F9BB9"
                        @change="changeCategory(data.id, data.fk_id_category)"
                    ></v-select>
                </template>
            </table-component>
        </v-container>
    </div>
</template>

<script>
import TableComponent from "../../data-table/TableComponent";
import MixinsTable from "../../mixins/MixinsTable";
export default {
    components: { TableComponent },
    mixins: [MixinsTable],
    name: "IndexActivities",
    created() {
        this.URL_INDEX_CONTENT = route("activities.index_content");
        this.URL_STATUS = route("activities.change_status", { id: "FAKE_ID" });
    },
    data() {
        return {
            isLoading: false,
            columns: [
                {
                    label: "Imagen",
                    name: "image",
                },
                {
                    label: "Título",
                    name: "title",
                    filter: { type: "simple" },
                },
                {
                    label: "Fecha de inicio",
                    name: "init_date",
                    filter: { type: "date" },
                },
                {
                    label: "Fecha de fin",
                    name: "finish_date",
                    filter: { type: "date" },
                },
                {
                    label: "Categoría",
                    name: "category",
                    filter: { type: "select" },
                },
                {
                    label: "Precio",
                    name: "format_total",
                    filter: { type: "simple" },
                },
                {
                    label: "",
                    name: "actions",
                    slot_name: "action-slot",
                },
            ],
            items: [],
            categories: [],
        };
    },
    mounted() {
        this.getAllCategories();
    },
    methods: {
        getAllCategories() {
            let _route = route("categories.all");
            axios
                .get(_route)
                .then((response) => {
                    if (response.data.success) {
                        this.items = response.data.data;
                        this.$set(this.columns[4].filter, "items", this.items);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
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
        changeCategory($id, $selected) {
            const formData = new FormData();
            formData.append("fk_id_category", $selected);
            axios
                .post(
                    route("activities.change_category", { id: $id }),
                    formData
                )
                .then((response) => {
                    if (response.data.success) {
                        this.$swal.fire({
                            title: "¡Lo hizo!",
                            text: "Cambió de categoría con éxito.",
                            confirmButtonText: "Aceptar",
                            icon: "success",
                            confirmButtonColor: "#00D8BF",
                        });
                        bus.$emit("reload-grid");
                    }
                });
        },
    },
};
</script>

<style scoped></style>
