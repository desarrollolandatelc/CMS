<script lang="ts">
    import { router } from "@inertiajs/svelte";
    import { Button } from "flowbite-svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let data;

    const deleteProvider = () => {
        const confirm = window.confirm("¿Desea eliminar el proveedor?");
        if (!confirm) {
            return;
        }
        router.delete(`/admin/providers/${data.id}`, {
            onSuccess: () => {
                toasts.success({
                    description: "Se ha eliminado el proveedor correctamente",
                });
            },
        });
    };
</script>

<a
    href="/admin/providers/{data.id}/edit"
    class="font-medium text-primary-600 hover:underline dark:text-primary-500"
>
    Editar
</a>
<Button size="xs" color="red" on:click={deleteProvider}>Eliminar</Button>
<ToastContainer placement="bottom-right" let:data>
    <FlatToast {data} />
</ToastContainer>
