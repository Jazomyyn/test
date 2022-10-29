<template>
    <div>
        <h1 class="text-center txt-blue-dark txt-header my-5 fw-900">
            Categorías
        </h1>
        <v-container class="w-50 cat">
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
    components: { TableComponent },
    mixins: [MixinsTable],
    name: "IndexCategories",
    data() {
        return {
            isLoading: false,
            columns: [
                {
                    label: "Nombre de la categoría",
                    name: "name",
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
        this.URL_INDEX_CONTENT = route("categories.index_content");
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
