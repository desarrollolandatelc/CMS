<script>
    import GuestLayout from "../../Layouts/GuestLayout.svelte";
    import { Button, Heading } from "flowbite-svelte";

    export let status;
</script>

<GuestLayout>
    <Heading>Verificación del correo electrónico</Heading>
    {#if status}
        <div class="mb-4 font-medium text-sm text-green-600">
            {status}
        </div>
    {/if}
    <div class="mb-4 text-sm text-gray-600">
        ¡Gracias por registrarse! Antes de comenzar, ¿puede verificar su
        dirección de correo electrónico haciendo clic en el enlace? ¿Acabamos de
        enviarle un correo electrónico? Si no recibiste el correo electrónico,
        con gusto te enviaremos otro.
    </div>

    <div
        class="mb-4 font-medium text-sm text-green-600"
        v-if="verificationLinkSent"
    >
        Se ha enviado un nuevo enlace de verificación a la dirección de correo
        electrónico que proporcionó durante el registro.
    </div>
</GuestLayout>
