<template>
    <footer class="container-fluid bg-white footer-position mt-10">
        <p class="text-center txt-gray pt-2">
            Jeniffer Jazmyn | Mi prueba - Todos los derechos reservados
            {{ this.year }}.
        </p>
    </footer>
</template>
<script>
export default {
    name: "Footer",
    data: () => ({
        year: new Date().getFullYear(),
    }),
};
</script>
