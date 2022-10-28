<template>
    <v-icon v-if="isLoading" class="color-secondary mdi-spin mdi-36px">
        mdi-loading
    </v-icon>

    <v-icon
        v-else-if="dataActive"
        v-on:click="onToggle"
        class="color-secondary cursor-pointer mdi-36px"
    >
        mdi-toggle-switch-outline
    </v-icon>

    <v-icon
        v-else-if="!dataActive"
        v-on:click="onToggle"
        class="grey--text cursor-pointer mdi-36px"
    >
        mdi-toggle-switch-off-outline
    </v-icon>
</template>

<script>
export default {
    name: "ToggleButton",
    props: {
        dataUpdateUrl: {
            required: true,
            type: String,
        },
        entityId: {
            required: true,
        },
        active: {
            required: true,
        },
    },
    data: () => ({
        isLoading: false,
        dataActive: false,
    }),
    mounted() {
        this.dataActive = this.active;
    },
    methods: {
        onToggle() {
            this.$swal
                .fire({
                    title: this.dataActive
                        ? "¿Desea desactivar?"
                        : "¿Desea activar?",
                    text: this.dataActive ? "Podrá volver a ser activado" : "",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#00D8BF",
                    showDenyButton: true,
                    denyButtonText: "Cancelar",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.isLoading = true;
                        let url = this.dataUpdateUrl.replace(
                            "FAKE_ID",
                            this.entityId
                        );
                        axios.post(url).then((response) => {
                            this.isLoading = false;
                            if (response.data.success) {
                                this.dataActive = !this.dataActive;
                                this.$swal.fire({
                                    title: "¡Lo hizo!",
                                    text: "Cambió el estado con éxito.",
                                    confirmButtonText: "Aceptar",
                                    confirmButtonColor: "#00D8BF",
                                });
                            }
                        });
                    } else if (result.isDenied) {
                        this.$swal.fire({
                            title: "¡Cancelado!",
                            text: "Los cambios no fueron aplicados.",
                            confirmButtonText: "Confirmar",
                            color: "#686DF9",
                            confirmButtonColor: "#00D8BF",
                        });
                    }
                });
        },
    },
};
</script>

<style scoped></style>
