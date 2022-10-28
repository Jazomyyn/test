<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="container-fluid">
        <v-simple-table class="bg-gray-blue radius-30">
            <template v-slot:default>
                <thead>
                    <div class="d-inline-flex">
                        <img
                            class="ml-3 mt-2 img-fluid obj-fit"
                            v-if="iconPath != null"
                            :src="iconPath"
                            width="22px"
                            alt=""
                        />
                        <span
                            class="ml-3 mt-3 font-weight-bold d-inline-block titles"
                            v-if="title != null"
                        >
                            {{ title }}
                        </span>
                    </div>
                    <div v-if="optionalComponent">
                        {{ optionalComponent }}
                    </div>
                    <tr>
                        <!--Headers-->
                        <th
                            v-for="column in indexedColumns"
                            :key="column.colId"
                            v-on="
                                isSortableColumn(column)
                                    ? { click: () => updateSortQuery(column) }
                                    : {}
                            "
                        >
                            <div
                                class="d-flex flex-row align-center fw-700 txt-blue-dark"
                            >
                                <span class="text-subtitle-1"
                                    ><b>{{ column.label }}</b></span
                                >

                                <template v-if="isSortableColumn(column)">
                                    <SortIcon
                                        :sort="query.sort"
                                        :column="column"
                                    >
                                        <template slot="vbt-sort-asc-icon">
                                            <slot name="sort-asc-icon">
                                                <i
                                                    class="mdi mdi-menu-down font-z"
                                                ></i>
                                            </slot>
                                        </template>
                                        <template slot="vbt-sort-desc-icon">
                                            <slot name="sort-desc-icon">
                                                <i
                                                    class="mdi mdi-menu-up font-z"
                                                ></i>
                                            </slot>
                                        </template>
                                        <template slot="vbt-no-sort-icon">
                                            <slot name="no-sort-icon">
                                                <i
                                                    class="mdi mdi-menu-swap font-z"
                                                ></i>
                                            </slot>
                                        </template>
                                    </SortIcon>
                                </template>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="th_hov">
                        <!--Filters-->
                        <template v-for="column in indexedColumns">
                            <th
                                v-if="hasFilter(column)"
                                v-bind:style="getFilterCellStyle(column)"
                            >
                                <v-text-field
                                    v-if="column.filter.type == 'simple'"
                                    clearable
                                    solo
                                    background-color="rgb(201 216 255)"
                                    class="set-input"
                                    @keyup.enter="
                                        onUpdateFilter($event, column)
                                    "
                                    @click:clear="clearFilter(column)"
                                    clear-icon="mdi-close-circle"
                                    prepend-inner-icon="mdi-magnify"
                                >
                                </v-text-field>
                                <v-select
                                    v-else-if="column.filter.type == 'select'"
                                    clearable
                                    solo
                                    background-color="rgb(201 216 255)"
                                    class="set-input"
                                    :items="column.filter.items"
                                    item-value="id"
                                    item-text="name"
                                    @change="
                                        onUpdateFilterSelect($event, column)
                                    "
                                    @click:clear="clearFilter(column)"
                                    clear-icon="mdi-close-circle"
                                    prepend-inner-icon="mdi-magnify"
                                >
                                </v-select>
                                <v-text-field
                                    v-if="column.filter.type == 'date'"
                                    background-color="rgb(201 216 255)"
                                    solo
                                    class="setup-input mt-4"
                                    clearable
                                    @keyup.enter="
                                        onUpdateFilter($event, column)
                                    "
                                    @click:clear="clearFilter(column)"
                                    clear-icon="mdi-close-circle"
                                    prepend-inner-icon="mdi-magnify"
                                    type="date"
                                >
                                </v-text-field>
                            </th>

                            <th
                                v-else
                                v-bind:style="getFilterCellStyle(column)"
                            ></th>
                        </template>
                    </tr>
                    <!--Skeleton-->
                    <tr class="th_hov">
                        <td :colspan="columns.length" v-if="is_loading">
                            <v-skeleton-loader type="table-tbody">
                            </v-skeleton-loader>
                        </td>
                    </tr>
                    <!--Data-->
                    <!--If empty-->
                    <tr v-if="rows.length === 0 && !is_loading" class="th_hov">
                        <td
                            :colspan="columns.length"
                            class="text-center text-dark fw-800"
                        >
                            <h4 class="txt-gray">No existen datos</h4>
                        </td>
                    </tr>

                    <TableRow
                        v-for="(row, index) in indexedRows"
                        class="th_hov"
                        v-if="!is_loading"
                        :key="index"
                        :row="row"
                        :columns="indexedColumns"
                    >
                        <template
                            v-for="column in indexedColumns"
                            :slot="'slot-row-' + getCellSlotName(column)"
                        >
                            <slot
                                :name="getCellSlotName(column)"
                                :row="row"
                                :column="column"
                                v-bind:data="row"
                                class="fw-700"
                                :cell_value="getValueFromRow(row, column.name)"
                            >
                                {{ getValueFromRow(row, column.name) }}
                            </slot>

                            <template
                                v-if="getCellSlotName(column) === 'action-slot'"
                            >
                                <toggle-button
                                    :data-update-url="update_status_url"
                                    :entity-id="row.id"
                                    :active="row.active"
                                    v-if="toggle_button"
                                    style="color: #2b4981"
                                >
                                </toggle-button>
                            </template>
                        </template>
                    </TableRow>
                </tbody>
            </template>
        </v-simple-table>

        <div class="row mt-5 mb-10">
            <v-pagination
                color=""
                class="ml-auto"
                v-model="page"
                prev-icon="mdi-menu-left"
                next-icon="mdi-menu-right"
                :length="number_pages"
            >
            </v-pagination>
        </div>
    </div>
