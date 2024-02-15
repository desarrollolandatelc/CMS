<script lang="ts">
    import { router } from "@inertiajs/svelte";
    import { Button } from "flowbite-svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let url: string = "";

    const deleteProvider = () => {
        const confirm = window.confirm(
            "¿Desea eliminar el registro seleccionado?",
        );
        if (!confirm) {
            return;
        }
        router.delete(`${url}`, {
            onSuccess: () => {
                toasts.success({
                    description: "Se ha eliminado el registro correctamente",
                });
            },
        });
    };
</script>

<Button size="xs" color="red" on:click={deleteProvider}>Eliminar</Button>
<ToastContainer placement="bottom-right" let:data>
    <FlatToast {data} />
</ToastContainer>