</template>

<script>
import SortIcon from "./components/SortIcon";
import TableRow from "./components/TableRow";
import ToggleButton from "./components/ToggleButton";

export default {
    name: "TableComponent",
    props: {
        rows: {
            type: Array,
            required: true,
        },
        columns: {
            type: Array,
            required: true,
        },
        total_rows: {
            required: true,
        },
        is_loading: {
            type: Boolean,
            required: true,
        },
        toggle_button: {
            type: Boolean,
            required: false,
            default: function () {
                return false;
            },
        },
        title: {
            type: String,
            required: false,
            default: function () {
                return null;
            },
        },
        optionalComponent: {
            required: false,
            default: function () {
                return null;
            },
        },
        iconPath: {
            type: String,
            required: false,
            default: function () {
                return null;
            },
        },
        update_status_url: {
            type: String,
            required: false,
        },
        page_size: {
            required: false,
            default: function () {
                return 10;
            },
        },
    },
    methods: {
        hasFilter(column) {
            return (
                column.filter !== undefined && column.filter.type !== undefined
            );
        },
        isSortableColumn(column) {
            if (column.sort === null || column.sort === undefined) {
                return false;
            } else {
                return column.sort;
            }
        },
        getCellSlotName(column) {
            if (column.slot_name !== null && column.slot_name !== undefined) {
                return column.slot_name;
            }
            return column.name.replace(/\./g, "_");
        },
        getValueFromRow(row, name) {
            let paths = name.split("."),
                current = row,
                i;

            for (i = 0; i < paths.length; ++i) {
                // noinspection EqualityComparisonWithCoercionJS
                if (current[paths[i]] == undefined) {
                    return undefined;
                } else {
                    current = current[paths[i]];
                }
            }
            return current;
        },
        onUpdateFilter(e, column) {
            let newFilter = {
                colId: column.colId,
                name: column.name,
                text: e.target.value,
            };
            let indexFind = 0;
            let filter = this.query.filters.filter((_filter, index) => {
                if (_filter.colId === column.colId) {
                    indexFind = index;
                    return true;
                }
            });

            if (filter.length === 0) {
                this.query.filters.push(newFilter);
            } else {
                this.query.filters[indexFind] = newFilter;
            }

            this.emitQueryParams(0);
        },
        onUpdateFilterSelect(e, column) {
            let newFilter = {
                colId: column.colId,
                name: column.name,
                text: e,
            };
            let indexFind = 0;
            let filter = this.query.filters.filter((_filter, index) => {
                if (_filter.colId === column.colId) {
                    indexFind = index;
                    return true;
                }
            });

            if (filter.length === 0) {
                this.query.filters.push(newFilter);
            } else {
                this.query.filters[indexFind] = newFilter;
            }

            this.emitQueryParams(0);
        },
        onUpdateFilterDate(e, column) {
            console.log(e, column);
            let newFilter = {
                colId: column.colId,
                name: column.name,
                text: e,
            };
            let indexFind = 0;
            let filter = this.query.filters.filter((_filter, index) => {
                if (_filter.colId === column.colId) {
                    indexFind = index;
                    return true;
                }
            });

            if (filter.length === 0) {
                this.query.filters.push(newFilter);
            } else {
                this.query.filters[indexFind] = newFilter;
            }

            this.emitQueryParams(0);
        },
        clearFilter(column) {
            this.query.filters = this.query.filters.filter(
                (_filter) => _filter.colId !== column.colId
            );
            this.emitQueryParams();
        },
        clearFilterDate(column) {
            this.query.filters = this.query.filters.filter(
                (_filter) => _filter.colId !== column.colId
            );
            this.date = "";
            this.emitQueryParams();
        },
        emitQueryParams(page = null) {
            let queryParams = { ...this.query };

            let payload = {
                sort: queryParams.sort,
                filters: queryParams.filters,
                per_page: this.per_page,
                page: page === null ? this.page - 1 : page,
            };

            this.$emit("on-change-query", payload);
        },
        updateSortQuery(column) {
            //Can sort by one column
            //If need sort by multiple, send config param

            let indexFind = 0;
            let sort = this.query.sort.filter((_sort, index) => {
                if (_sort.colId === column.colId) {
                    indexFind = index;
                    return true;
                }
            });

            if (sort.length === 0) {
                //Remove Other Filters
                this.query.sort = [];

                this.query.sort.push({
                    colId: column.colId,
                    name: column.name,
                    order: "ASC",
                });
            } else {
                this.query.sort[indexFind].order =
                    this.query.sort[indexFind].order === "ASC" ? "DESC" : "ASC";
            }
            this.emitQueryParams();
        },
        getFilterCellStyle(column) {
            if (
                column.filter !== undefined &&
                column.filter.th_style !== undefined
            ) {
                return column.filter.th_style;
            }
            return {};
        },
    },
    data: function () {
        return {
            indexedRows: [],
            indexedColumns: [],
            page: 1,
            per_page: 15,
            route: "",
            number_pages: 1,
            query: {
                sort: [],
                filters: [],
            },
            date: null,
        };
    },
    mounted() {
        this.route = this.$route.name;
        this.indexedColumns = [...this.columns];
        this.indexedRows = [...this.rows];
        this.indexedRows = [...this.rows];
        this.per_page = this.page_size;

        this.indexedColumns = this.indexedColumns.map(function (
            element,
            index
        ) {
            element.colId = index + 1;
            return element;
        });

        this.emitQueryParams();
    },
    watch: {
        columns: {
            handler: function (newVal, oldVal) {
                this.indexedColumns = [...this.columns];
                this.indexedColumns = this.indexedColumns.map(function (
                    element,
                    index
                ) {
                    element.colId = index + 1;
                    return element;
                });
            },
            deep: true,
        },
        rows: {
            handler: function (newVal, oldVal) {
                this.indexedRows = [...this.rows];
                let number_pages = this.total_rows / this.per_page;
                if (number_pages % 1 === 0) {
                    this.number_pages = number_pages;
                } else {
                    number_pages = number_pages - (number_pages % 1);
                    this.number_pages = number_pages + 1;
                }
            },
            deep: true,
        },
        page: {
            handler: function (newVal, oldVal) {
                this.emitQueryParams();
            },
            deep: true,
        },
    },
    components: {
        SortIcon,
        ToggleButton,
        TableRow,
    },
    computed: {
        dateFormat() {
            if (this.date !== null) {
                let date = new Date(this.date);
                return (
                    date.getDate() +
                    1 +
                    "-" +
                    (date.getMonth() + 1) +
                    "-" +
                    date.getFullYear()
                );
            }
            return "";
        },
    },
};
</script>

<style>
.cursor-pointer {
    cursor: pointer;
}
.bg-gray-blue {
    background-color: rgb(215 218 226) !important;
}
.set-input {
    margin-top: 1rem !important;
}
.min-h {
    min-height: 75% !important;
}
.obj-fit {
    object-fit: contain !important;
}
.titles {
    font-size: 1.2rem !important;
    white-space: nowrap !important;
}
.font-z {
    font-size: 1.4rem !important;
}
.radius-30 {
    border-radius: 30px !important;
}
</style>
